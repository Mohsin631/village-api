@extends('admin.layouts.app')

@section('title','Inquiry #'.$inquiry->id)

@section('content')
<div class="row g-3">
  <div class="col-12 col-lg-8">
    <div class="card-soft">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h5 class="mb-0">Inquiry Details</h5>
        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-secondary">
          <i class="bi bi-arrow-left me-1"></i> Back
        </a>
      </div>

      <div class="row g-3">
        <div class="col-12 col-md-6">
          <div class="small text-muted">Full Name</div>
          <div class="fw-semibold">{{ $inquiry->full_name }}</div>
        </div>
        <div class="col-12 col-md-6">
          <div class="small text-muted">Email</div>
          <div class="fw-semibold"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></div>
        </div>
        <div class="col-12 col-md-6">
          <div class="small text-muted">Phone</div>
          <div class="fw-semibold"><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></div>
        </div>
        <div class="col-12 col-md-6">
            <div class="small text-muted">Inquiry Type</div>
            <div class="fw-semibold">
              @if($inquiry->lang === 'ar')
                {{ $inquiry->inquiryType->name['ar'] ?? '—' }}
              @else
                {{ $inquiry->inquiryType->name['en'] ?? '—' }}
              @endif
            </div>
          </div>

        <div class="col-12">
          <div class="small text-muted">Message</div>
          <div class="fw-semibold" style="white-space:pre-wrap">{{ $inquiry->message }}</div>
        </div>

        <div class="col-6 col-md-3">
          <div class="small text-muted">Language</div>
          <div class="fw-semibold">{{ strtoupper($inquiry->lang ?? '-') }}</div>
        </div>
        <div class="col-6 col-md-3">
          <div class="small text-muted">IP</div>
          <div class="fw-semibold">{{ $inquiry->ip ?? '—' }}</div>
        </div>
        <div class="col-12">
          <div class="small text-muted">User Agent</div>
          <div class="text-break">{{ $inquiry->user_agent ?? '—' }}</div>
        </div>

        <div class="col-6 col-md-3">
          <div class="small text-muted">Created</div>
          <div class="fw-semibold">{{ $inquiry->created_at?->format('d M Y H:i') }}</div>
        </div>
        @if($inquiry->handled_at)
        <div class="col-6 col-md-3">
          <div class="small text-muted">Handled At</div>
          <div class="fw-semibold">{{ $inquiry->handled_at->format('d M Y H:i') }}</div>
        </div>
        @endif
        @if($inquiry->handledBy)
        <div class="col-6 col-md-3">
          <div class="small text-muted">Handled By</div>
          <div class="fw-semibold">{{ $inquiry->handledBy->name }}</div>
        </div>
        @endif
      </div>
    </div>
  </div>

  {{-- Right: Admin actions --}}
  <div class="col-12 col-lg-4">
    <div class="card-soft">
      <h5 class="mb-3">Manage</h5>

      @if(session('status'))
        <div class="alert alert-success py-2 px-3">{{ session('status') }}</div>
      @endif

      <form action="{{ route('admin.inquiries.update',$inquiry->id) }}" method="POST" class="d-grid gap-2">
        @csrf @method('PATCH')

        <div>
          <label class="form-label small text-muted">Status</label>
          <select name="status" class="form-select">
            <option value="open"        @selected($inquiry->status==='open')>Open</option>
            <option value="in_progress" @selected($inquiry->status==='in_progress')>In Progress</option>
            <option value="resolved"    @selected($inquiry->status==='resolved')>Resolved</option>
          </select>
        </div>

        <div>
          <label class="form-label small text-muted">Priority</label>
          <select name="priority" class="form-select">
            <option value="low"    @selected($inquiry->priority==='low')>Low</option>
            <option value="medium" @selected($inquiry->priority==='medium')>Medium</option>
            <option value="high"   @selected($inquiry->priority==='high')>High</option>
          </select>
        </div>

        <div>
          <label class="form-label small text-muted">Admin Note</label>
          <textarea name="admin_note" class="form-control" rows="4" placeholder="Add an internal note…">{{ old('admin_note',$inquiry->admin_note) }}</textarea>
        </div>

        <button class="btn btn-gold w-100">Save Changes</button>
      </form>

      <hr class="my-3">

      <form action="{{ route('admin.inquiries.destroy',$inquiry->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger w-100"><i class="bi bi-trash me-1"></i> Delete</button>
      </form>
    </div>
  </div>
</div>
@endsection
