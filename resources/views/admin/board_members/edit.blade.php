@extends('admin.layouts.app')

@section('title','Edit Board Member')

@section('content')
<div class="card-soft">
  <h5>Edit Board Member</h5>

  <form action="{{ route('admin.board-members.update',$member->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
    @csrf @method('PATCH')

    <div class="col-md-6">
      <label class="form-label">Name (EN)</label>
      <input type="text" class="form-control" name="name_en" value="{{ old('name_en',$member->name['en'] ?? '') }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Name (AR)</label>
      <input type="text" class="form-control" name="name_ar" value="{{ old('name_ar',$member->name['ar'] ?? '') }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Position (EN)</label>
      <input type="text" class="form-control" name="position_en" value="{{ old('position_en',$member->position['en'] ?? '') }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Position (AR)</label>
      <input type="text" class="form-control" name="position_ar" value="{{ old('position_ar',$member->position['ar'] ?? '') }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Sort Order</label>
      <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order',$member->sort_order) }}">
    </div>
    <div class="col-md-6">
      <label class="form-label">Photo</label>
      <input type="file" class="form-control" name="image">
      <small class="text-muted">Leave blank to keep current</small>
    </div>
    <div class="col-md-6">
      <label class="form-label">Status</label>
      <select class="form-select" name="is_active">
        <option value="1" @selected($member->is_active)>Active</option>
        <option value="0" @selected(!$member->is_active)>Inactive</option>
      </select>
    </div>

    <div class="col-12">
      <button class="btn btn-gold">Update</button>
      <a href="{{ route('admin.board-members.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
