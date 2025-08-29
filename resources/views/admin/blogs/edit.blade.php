@extends('admin.layouts.app')

@section('title','Edit Blog')

@section('content')
<div class="card-soft">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Edit Blog</h5>
    <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-arrow-left me-1"></i> Back
    </a>
  </div>

  @if(session('status'))
    <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('admin.blogs.update',$blog->id) }}" enctype="multipart/form-data" class="row g-3">
    @csrf @method('PATCH')

    <div class="col-md-6">
      <label class="form-label">Title (EN)</label>
      <input type="text" name="title" class="form-control" value="{{ old('title',$blog->title) }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Title (AR)</label>
      <input type="text" name="title_ar" class="form-control" dir="rtl" value="{{ old('title_ar',$blog->title_ar) }}" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Short Description (EN)</label>
      <input type="text" name="short_description" class="form-control" value="{{ old('short_description',$blog->short_description) }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Short Description (AR)</label>
      <input type="text" name="short_description_ar" class="form-control" dir="rtl" value="{{ old('short_description_ar',$blog->short_description_ar) }}" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Long Description (EN)</label>
      <textarea name="long_description" rows="6" class="form-control" required>{{ old('long_description',$blog->long_description) }}</textarea>
    </div>
    <div class="col-md-6">
      <label class="form-label">Long Description (AR)</label>
      <textarea name="long_description_ar" rows="6" class="form-control" dir="rtl" required>{{ old('long_description_ar',$blog->long_description_ar) }}</textarea>
    </div>

    <div class="col-md-6">
      <label class="form-label">Category</label>
      <select name="blog_category_id" class="form-select">
        <option value="">— None —</option>
        @foreach($categories as $c)
          <option value="{{ $c->id }}" @selected(old('blog_category_id',$blog->blog_category_id)==$c->id)>{{ $c->name }}</option>
        @endforeach
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="active" @selected(old('status',$blog->status)==='active')>Active</option>
        <option value="inactive" @selected(old('status',$blog->status)==='inactive')>Inactive</option>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Cover Image</label>
      <input type="file" name="cover_image" class="form-control">
      <small class="text-muted">Leave empty to keep current.</small>
    </div>

    @if($blog->cover_image)
    <div class="col-12">
      <div class="small text-muted mb-1">Current Image</div>
      <img src="{{ $blog->cover_image }}" alt="cover" class="img-fluid rounded" style="max-height:220px">
    </div>
    @endif

    <div class="col-12">
      <button class="btn btn-gold">Update Blog</button>
      <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
