@extends('admin.layouts.app')

@section('title','Dashboard')

@section('content')
  <div class="row g-3">
    <!-- KPI cards -->
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card-soft">
        <div class="kpi">
          <div class="kpi-icon"><i class="bi bi-people"></i></div>
          <div>
            <div class="small text-muted">Users</div>
            <div class="h5 fw-bold">1,248</div>
            <div class="progress-wrap mt-2">
              <div class="progress-bar-gold" style="--val:68%"></div>
            </div>
            <div class="small text-muted mt-1">+12% this week</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card-soft">
        <div class="kpi">
          <div class="kpi-icon"><i class="bi bi-inboxes"></i></div>
          <div>
            <div class="small text-muted">Inquiries</div>
            <div class="h5 fw-bold">87</div>
            <div class="progress-wrap mt-2">
              <div class="progress-bar-gold" style="--val:52%"></div>
            </div>
            <div class="small text-muted mt-1">+6 today</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card-soft">
        <div class="kpi">
          <div class="kpi-icon"><i class="bi bi-envelope-paper"></i></div>
          <div>
            <div class="small text-muted">Subscribers</div>
            <div class="h5 fw-bold">2,905</div>
            <div class="progress-wrap mt-2">
              <div class="progress-bar-gold" style="--val:74%"></div>
            </div>
            <div class="small text-muted mt-1">+41 this week</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-3">
      <div class="card-soft">
        <div class="kpi">
          <div class="kpi-icon"><i class="bi bi-briefcase"></i></div>
          <div>
            <div class="small text-muted">Open Roles</div>
            <div class="h5 fw-bold">12</div>
            <div class="progress-wrap mt-2">
              <div class="progress-bar-gold" style="--val:35%"></div>
            </div>
            <div class="small text-muted mt-1">3 new</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart & recent activity -->
    <div class="col-12 col-lg-8">
      <div class="card-soft">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h5 class="mb-0">Engagement Overview</h5>
          <div class="btn-group btn-group-sm">
            <button class="btn btn-outline-secondary active">7d</button>
            <button class="btn btn-outline-secondary">30d</button>
            <button class="btn btn-outline-secondary">90d</button>
          </div>
        </div>
        <div class="mini-chart"></div>
        <div class="small text-muted mt-2">Lightweight chart placeholder. Swap with Chart.js later if needed.</div>
      </div>
    </div>

    <div class="col-12 col-lg-4">
      <div class="card-soft">
        <h5 class="mb-3">Recent Activity</h5>
        <ul class="list-unstyled m-0">
          <li class="d-flex align-items-start gap-2 mb-3">
            <i class="bi bi-dot text-warning fs-3 lh-1"></i>
            <div>
              <div class="fw-semibold">New inquiry from John Doe</div>
              <div class="small text-muted">5 mins ago</div>
            </div>
          </li>
          <li class="d-flex align-items-start gap-2 mb-3">
            <i class="bi bi-dot text-warning fs-3 lh-1"></i>
            <div>
              <div class="fw-semibold">3 newsletter signups</div>
              <div class="small text-muted">17 mins ago</div>
            </div>
          </li>
          <li class="d-flex align-items-start gap-2 mb-1">
            <i class="bi bi-dot text-warning fs-3 lh-1"></i>
            <div>
              <div class="fw-semibold">Retail application received</div>
              <div class="small text-muted">1 hour ago</div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <!-- Two-column content -->
    <div class="col-12 col-xl-6">
      <div class="card-soft">
        <h5 class="mb-3">Quick Actions</h5>
        <div class="d-flex flex-wrap gap-2">
          <a class="btn btn-gold" href="#"><i class="bi bi-plus-lg me-1"></i>Create Job</a>
          <a class="btn btn-outline-secondary" href="#"><i class="bi bi-envelope me-1"></i>Send Email</a>
          <a class="btn btn-outline-secondary" href="#"><i class="bi bi-upload me-1"></i>Import CSV</a>
          <a class="btn btn-outline-secondary" href="#"><i class="bi bi-gear me-1"></i>System Settings</a>
        </div>
      </div>
    </div>

    <div class="col-12 col-xl-6">
      <div class="card-soft">
        <h5 class="mb-3">System Health</h5>
        <div class="row g-3">
          <div class="col-6">
            <div class="small text-muted">API Uptime</div>
            <div class="h5 fw-bold">99.98%</div>
          </div>
          <div class="col-6">
            <div class="small text-muted">DB Latency</div>
            <div class="h5 fw-bold">12 ms</div>
          </div>
          <div class="col-6">
            <div class="small text-muted">Queue</div>
            <div class="h5 fw-bold">OK</div>
          </div>
          <div class="col-6">
            <div class="small text-muted">Disk</div>
            <div class="h5 fw-bold">71%</div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
