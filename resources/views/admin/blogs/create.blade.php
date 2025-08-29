@extends('admin.layouts.app')

@section('title','Add Blog')

@section('content')
<div class="card-soft">
  <h5 class="mb-3">Add Blog</h5>

  <form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data" class="row g-3">
    @csrf

    <div class="col-md-6">
      <label class="form-label">Title (EN)</label>
      <input type="text" name="title" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Title (AR)</label>
      <input type="text" name="title_ar" class="form-control" dir="rtl" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Short Description (EN)</label>
      <input type="text" name="short_description" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Short Description (AR)</label>
      <input type="text" name="short_description_ar" class="form-control" dir="rtl" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Long Description (EN)</label>
      <textarea name="long_description" rows="5" class="form-control" required></textarea>
    </div>
    <div class="col-md-6">
      <label class="form-label">Long Description (AR)</label>
      <textarea name="long_description_ar" rows="5" class="form-control" dir="rtl" required></textarea>
    </div>

    <div class="col-md-6">
      <label class="form-label">Category</label>
      <select name="blog_category_id" class="form-select">
        <option value="">— None —</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Cover Image</label>
      <input type="file" name="cover_image" class="form-control" required>
    </div>

    <div class="col-12">
      <button class="btn btn-gold">Save Blog</button>
      <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
