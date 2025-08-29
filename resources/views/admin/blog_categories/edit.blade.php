@extends('admin.layouts.app')

@section('title','Edit Blog Category')

@section('content')
<div class="card-soft">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Edit Blog Category</h5>
    <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-arrow-left me-1"></i> Back
    </a>
  </div>

  @if(session('status'))
    <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
  @endif

  <form action="{{ route('admin.blog-categories.update',$category->id) }}" method="POST" class="row g-3">
    @csrf @method('PATCH')

    <div class="col-md-6">
      <label class="form-label">Name (EN)</label>
      <input type="text" name="name" class="form-control" value="{{ old('name',$category->name) }}" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Name (AR)</label>
      <input type="text" name="name_ar" class="form-control" dir="rtl" value="{{ old('name_ar',$category->name_ar) }}" required>
    </div>

    <div class="col-12">
      <button class="btn btn-gold">Update Category</button>
      <a href="{{ route('admin.blog-categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
