@extends('admin.layouts.app')

@section('title','Site Settings')

@section('content')
<div class="card-soft">
  <h5 class="mb-3">Contact & Social Settings</h5>

  @if(session('status'))
    <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
  @endif

  <form action="{{ route('admin.settings.update') }}" method="POST" class="row g-3">
    @csrf

    <div class="col-md-6">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" value="{{ old('phone',$values['phone']) }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="email" value="{{ old('email',$values['email']) }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Location</label>
      <input type="text" name="location" value="{{ old('location',$values['location']) }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Google Maps URL</label>
      <input type="url" name="location_google_maps" value="{{ old('location_google_maps',$values['location_google_maps']) }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">LinkedIn</label>
      <input type="url" name="linkedin" value="{{ old('linkedin',$values['linkedin']) }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">YouTube</label>
      <input type="url" name="youtube" value="{{ old('youtube',$values['youtube']) }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Twitter</label>
      <input type="url" name="twitter" value="{{ old('twitter',$values['twitter']) }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">TikTok</label>
      <input type="url" name="tiktok" value="{{ old('tiktok',$values['tiktok']) }}" class="form-control">
    </div>

    <div class="col-md-6">
      <label class="form-label">Instagram</label>
      <input type="url" name="instagram" value="{{ old('instagram',$values['instagram']) }}" class="form-control">
    </div>

    <div class="col-12">
      <button class="btn btn-gold">Save Settings</button>
    </div>
  </form>
</div>
@endsection
