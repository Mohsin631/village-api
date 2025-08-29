@extends('admin.layouts.app')

@section('title','Partner Requests')

@section('content')
<div class="card-soft">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Partner Requests</h5>
    <a href="{{ route('admin.partner-requests.export', request()->query()) }}" class="btn btn-gold">
      <i class="bi bi-download me-1"></i> Export CSV
    </a>
  </div>

  {{-- Filters --}}
  <form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
      <input type="text" class="form-control" name="q" value="{{ $q }}" placeholder="Search company, person, email…">
    </div>
    <div class="col-md-3">
      <input type="date" class="form-control" name="date" value="{{ $date }}">
    </div>
    <div class="col-md-2">
      <select name="lang" class="form-select">
        <option value="">Lang</option>
        <option value="en" @selected($lang==='en')>EN</option>
        <option value="ar" @selected($lang==='ar')>AR</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-outline-secondary"><i class="bi bi-funnel me-1"></i> Filter</button>
    </div>
  </form>

  @if(session('status'))
    <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Company</th>
          <th>Contact</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Location</th>
          <th>Lang</th>
          <th>Created</th>
          <th style="width:100px"></th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $i=>$row)
        <tr>
          <td>{{ $items->firstItem()+$i }}</td>
          <td>{{ $row->company_name }}</td>
          <td>{{ $row->contact_person }}</td>
          <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
          <td>{{ $row->phone }}</td>
          <td>{{ $row->location }}</td>
          <td>{{ strtoupper($row->lang) }}</td>
          <td class="text-muted">{{ $row->created_at->format('d M Y H:i') }}</td>
          <td class="text-end">
            <a href="{{ route('admin.partner-requests.show',$row->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
            <form action="{{ route('admin.partner-requests.destroy',$row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this request?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="9" class="text-center text-muted py-4">No requests found</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-2">{{ $items->links() }}</div>
</div>
@endsection
