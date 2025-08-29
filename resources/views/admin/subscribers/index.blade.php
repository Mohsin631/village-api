@extends('admin.layouts.app')

@section('title','Subscribe Now')

@section('content')
<div class="card-soft">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
    <h5 class="mb-0">Subscribe Now</h5>

    <div class="d-flex flex-wrap gap-2">
      <button type="button" id="sendSelectedBtn" class="btn btn-gold" disabled>
        <i class="bi bi-send me-1"></i> Send Mail to Selected
      </button>
      <a href="{{ route('admin.subscribers.export', request()->query()) }}" class="btn btn-outline-secondary">
        <i class="bi bi-download me-1"></i> Export CSV
      </a>
    </div>
  </div>

  {{-- Filters --}}
  <form method="GET" class="row g-2 align-items-end mb-3">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <label class="form-label small text-muted mb-1">Search</label>
      <input class="form-control" name="q" value="{{ $q }}" placeholder="Search email…">
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <label class="form-label small text-muted mb-1">Date</label>
      <input type="date" class="form-control" name="date" value="{{ $date }}">
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <button class="btn btn-outline-secondary w-100">
        <i class="bi bi-funnel me-1"></i> Apply Filters
      </button>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <a href="{{ route('admin.subscribers.index') }}" class="btn btn-outline-light w-100">
        <i class="bi bi-x-circle me-1"></i> Clear
      </a>
    </div>
  </form>

  @if(session('status'))
    <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
  @endif

  <div class="table-responsive">
    <table class="table align-middle" id="subscribersTable">
      <thead>
        <tr>
          <th style="width:36px">
            <input type="checkbox" id="selectAll">
          </th>
          <th>#</th>
          <th>Email</th>
          <th>Joined</th>
          <th style="width:100px"></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($items as $i => $row)
          <tr>
            <td>
              <input type="checkbox" class="row-check" data-email="{{ $row->email }}">
            </td>
            <td>{{ ($items->firstItem() ?? 1) + $i }}</td>
            <td class="fw-semibold">{{ $row->email }}</td>
            <td class="text-muted">{{ $row->created_at->format('d M Y H:i') }}</td>
            <td class="text-end">
              <form action="{{ route('admin.subscribers.destroy', $row->id) }}" method="POST"
                    onsubmit="return confirm('Delete this subscriber?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted">No data found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-2">
    {{ $items->links() }}
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const selectAll   = document.getElementById('selectAll');
  const sendBtn     = document.getElementById('sendSelectedBtn');
  const checks      = Array.from(document.querySelectorAll('.row-check'));
  const mailPageUrl = "{{ route('admin.mail.create') }}";

  function updateState() {
    const selected = checks.filter(c => c.checked);
    sendBtn.disabled = selected.length === 0;

    if (checks.length === 0) {
      selectAll.checked = false;
      selectAll.indeterminate = false;
      return;
    }
    const allChecked = selected.length === checks.length;
    selectAll.checked = allChecked;
    selectAll.indeterminate = !allChecked && selected.length > 0;
  }

  if (selectAll) {
    selectAll.addEventListener('change', () => {
      checks.forEach(c => c.checked = selectAll.checked);
      updateState();
    });
  }
  checks.forEach(c => c.addEventListener('change', updateState));
  updateState();

  if (sendBtn) {
    sendBtn.addEventListener('click', () => {
      const emails = checks
        .filter(c => c.checked)
        .map(c => (c.dataset.email || '').trim())
        .filter(Boolean);

      if (!emails.length) return;

      const url = new URL(mailPageUrl, window.location.origin);
      url.searchParams.set('emails', emails.join(','));
      window.location.href = url.toString();
    });
  }
});
</script>
@endsection
