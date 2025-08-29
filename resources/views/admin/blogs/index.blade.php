@extends('admin.layouts.app')

@section('title','Blogs')

@section('content')
<div class="card-soft">
  <div class="d-flex justify-content-between mb-3">
    <h5 class="mb-0">Blogs</h5>
    <a href="{{ route('admin.blogs.create') }}" class="btn btn-gold"><i class="bi bi-plus-lg"></i> Add Blog</a>
  </div>

  @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th><th>Title</th><th>Category</th><th>Status</th><th>Created</th><th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($blogs as $b)
        <tr>
          <td>{{ $b->id }}</td>
          <td>{{ $b->title }}</td>
          <td>{{ $b->category?->name ?? '—' }}</td>
          <td><span class="badge bg-{{ $b->status==='active'?'success':'secondary' }}">{{ ucfirst($b->status) }}</span></td>
          <td>{{ $b->created_at->format('d M Y') }}</td>
          <td class="text-end">
            <a href="{{ route('admin.blogs.edit',$b->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
            <form action="{{ route('admin.blogs.destroy',$b->id) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-3">{{ $blogs->links() }}</div>
</div>
@endsection
