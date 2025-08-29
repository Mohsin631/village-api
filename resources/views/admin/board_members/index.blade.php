@extends('admin.layouts.app')

@section('title','Board Members')

@section('content')
<div class="card-soft">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Board Members</h5>
    <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#createModal">
      <i class="bi bi-plus-lg me-1"></i> Add Member
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
          <th>Photo</th>
          <th>Name (EN)</th>
          <th>Name (AR)</th>
          <th>Position (EN)</th>
          <th>Position (AR)</th>
          <th>Sort</th>
          <th>Status</th>
          <th style="width:120px"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($members as $i => $m)
        <tr>
          <td>{{ $members->firstItem() + $i }}</td>
          <td><img src="{{ $m->image }}" alt="photo" width="60" class="rounded"></td>
          <td>{{ $m->name['en'] ?? '' }}</td>
          <td>{{ $m->name['ar'] ?? '' }}</td>
          <td>{{ $m->position['en'] ?? '' }}</td>
          <td>{{ $m->position['ar'] ?? '' }}</td>
          <td>{{ $m->sort_order }}</td>
          <td>
            <form action="{{ route('admin.board-members.toggle',$m->id) }}" method="POST">
              @csrf @method('PATCH')
              <button class="badge text-bg-{{ $m->is_active ? 'success':'secondary' }} border-0">
                {{ $m->is_active ? 'Active':'Inactive' }}
              </button>
            </form>
          </td>
          <td class="text-end">
            <a href="{{ route('admin.board-members.edit',$m->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.board-members.destroy',$m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete member?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-2">
    {{ $members->links() }}
  </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="createModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('admin.board-members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Board Member</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Name (EN)</label>
            <input type="text" class="form-control" name="name_en" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Name (AR)</label>
            <input type="text" class="form-control" name="name_ar" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Position (EN)</label>
            <input type="text" class="form-control" name="position_en" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Position (AR)</label>
            <input type="text" class="form-control" name="position_ar" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Sort Order</label>
            <input type="number" class="form-control" name="sort_order" value="0">
          </div>
          <div class="col-md-6">
            <label class="form-label">Photo</label>
            <input type="file" class="form-control" name="image" required>
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
