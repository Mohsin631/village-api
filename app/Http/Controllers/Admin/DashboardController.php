<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsletterSubscription as Newsletter;
use App\Models\ContactMessage;
use App\Models\Subscription;
use App\Models\RetailApplication;
use App\Models\Career;
use App\Models\RecentActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        // Newsletter
        $totalNewsletter     = Newsletter::count();
        $newsletterThisWeek  = Newsletter::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $newsletterPercent = $totalNewsletter > 0 ? round(($newsletterThisWeek / $totalNewsletter) * 100) : 0;

        // Inquries
        $totalInquiries      = ContactMessage::count();
        $inquiriesToday      = ContactMessage::whereDate('created_at', today())->count();
        $inquiriesPercent = $totalInquiries > 0 ? round(($inquiriesToday / $totalInquiries) * 100) : 0;

        // Subsribers
        $totalSubscribers    = Subscription::count();
        $subscribersThisWeek = Subscription::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $subscribersPercent = $totalSubscribers > 0 ? round(($subscribersThisWeek / $totalSubscribers) * 100) : 0;

        // Roles
        $openRoles = Career::where('status','active')->count();
        $newRoles  = Career::where('status','active')
                        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                        ->count();
        $rolesPercent = $openRoles > 0 ? round(($newRoles / $openRoles) * 100) : 0;

        // Recent Activity
        $recentActivity = RecentActivity::latest()->take(10)->get();

        // Chart data

        // Newsletter signups in last 30 days
        $newsletterData = Newsletter::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as total')
        )->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('total','date');

        // Inquiries in last 30 days
        $inquiriesData = ContactMessage::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as total')
        )->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('total','date');

        // Subscribers in last 30 days
        $subscribersData = Subscription::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as total')
        )->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->pluck('total','date');

        return view('admin.dashboard', compact(
            'totalNewsletter','newsletterThisWeek','newsletterPercent',
            'totalInquiries','inquiriesToday','inquiriesPercent',
            'totalSubscribers','subscribersThisWeek','subscribersPercent',
            'openRoles','newRoles','rolesPercent',
            'recentActivity','newsletterData','inquiriesData','subscribersData'
        ));
    }
}
