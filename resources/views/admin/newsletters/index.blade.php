@extends('admin.layouts.app')

@section('title','Newsletter Signups')

@section('content')
<div class="card-soft">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h5 class="mb-0">Newsletter Signups</h5>

    <form method="GET" class="d-flex flex-wrap align-items-center gap-2">
      <input class="form-control" name="q" value="{{ $q }}" placeholder="Search email…" style="max-width:220px">
      <input type="date" class="form-control" name="date" value="{{ $date }}" style="max-width:170px">
      <button class="btn btn-outline-secondary">Filter</button>
      <a href="{{ route('admin.newsletters.export', request()->query()) }}" class="btn btn-gold">
        <i class="bi bi-download me-1"></i> Export CSV
      </a>
    </form>
  </div>

  @if(session('status'))
    <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Email</th>
          <th>Joined</th>
          <th style="width:100px"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($items as $i => $row)
          <tr>
            <td>{{ ($items->firstItem() ?? 1) + $i }}</td>
            <td class="fw-semibold">{{ $row->email }}</td>
            <td class="text-muted">{{ $row->created_at->format('d M Y H:i') }}</td>
            <td class="text-end">
              <form action="{{ route('admin.newsletters.destroy', $row->id) }}" method="POST"
                    onsubmit="return confirm('Delete this entry?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted">No data found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-2">
    {{ $items->links() }}
  </div>
</div>
@endsection
