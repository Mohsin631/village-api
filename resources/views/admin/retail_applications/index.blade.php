@extends('admin.layouts.app')

@section('title','Retail Applications')

@section('content')
<div class="card-soft">

  <div class="d-flex align-items-center justify-content-between mb-3">
    <h5 class="mb-0">Retail Applications</h5>
    <a href="{{ route('admin.retail-applications.export', request()->query()) }}" class="btn btn-gold">
      <i class="bi bi-download me-1"></i> Export CSV
    </a>
  </div>

  {{-- Filters --}}
  <form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
      <input class="form-control" name="q" value="{{ $q }}" placeholder="Search name, email, phone, LinkedIn">
    </div>
    <div class="col-md-2">
      <input type="date" class="form-control" name="date" value="{{ $date }}">
    </div>
    <div class="col-md-2">
      <select name="lang" class="form-select">
        <option value="">Lang</option>
        <option value="en" @selected($lang==='en')>EN</option>
        <option value="ar" @selected($lang==='ar')>AR</option>
      </select>
    </div>
    <div class="col-md-3">
      <select name="career_id" class="form-select">
        <option value="">All Careers</option>
        @foreach($careers as $c)
          <option value="{{ $c->id }}" @selected($careerId==$c->id)>{{ $c->job_title['en'] ?? ('Job #'.$c->id) }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-1">
      <button class="btn btn-outline-secondary w-100"><i class="bi bi-funnel"></i></button>
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
          <th>Applicant</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Career</th>
          <th>Lang</th>
          <th>Submitted</th>
          <th style="width:120px"></th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $i=>$row)
          <tr>
            <td>{{ $items->firstItem() + $i }}</td>
            <td class="fw-semibold">{{ $row->full_name }}</td>
            <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
            <td>{{ $row->phone }}</td>
            <td>{{ $row->career?->job_title['en'] ?? '—' }}</td>
            <td>{{ strtoupper($row->lang ?? '-') }}</td>
            <td class="text-muted">{{ $row->created_at?->format('d M Y H:i') }}</td>
            <td class="text-end">
              <a href="{{ route('admin.retail-applications.show',$row->id) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
              <form action="{{ route('admin.retail-applications.destroy',$row->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this application?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="8" class="text-center text-muted py-4">No applications found</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-2">{{ $items->links() }}</div>
</div>
@endsection
