@extends('admin.layouts.app')

@section('title','Edit Inquiry Type')

@section('content')
<div class="card-soft">
  <h5>Edit Inquiry Type</h5>

  <form action="{{ route('admin.inquiry-types.update',$type->id) }}" method="POST" class="row g-3">
    @csrf @method('PATCH')

    <div class="col-md-6">
      <label class="form-label">Slug</label>
      <input type="text" class="form-control" name="slug" value="{{ old('slug',$type->slug) }}" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Status</label>
      <select class="form-select" name="is_active">
        <option value="1" @selected($type->is_active)>Active</option>
        <option value="0" @selected(!$type->is_active)>Inactive</option>
      </select>
    </div>

    <div class="col-md-6">
      <label class="form-label">Name (English)</label>
      <input type="text" class="form-control" name="name_en" value="{{ old('name_en',$type->name['en'] ?? '') }}" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Name (Arabic)</label>
      <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar',$type->name['ar'] ?? '') }}" required>
    </div>

    <div class="col-12">
      <button class="btn btn-gold">Update</button>
      <a href="{{ route('admin.inquiry-types.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
