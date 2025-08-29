@extends('admin.layouts.app')

@section('title','Inquiry Types')

@section('content')
<div class="card-soft">

  <div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="mb-0">Inquiry Types</h5>
    <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#createModal">
      <i class="bi bi-plus-lg me-1"></i> New Type
    </button>
  </div>

  @if(session('status'))
    <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Slug</th>
          <th>Name (EN)</th>
          <th>Name (AR)</th>
          <th>Status</th>
          <th>Created</th>
          <th style="width:120px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($types as $i => $t)
        <tr>
          <td>{{ $types->firstItem() + $i }}</td>
          <td>{{ $t->slug }}</td>
          <td>{{ $t->name['en'] ?? '' }}</td>
          <td>{{ $t->name['ar'] ?? '' }}</td>
          <td>
            <form action="{{ route('admin.inquiry-types.toggle',$t->id) }}" method="POST">
              @csrf @method('PATCH')
              <button class="badge text-bg-{{ $t->is_active ? 'success':'secondary' }} border-0">
                {{ $t->is_active ? 'Active' : 'Inactive' }}
              </button>
            </form>
          </td>
          <td>{{ $t->created_at?->format('d M Y') }}</td>
          <td class="text-end">
            <a href="{{ route('admin.inquiry-types.edit',$t->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
           
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    {{ $types->links() }}
  </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('admin.inquiry-types.store') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Inquiry Type</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Slug</label>
            <input type="text" class="form-control" name="slug" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Status</label>
            <select class="form-select" name="is_active">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Name (English)</label>
            <input type="text" class="form-control" name="name_en" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Name (Arabic)</label>
            <input type="text" class="form-control" name="name_ar" required>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-gold">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
