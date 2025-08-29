@extends('admin.layouts.app')

@section('title','My Profile')

@section('content')
<div class="card-soft">
  <h5 class="mb-3">My Profile</h5>

  @if(session('status'))
    <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
  @endif

  <form action="{{ route('admin.profile.update') }}" method="POST" class="row g-3">
    @csrf

    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input type="text" name="name" value="{{ old('name',$user->name) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Email (cannot be changed)</label>
      <input type="email" value="{{ $user->email }}" class="form-control" disabled>
    </div>

    <div class="col-md-6">
      <label class="form-label">New Password</label>
      <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
    </div>

    <div class="col-md-6">
      <label class="form-label">Confirm Password</label>
      <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
    </div>

    <div class="col-12">
      <button class="btn btn-gold">Update Profile</button>
    </div>
  </form>
</div>
@endsection
