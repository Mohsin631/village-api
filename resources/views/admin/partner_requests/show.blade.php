@extends('admin.layouts.app')

@section('title','Partner Request #'.$request->id)

@section('content')
<div class="row g-3">
  <div class="col-12 col-lg-8">
    <div class="card-soft">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Partner Request Details</h5>
        <a href="{{ route('admin.partner-requests.index') }}" class="btn btn-sm btn-outline-secondary">
          <i class="bi bi-arrow-left me-1"></i> Back
        </a>
      </div>

      <div class="row g-3">
        <div class="col-md-6">
          <div class="small text-muted">Company Name</div>
          <div class="fw-semibold">{{ $request->company_name }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Contact Person</div>
          <div class="fw-semibold">{{ $request->contact_person }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Email</div>
          <div class="fw-semibold"><a href="mailto:{{ $request->email }}">{{ $request->email }}</a></div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Phone</div>
          <div class="fw-semibold"><a href="tel:{{ $request->phone }}">{{ $request->phone }}</a></div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Job Title</div>
          <div class="fw-semibold">{{ $request->job_title ?? '—' }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Location</div>
          <div class="fw-semibold">{{ $request->location ?? '—' }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Bank Name</div>
          <div class="fw-semibold">{{ $request->bank_name ?? '—' }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Bank Account</div>
          <div class="fw-semibold">{{ $request->bank_account ?? '—' }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">IBAN</div>
          <div class="fw-semibold">{{ $request->iban ?? '—' }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">VAT Registration No.</div>
          <div class="fw-semibold">{{ $request->vat_registration_number ?? '—' }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Swift Code</div>
          <div class="fw-semibold">{{ $request->swift_code ?? '—' }}</div>
        </div>
        <div class="col-12">
          <div class="small text-muted">Services Summary</div>
          <div class="fw-semibold" style="white-space:pre-wrap">{{ $request->services_summary ?? '—' }}</div>
        </div>
        <div class="col-md-4">
          <div class="small text-muted">Lang</div>
          <div class="fw-semibold">{{ strtoupper($request->lang ?? '-') }}</div>
        </div>
        <div class="col-md-4">
          <div class="small text-muted">IP</div>
          <div class="fw-semibold">{{ $request->ip ?? '—' }}</div>
        </div>
        <div class="col-md-4">
          <div class="small text-muted">User Agent</div>
          <div class="text-break small">{{ $request->user_agent ?? '—' }}</div>
        </div>
        <div class="col-md-4">
          <div class="small text-muted">Submitted At</div>
          <div class="fw-semibold">{{ $request->created_at->format('d M Y H:i') }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-12 col-lg-4">
    <div class="card-soft">
      <h5 class="mb-3">Actions</h5>
      <a href="{{ route('admin.mail.create',['emails'=>$request->email]) }}" 
        class="btn btn-gold w-100 mb-3">
       <i class="bi bi-envelope-paper me-1"></i> Send Mail
     </a>
      <form action="{{ route('admin.partner-requests.destroy',$request->id) }}" method="POST" onsubmit="return confirm('Delete this request?')">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger w-100"><i class="bi bi-trash me-1"></i> Delete</button>
      </form>
    </div>
  </div>
</div>
@endsection
