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
            <div class="small text-muted">Total Newsletter</div>
            <div class="h5 fw-bold">{{ $totalNewsletter }}</div>
            <div class="progress-wrap mt-2">
              <div class="progress-bar-gold" style="--val:{{ $newsletterPercent }}%"></div>
            </div>
            <div class="small text-muted mt-1">+{{ $newsletterThisWeek }} this week</div>
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
            <div class="h5 fw-bold">{{ $totalInquiries }}</div>
            <div class="progress-wrap mt-2">
              <div class="progress-bar-gold" style="--val:{{ $inquiriesPercent }}%"></div>
            </div>
            <div class="small text-muted mt-1">+{{ $inquiriesToday }} today</div>
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
            <div class="h5 fw-bold">{{ $totalSubscribers }}</div>
            <div class="progress-wrap mt-2">
              <div class="progress-bar-gold" style="--val:{{ $subscribersPercent }}%"></div>
            </div>
            <div class="small text-muted mt-1">+{{ $subscribersThisWeek }} this week</div>
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
            <div class="h5 fw-bold">{{ $openRoles }}</div>
            <div class="progress-wrap mt-2">
              <div class="progress-bar-gold" style="--val:{{ $rolesPercent }}%"></div>
            </div>
            <div class="small text-muted mt-1">{{ $newRoles }} new</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart & recent activity -->
    <div class="col-12 col-lg-8">
      <div class="card-soft">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <h5 class="mb-0">Engagement Overview</h5>
          <div class="btn-group btn-group-sm" id="chartRange">
            <button class="btn btn-outline-secondary active" data-range="7">7d</button>
            <button class="btn btn-outline-secondary" data-range="30">30d</button>
            <button class="btn btn-outline-secondary" data-range="90">90d</button>
          </div>
        </div>
    
        <div style="height:300px">
          <canvas id="engagementChart"></canvas>
        </div>
    
        <div class="small text-muted mt-2">
          Engagement metrics for newsletter, inquiries, and subscribers.
        </div>
      </div>
    </div>
    

    <div class="col-12 col-lg-4">
      <div class="card-soft">
        <h5 class="mb-3">Recent Activity</h5>
        <ul class="list-unstyled m-0">
          @forelse($recentActivity as $activity)
            <li class="d-flex align-items-start gap-2 mb-3">
              <i class="bi bi-dot text-warning fs-3 lh-1"></i>
              <div>
                <div class="fw-semibold">{{ $activity->message }}</div>
                <div class="small text-muted">{{ $activity->created_at->diffForHumans() }}</div>
              </div>
            </li>
          @empty
            <li class="text-muted">No recent activity yet</li>
          @endforelse
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
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const ctx = document.getElementById('engagementChart').getContext('2d');
    
      const chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: {!! json_encode(array_keys($newsletterData->toArray())) !!},
          datasets: [
            {
              label: 'Newsletters',
              data: {!! json_encode(array_values($newsletterData->toArray())) !!},
              borderColor: '#d4af37',
              borderWidth: 2,
              tension: 0.3,
              fill: false
            },
            {
              label: 'Inquiries',
              data: {!! json_encode(array_values($inquiriesData->toArray())) !!},
              borderColor: '#1890ff',
              borderWidth: 2,
              tension: 0.3,
              fill: false
            },
            {
              label: 'Subscribers',
              data: {!! json_encode(array_values($subscribersData->toArray())) !!},
              borderColor: '#28a745',
              borderWidth: 2,
              tension: 0.3,
              fill: false
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: { mode: 'index', intersect: false },
          plugins: {
            legend: { display: true, position: 'top' }
          },
          scales: {
            x: {
              ticks: { autoSkip: true, maxTicksLimit: 7 }
            },
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
    </script>
    
    
@endsection
