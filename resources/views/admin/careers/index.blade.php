@extends('admin.layouts.app')

@section('title','Careers')

@section('content')
<div class="card-soft">
  <div class="d-flex justify-content-between mb-3">
    <h5 class="mb-0">Careers</h5>
    <a href="{{ route('admin.careers.create') }}" class="btn btn-gold"><i class="bi bi-plus-lg"></i> Add Career</a>
  </div>

  @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Job Title</th>
          <th>Department</th>
          <th>Location</th>
          <th>Type</th>
          <th>Status</th>
          <th>Sort</th>
          <th>Created</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($careers as $c)
        <tr>
          <td>{{ $c->id }}</td>
          <td>{{ $c->job_title['en'] ?? '' }}</td>
          <td>{{ $c->department['en'] ?? '' }}</td>
          <td>{{ $c->location['en'] ?? '' }}</td>
          <td>{{ $c->type['en'] ?? '' }}</td>
          <td><span class="badge bg-{{ $c->status=='active'?'success':'secondary' }}">{{ ucfirst($c->status) }}</span></td>
          <td>{{ $c->sort_order }}</td>
          <td>{{ $c->created_at?->format('d M Y') }}</td>
          <td class="text-end">
            <a href="{{ route('admin.careers.edit',$c->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.careers.destroy',$c->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $careers->links() }}</div>
</div>
@endsection
