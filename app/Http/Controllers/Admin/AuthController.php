<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class AuthController extends Controller
{
    public function index(){
        return redirect()->route('admin.dashboard');
    }
    // Login pages
    public function loginPage()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string','min:6'],
        ]);

        if (!Auth::attempt($request->only('email','password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if (!$user->is_admin) {
            Auth::logout();
            abort(403,'Unauthorized');
        }

        // If 2FA enabled, require it unless remembered
        if ($user->two_factor_enabled) {
            // clear session flag; it will be set after success
            session()->forget('admin_2fa_passed');
            return redirect()->route('admin.2fa.page');
        }

        return redirect()->route('admin.dashboard');
    }

    // Show 2FA page
    public function twoFactorPage(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
    
        // Force setup if admin never confirmed 2FA
        $needsSetup = !$user->two_factor_confirmed_at;
    
        $qrUrl = null;
        $secret = null;
    
        if ($needsSetup) {
            $google2fa = new \PragmaRX\Google2FA\Google2FA();
            $secret = $google2fa->generateSecretKey();
    
            $user->two_factor_secret = Crypt::encryptString($secret);
            // Notice: two_factor_enabled still FALSE here
            $user->save();
    
            $company = 'The Village Admin';
            $email   = $user->email;
            $otpauth = $google2fa->getQRCodeUrl($company, $email, $secret);
    
            $qrUrl = "https://quickchart.io/qr?text=" . urlencode($otpauth);
        }
    
        return view('admin.auth.2fa', [
            'needsSetup' => $needsSetup,
            'qrUrl'      => $qrUrl,
            'secret'     => $secret,
        ]);
    }
    
    public function verifyTwoFactor(Request $request)
    {
        $request->validate([
            'code' => ['required','digits:6'],
            'remember_device' => ['nullable','boolean'],
        ]);
    
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
    
        $google2fa = new \PragmaRX\Google2FA\Google2FA();
        $secret = $user->two_factor_secret ? Crypt::decryptString($user->two_factor_secret) : null;
    
        if (!$secret) {
            return back()->withErrors(['code' => '2FA not initialized.']);
        }
    
        $valid = $google2fa->verifyKey($secret, $request->input('code'));
        if (!$valid) {
            return back()->withErrors(['code' => 'Invalid 2FA code.']);
        }
    
        if (!$user->two_factor_enabled) {
            $user->two_factor_enabled = true;
            $user->two_factor_confirmed_at = now();
            $user->save();
        }
    
        // Mark session as passed
        session(['admin_2fa_passed' => true]);
    
        // Trust device for 7 days if checked
        if ($request->boolean('remember_device')) {
            $cookieName = "admin_2fa_remember_{$user->id}";
            Cookie::queue(cookie(
                $cookieName, '1', 60*24*7,
                null, null, false, true, false, 'Lax'
            ));
        }
    
        // Go to intended or dashboard
        $intended = session('admin_intended');
        session()->forget('admin_intended');
    
        return redirect($intended ?? route('admin.dashboard'));
    }
    

    public function enable2fa(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->is_admin) abort(403);
        $user->two_factor_enabled = true;
        $user->save();

        return back()->with('status', '2FA enabled, please scan and verify.');
    }

    public function disable2fa(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->is_admin) abort(403);
        $user->two_factor_enabled = false;
        $user->two_factor_secret = null;
        $user->two_factor_confirmed_at = null;
        $user->save();

        Cookie::queue(Cookie::forget("admin_2fa_remember_{$user->id}"));

        session()->forget('admin_2fa_passed');
        return back()->with('status', '2FA disabled.');
    }

    public function logout()
    {
        $user = Auth::user();
        if ($user) {
            Cookie::queue(Cookie::forget("admin_2fa_remember_{$user->id}"));
        }
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    }
}
