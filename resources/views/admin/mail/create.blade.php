@extends('admin.layouts.app')

@section('title','Send Mail')

@section('content')
<div class="card-soft">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Send Mail</h5>
    <div class="small text-muted">
      Tip: You can prefill recipients with <code>?emails=first@mail.com,second@mail.com</code>
    </div>
  </div>

  @if(session('status'))
    <div class="alert alert-info py-2 px-3">{{ session('status') }}</div>
  @endif

  <form action="{{ route('admin.mail.send') }}" method="POST" class="row g-3">
    @csrf

    <div class="col-12">
      <label class="form-label">Recipients</label>
      <textarea name="emails" class="form-control" rows="2" placeholder="e.g. user1@example.com, user2@example.com" required>{{ old('emails', $prefill) }}</textarea>
      <div class="form-text">Separate with commas, spaces, or new lines.</div>
    </div>

    <div class="col-md-8">
      <label class="form-label">Subject</label>
      <input type="text" name="subjectLine" class="form-control" value="{{ old('subjectLine') }}" required>
    </div>

    <div class="col-md-4">
      <label class="form-label">Language</label>
      <select name="lang" class="form-select" required>
        <option value="en" @selected(old('lang')==='en')>English</option>
        <option value="ar" @selected(old('lang')==='ar')>Arabic</option>
      </select>
    </div>

    <div class="col-12">
      <label class="form-label">Message (HTML allowed)</label>
      <textarea name="messageBody" class="form-control" rows="10" placeholder="Write your message…" required>{{ old('messageBody') }}</textarea>
      <div class="form-text">Type message here.</div>
    </div>

    <div class="col-12 d-flex gap-2">
      <button class="btn btn-gold">
        <i class="bi bi-send me-1"></i> Queue Emails
      </button>
      <a href="{{ route('admin.mail.create') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
  </form>
</div>
@endsection
