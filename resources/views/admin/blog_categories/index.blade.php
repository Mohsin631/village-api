@extends('admin.layouts.app')

@section('title','Blog Categories')

@section('content')
<div class="card-soft">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Blog Categories</h5>
    <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#createModal">
      <i class="bi bi-plus-lg"></i> Add Category
    </button>
  </div>

  @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif

  <table class="table align-middle">
    <thead>
      <tr>
        <th>#</th><th>Name (EN)</th><th>Name (AR)</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($categories as $c)
      <tr>
        <td>{{ $c->id }}</td>
        <td>{{ $c->name }}</td>
        <td>{{ $c->name_ar }}</td>
        <td>
          <a href="{{ route('admin.blog-categories.edit',$c->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
          <form action="{{ route('admin.blog-categories.destroy',$c->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="{{ route('admin.blog-categories.store') }}">
      @csrf
      <div class="modal-header"><h5 class="modal-title">New Category</h5></div>
      <div class="modal-body">
        <div class="mb-3"><label>Name (EN)</label><input name="name" class="form-control" required></div>
        <div class="mb-3"><label>Name (AR)</label><input name="name_ar" class="form-control" required></div>
      </div>
      <div class="modal-footer"><button class="btn btn-gold">Save</button></div>
    </form>
  </div>
</div>
@endsection
