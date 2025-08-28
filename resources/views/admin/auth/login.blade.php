@extends('admin.auth.layout')

@section('title','Admin Login')
@section('form_title','Admin Login')

@section('form')
<form action="{{ route('admin.login.submit') }}" method="POST" novalidate>
  @csrf
  <div class="mb-3">
    <label class="form-label">Email Address</label>
    <input type="email" name="email" class="form-control" required autofocus>
  </div>

  <div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>

  <button type="submit" class="btn btn-gold w-100 mt-2">Login</button>
</form>
@endsection
