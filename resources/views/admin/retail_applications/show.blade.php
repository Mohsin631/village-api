@extends('admin.layouts.app')

@section('title','Retail Application #'.$app->id)

@section('content')
<div class="row g-3">
  <div class="col-12 col-lg-8">
    <div class="card-soft">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <h5 class="mb-0">Application Details</h5>
        <a href="{{ route('admin.retail-applications.index') }}" class="btn btn-sm btn-outline-secondary">
          <i class="bi bi-arrow-left me-1"></i> Back
        </a>
      </div>

      <div class="row g-3">
        <div class="col-md-6">
          <div class="small text-muted">Full Name</div>
          <div class="fw-semibold">{{ $app->full_name }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Email</div>
          <div class="fw-semibold"><a href="mailto:{{ $app->email }}">{{ $app->email }}</a></div>
        </div>

        <div class="col-md-6">
          <div class="small text-muted">Phone</div>
          <div class="fw-semibold"><a href="tel:{{ $app->phone }}">{{ $app->phone }}</a></div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Career / Job</div>
          <div class="fw-semibold">{{ $app->career?->job_title['en'] ?? '—' }}</div>
        </div>

        <div class="col-md-6">
          <div class="small text-muted">LinkedIn</div>
          <div class="fw-semibold">
            @if($app->linkedin_url)
              <a href="{{ $app->linkedin_url }}" target="_blank" rel="noopener">{{ $app->linkedin_url }}</a>
            @else — @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">Language</div>
          <div class="fw-semibold">{{ strtoupper($app->lang ?? '-') }}</div>
        </div>

        <div class="col-12">
          <div class="small text-muted">Cover Letter</div>
          <div class="fw-semibold" style="white-space:pre-wrap">{{ $app->cover_letter ?? '—' }}</div>
        </div>

        <div class="col-md-6">
          <div class="small text-muted">IP</div>
          <div class="fw-semibold">{{ $app->ip ?? '—' }}</div>
        </div>
        <div class="col-md-6">
          <div class="small text-muted">User Agent</div>
          <div class="small text-break">{{ $app->user_agent ?? '—' }}</div>
        </div>

        <div class="col-md-6">
          <div class="small text-muted">Submitted At</div>
          <div class="fw-semibold">{{ $app->created_at?->format('d M Y H:i') }}</div>
        </div>

        <div class="col-md-6">
          <div class="small text-muted">CV / Résumé</div>
          <div class="d-flex align-items-center gap-2">
            @if($app->cv_path)
              <a href="{{ route('admin.retail-applications.cv',$app->id) }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-paperclip me-1"></i> Download CV
              </a>
              <span class="small text-muted text-truncate">{{ basename($app->cv_path) }}</span>
            @else
              —
            @endif
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="col-12 col-lg-4">
    <div class="card-soft">
      <h5 class="mb-3">Actions</h5>
      <form action="{{ route('admin.retail-applications.destroy',$app->id) }}" method="POST" onsubmit="return confirm('Delete this application?')">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger w-100"><i class="bi bi-trash me-1"></i> Delete</button>
      </form>
      @if($app->cv_path)
        <a href="{{ route('admin.retail-applications.cv',$app->id) }}" class="btn btn-gold w-100 mt-2">
          <i class="bi bi-download me-1"></i> Download CV
        </a>
      @endif
    </div>
  </div>
</div>
@endsection
