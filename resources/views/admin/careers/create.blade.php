@extends('admin.layouts.app')

@section('title','Add Career')

@section('content')
<div class="card-soft">
  <h5 class="mb-3">Add Career</h5>

  <form method="POST" action="{{ route('admin.careers.store') }}" class="row g-3">
    @csrf

    <div class="col-md-6"><label class="form-label">Job Title (EN)</label><input name="job_title_en" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">Job Title (AR)</label><input name="job_title_ar" class="form-control" dir="rtl" required></div>

    <div class="col-md-6"><label class="form-label">Department (EN)</label><input name="department_en" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">Department (AR)</label><input name="department_ar" class="form-control" dir="rtl" required></div>

    <div class="col-md-6"><label class="form-label">Location (EN)</label><input name="location_en" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">Location (AR)</label><input name="location_ar" class="form-control" dir="rtl" required></div>

    <div class="col-md-6"><label class="form-label">Type (EN)</label><input name="type_en" class="form-control" required></div>
    <div class="col-md-6"><label class="form-label">Type (AR)</label><input name="type_ar" class="form-control" dir="rtl" required></div>

    <div class="col-md-6"><label class="form-label">Short Description (EN)</label><textarea name="short_description_en" class="form-control" rows="2"></textarea></div>
    <div class="col-md-6"><label class="form-label">Short Description (AR)</label><textarea name="short_description_ar" class="form-control" rows="2" dir="rtl"></textarea></div>

    <div class="col-md-6"><label class="form-label">Long Description (EN)</label><textarea name="long_description_en" class="form-control" rows="5"></textarea></div>
    <div class="col-md-6"><label class="form-label">Long Description (AR)</label><textarea name="long_description_ar" class="form-control" rows="5" dir="rtl"></textarea></div>

    <div class="col-md-3">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Sort Order</label>
      <input type="number" name="sort_order" class="form-control" value="0">
    </div>

    <div class="col-12">
      <button class="btn btn-gold">Save</button>
      <a href="{{ route('admin.careers.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </div>
  </form>
</div>
@endsection
