@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
  <h1 class="mb-4">Dashboard</h1>

  <div class="row">
    <div class="col-md-4">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h5 class="card-title text-brown">Users</h5>
          <p class="card-text">123 registered users</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h5 class="card-title text-brown">Inquiries</h5>
          <p class="card-text">45 new inquiries</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h5 class="card-title text-brown">Subscribers</h5>
          <p class="card-text">78 newsletter subs</p>
        </div>
      </div>
    </div>
  </div>
@endsection
