@extends('admin.layouts.app')

@section('title','Edit Career')

@section('content')
<div class="card-soft">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Edit Career</h5>
    <a href="{{ route('admin.careers.index') }}" class="btn btn-sm btn-outline-secondary">
      <i class="bi bi-arrow-left me-1"></i> Back
    </a>
  </div>

  @if(session('status'))
    <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('admin.careers.update',$career->id) }}" class="row g-3">
    @csrf @method('PATCH')

    <div class="col-md-6">
      <label class="form-label">Job Title (EN)</label>
      <input name="job_title_en" class="form-control" 
             value="{{ old('job_title_en',$career->job_title['en'] ?? '') }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Job Title (AR)</label>
      <input name="job_title_ar" class="form-control" dir="rtl" 
             value="{{ old('job_title_ar',$career->job_title['ar'] ?? '') }}" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Department (EN)</label>
      <input name="department_en" class="form-control" 
             value="{{ old('department_en',$career->department['en'] ?? '') }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Department (AR)</label>
      <input name="department_ar" class="form-control" dir="rtl" 
             value="{{ old('department_ar',$career->department['ar'] ?? '') }}" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Location (EN)</label>
      <input name="location_en" class="form-control" 
             value="{{ old('location_en',$career->location['en'] ?? '') }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Location (AR)</label>
      <input name="location_ar" class="form-control" dir="rtl" 
             value="{{ old('location_ar',$career->location['ar'] ?? '') }}" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Type (EN)</label>
      <input name="type_en" class="form-control" 
             value="{{ old('type_en',$career->type['en'] ?? '') }}" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Type (AR)</label>
      <input name="type_ar" class="form-control" dir="rtl" 
             value="{{ old('type_ar',$career->type['ar'] ?? '') }}" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Short Description (EN)</label>
      <textarea name="short_description_en" class="form-control" rows="2" required>{{ old('short_description_en',$career->short_description['en'] ?? '') }}</textarea>
    </div>
    <div class="col-md-6">
      <label class="form-label">Short Description (AR)</label>
      <textarea name="short_description_ar" class="form-control" rows="2" dir="rtl" required>{{ old('short_description_ar',$career->short_description['ar'] ?? '') }}</textarea>
    </div>

    <div class="col-md-6">
      <label class="form-label">Long Description (EN)</label>
      <textarea name="long_description_en" class="form-control" rows="5" required>{{ old('long_description_en',$career->long_description['en'] ?? '') }}</textarea>
    </div>
    <div class="col-md-6">
      <label class="form-label">Long Description (AR)</label>
      <textarea name="long_description_ar" class="form-control" rows="5" dir="rtl" required>{{ old('long_description_ar',$career->long_description['ar'] ?? '') }}</textarea>
    </div>

    <div class="col-md-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="active" @selected(old('status',$career->status)==='active')>Active</option>
        <option value="inactive" @selected(old('status',$career->status)==='inactive')>Inactive</option>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Sort Order</label>
      <input type="number" name="sort_order" class="form-control" 
             value="{{ old('sort_order',$career->sort_order) }}">
    </div>

    <div class="col-12">
      <button class="btn btn-gold">Update Career</button>
      <a href="{{ route('admin.careers.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
