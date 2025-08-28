@extends('admin.layouts.app')

@section('title','Inquiries')

@section('content')
<div class="card-soft">

  <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h5 class="mb-0">Inquiries</h5>

    <div class="d-flex flex-wrap align-items-center gap-2">
      <a href="{{ route('admin.inquiries.export', request()->query()) }}" class="btn btn-gold">
        <i class="bi bi-download me-1"></i> Export CSV
      </a>
      <form id="bulkDeleteForm" action="{{ route('admin.inquiries.bulkDelete') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="ids" id="bulkDeleteIds">
        <button type="button" class="btn btn-outline-danger" onclick="submitBulkDelete()" id="bulkDeleteBtn" disabled>
          <i class="bi bi-trash me-1"></i> Bulk Delete
        </button>
      </form>
    </div>
  </div>

  {{-- Filters --}}
  <form method="GET" class="row g-2 align-items-end mb-3">
    <div class="col-12 col-sm-6 col-md-3">
      <label class="form-label small text-muted">Search</label>
      <input class="form-control" name="q" value="{{ $q }}" placeholder="Name, email, phone, message">
    </div>
    <div class="col-6 col-md-2">
      <label class="form-label small text-muted">Date</label>
      <input type="date" class="form-control" name="date" value="{{ $date }}">
    </div>
    <div class="col-6 col-md-2">
      <label class="form-label small text-muted">Type</label>
      <select name="inquiry_type_id" class="form-select">
        <option value="">All</option>
        @foreach($types as $t)
          <option value="{{ $t->id }}" @selected($typeId==$t->id)>
            {{ $t->name['en'] ?? $t->name['ar'] ?? ('Type #'.$t->id) }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="col-6 col-md-2">
      <label class="form-label small text-muted">Status</label>
      <select name="status" class="form-select">
        <option value="">All</option>
        <option value="open"        @selected($status==='open')>Open</option>
        <option value="in_progress" @selected($status==='in_progress')>In Progress</option>
        <option value="resolved"    @selected($status==='resolved')>Resolved</option>
      </select>
    </div>
    <div class="col-6 col-md-2">
      <label class="form-label small text-muted">Priority</label>
      <select name="priority" class="form-select">
        <option value="">All</option>
        <option value="low"    @selected($priority==='low')>Low</option>
        <option value="medium" @selected($priority==='medium')>Medium</option>
        <option value="high"   @selected($priority==='high')>High</option>
      </select>
    </div>
    <div class="col-6 col-md-1">
      <label class="form-label small text-muted">Lang</label>
      <select name="lang" class="form-select">
        <option value="">All</option>
        <option value="en" @selected($lang==='en')>EN</option>
        <option value="ar" @selected($lang==='ar')>AR</option>
      </select>
    </div>
    <div class="col-12 col-md-12">
      <button class="btn btn-outline-secondary me-1"><i class="bi bi-funnel me-1"></i> Filter</button>
      <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-1"></i> Reset</a>
    </div>
  </form>

  @if(session('status'))
    <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
  @endif

  {{-- Table --}}
  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th style="width:36px">
            <input type="checkbox" class="form-check-input" id="selectAll">
          </th>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Type</th>
          <th class="d-none d-md-table-cell">Message</th>
          <th>Status</th>
          <th>Priority</th>
          <th>Lang</th>
          <th>Created</th>
          <th style="width:100px"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($items as $i => $row)
          <tr>
            <td>
              <input type="checkbox" class="form-check-input row-check" value="{{ $row->id }}">
            </td>
            <td>{{ ($items->firstItem() ?? 1) + $i }}</td>
            <td class="fw-semibold">
              <a href="{{ route('admin.inquiries.show', $row->id) }}" class="text-decoration-none">
                {{ $row->full_name }}
              </a>
            </td>
            <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td>
            <td><a href="tel:{{ $row->phone }}">{{ $row->phone }}</a></td>
            <td>
                @if($row->lang === 'ar')
                  {{ $row->inquiryType->name['ar'] ?? '—' }}
                @else
                  {{ $row->inquiryType->name['en'] ?? '—' }}
                @endif
              </td>
                          <td class="d-none d-md-table-cell text-truncate" style="max-width:260px">{{ $row->message }}</td>
            <td>
              @php
                $badgeMap = ['open'=>'warning','in_progress'=>'info','resolved'=>'success'];
              @endphp
              <span class="badge text-bg-{{ $badgeMap[$row->status] ?? 'secondary' }}">{{ Str::headline($row->status) }}</span>
            </td>
            <td>
              @php
                $pMap = ['low'=>'secondary','medium'=>'primary','high'=>'danger'];
              @endphp
              <span class="badge text-bg-{{ $pMap[$row->priority] ?? 'secondary' }}">{{ Str::headline($row->priority) }}</span>
            </td>
            <td>{{ strtoupper($row->lang ?? '-') }}</td>
            <td class="text-muted">{{ $row->created_at?->format('d M Y H:i') }}</td>
            <td class="text-end">
              <div class="btn-group">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('admin.inquiries.show',$row->id) }}"><i class="bi bi-eye"></i></a>
                <form action="{{ route('admin.inquiries.destroy',$row->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="12" class="text-center text-muted py-4">No inquiries found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-2">
    {{ $items->links() }}
  </div>
</div>

<script>
  const selectAll = document.getElementById('selectAll');
  const checks = document.querySelectorAll('.row-check');
  const bulkBtn = document.getElementById('bulkDeleteBtn');
  const bulkIds = document.getElementById('bulkDeleteIds');

  if (selectAll) {
    selectAll.addEventListener('change', () => {
      checks.forEach(c => c.checked = selectAll.checked);
      updateBulkButton();
    });
  }
  checks.forEach(c => c.addEventListener('change', updateBulkButton));

  function updateBulkButton() {
    const selected = Array.from(checks).filter(c => c.checked).map(c => c.value);
    bulkBtn.disabled = selected.length === 0;
    bulkIds.value = JSON.stringify(selected);
  }

  function submitBulkDelete() {
    const selected = Array.from(checks).filter(c => c.checked).map(c => c.value);
    if (!selected.length) return;
    if (confirm(`Delete ${selected.length} selected item(s)?`)) {
      bulkIds.value = JSON.stringify(selected);
      document.getElementById('bulkDeleteForm').submit();
    }
  }
</script>
@endsection
