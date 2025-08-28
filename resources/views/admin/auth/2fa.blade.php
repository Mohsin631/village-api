@extends('admin.auth.layout')

@section('title','Admin 2FA')
@section('form_title','Two-Factor Authentication')
@section('brand_title','Secure Access')
@section('brand_subtitle','Two-Factor Authentication Required')

@section('form')

@if(session('status'))
  <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
@endif

@if($needsSetup)
  <div class="alert alert-info text-center">
    <strong>Setup required:</strong><br>
    Scan this QR code with Google Authenticator or another TOTP app:
    <div class="mt-3">
      <img src="{{ $qrUrl }}" alt="QR Code" class="img-fluid" style="max-width:200px;">
    </div>
    <div class="mt-3 small">
      Or enter this secret manually: <strong>{{ $secret }}</strong>
    </div>
  </div>
@endif



<form action="{{ route('admin.2fa.verify') }}" method="POST" novalidate>
  @csrf
  <div class="mb-3">
    <label class="form-label">Enter 6-digit code</label>
    <input type="text" name="code" inputmode="numeric" pattern="[0-9]*" maxlength="6"
           class="form-control text-center" required>
  </div>

  <div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" value="1" id="remember_device" name="remember_device">
    <label class="form-check-label" for="remember_device">
      Trust this device for 7 days
    </label>
  </div>

  <button type="submit" class="btn btn-gold w-100 mt-2">Verify</button>
</form>
@endsection
