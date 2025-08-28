<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Admin Dashboard')</title>

  <!-- Fonts + Icons + Bootstrap -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --brown:#3B2C22;
      --brown-600:#2e2119;
      --gold:#D4AF37;
      --gold-600:#b8962e;
      --bg:#f6f6f6;
      --card:#ffffff;
      --text:#1d1d1f;
      --muted:#6b7280;
      --ring: rgba(212,175,55, .35);
    }
    [data-theme="dark"]{
      --bg:#0f1115;
      --card:#151820;
      --text:#e5e7eb;
      --muted:#9aa1ad;
      --ring: rgba(212,175,55, .25);
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      background: var(--bg);
      color: var(--text);
    }

    /* Topbar */
    .topbar{
      position:sticky; top:0; z-index:1040;
      backdrop-filter: blur(10px);
      background: color-mix(in oklab, var(--card), transparent 25%);
      border-bottom: 1px solid rgba(0,0,0,.06);
    }
    [data-theme="dark"] .topbar{ border-color: rgba(255,255,255,.06); }

    .btn-gold{
      background: linear-gradient(135deg, var(--gold), var(--gold-600));
      color:#fff; font-weight:600; border:none;
      box-shadow: 0 8px 20px rgba(212,175,55,.25);
    }
    .btn-gold:hover{ filter:brightness(.98) }

    /* Layout */
    .shell{ display:grid; grid-template-columns: 260px 1fr; gap: 24px; }
    @media (max-width: 992px){ .shell{ grid-template-columns: 1fr; } }

    /* Sidebar */
    .sidebar{
      position: sticky; top: 88px;
      height: calc(100vh - 100px);
      border-radius: 16px;
      background: linear-gradient(180deg, var(--brown), var(--brown-600));
      color:#fff;
      box-shadow: 0 16px 40px rgba(0,0,0,.25);
      overflow: hidden;
    }
    .sidebar-head{
      display:flex; align-items:center; gap:12px;
      padding:18px 16px; border-bottom: 1px solid rgba(255,255,255,.12);
    }
    .brand-logo{ width:42px; height:42px; object-fit:contain; border-radius:10px; background: rgba(255,255,255,.12); padding:6px; }
    .brand-title{ font-weight:700; letter-spacing:.3px; }
    .nav-rail{ padding:10px }
    .nav-rail a{
      display:flex; align-items:center; gap:12px;
      color:#fff; text-decoration:none;
      padding:12px 14px; border-radius:12px; font-weight:500;
      opacity:.95; transition: all .2s ease;
    }
    .nav-rail a:hover{ background: rgba(255,255,255,.12); transform: translateY(-1px); }
    .nav-rail a.active{ background: var(--gold); color:#fff; box-shadow: 0 8px 20px rgba(212,175,55,.35); }
    .nav-rail i{ font-size: 1.1rem; width:22px; text-align:center }

    /* Content area */
    .content-wrap{ padding: 20px 6px 60px; }
    .page-header{ display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
    .search{
      position:relative; min-width:260px;
    }
    .search input{
      background: var(--card);
      border: 1px solid rgba(0,0,0,.06);
      border-radius: 12px; padding:10px 36px 10px 42px;
      outline: none; width:100%;
      color: var(--text);
    }
    [data-theme="dark"] .search input{ border-color: rgba(255,255,255,.06); }
    .search i{
      position:absolute; top: 50%; left: 12px; transform: translateY(-50%);
      color: var(--muted);
    }

    /* Cards */
    .card-soft{
      background: var(--card); border:1px solid rgba(0,0,0,.06);
      border-radius:16px; padding:18px;
      box-shadow: 0 10px 30px rgba(0,0,0,.06);
    }
    [data-theme="dark"] .card-soft{ border-color: rgba(255,255,255,.06); }
    .kpi{
      display:flex; align-items:flex-start; gap:14px;
    }
    .kpi .kpi-icon{
      width:40px; height:40px; border-radius:12px;
      display:grid; place-items:center; color:#fff;
      background: linear-gradient(135deg, var(--gold), var(--gold-600));
      box-shadow: 0 8px 18px rgba(212,175,55,.35);
    }
    .progress-wrap{
      height:8px; background: rgba(0,0,0,.08); border-radius: 10px; overflow: hidden;
    }
    .progress-bar-gold{
      height:100%;
      background: linear-gradient(90deg, var(--gold), var(--gold-600));
      width: var(--val, 60%);
    }

    /* Chart placeholder */
    .mini-chart{
      width:100%; height:120px; border-radius:12px; overflow:hidden;
      background: conic-gradient(from 270deg at 0% 100%, rgba(212,175,55,.18), transparent 40%),
                  linear-gradient(180deg, rgba(212,175,55,.10), transparent 70%);
    }

    /* Avatar dropdown */
    .avatar{
      width:36px; height:36px; border-radius:50%; overflow:hidden;
      background: #ddd;
    }

    /* Mobile sidebar drawer */
    .drawer-toggle{ display:none; }
    @media (max-width: 992px){
      .sidebar{
        position: fixed; left:16px; right:16px; top: 72px; height: auto; max-height: 70vh;
        transform: translateY(-130%); transition: transform .25s ease;
      }
      .sidebar.open{ transform: translateY(0%); }
      .drawer-toggle{ display:inline-flex; align-items:center; gap:8px; }
    }

    /* Focus ring */
    .ring:focus{ outline: 3px solid var(--ring); outline-offset:2px; }
  </style>
</head>
<body>

  <!-- Topbar -->
  <header class="topbar py-2 px-3">
    <div class="container-xxl d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm text-white drawer-toggle" style="background:var(--brown);" onclick="toggleDrawer()">
          <i class="bi bi-list"></i> Menu
        </button>

        <div class="search">
          <i class="bi bi-search"></i>
          <input class="ring" type="search" placeholder="Search…" />
        </div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-outline-secondary" onclick="toggleTheme()" title="Toggle theme">
          <i class="bi bi-moon-stars"></i>
        </button>

        <div class="dropdown">
          <button class="btn d-flex align-items-center gap-2" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="avatar">
              <img src="https://i.pravatar.cc/80?img=68" alt="" width="36" height="36">
            </div>
            <span class="d-none d-md-inline fw-semibold">{{ Auth::user()->name ?? 'Admin' }}</span>
            <i class="bi bi-chevron-down small text-muted"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow">
            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="{{ route('admin.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

  <main class="container-xxl mt-3">
    <div class="shell">
      <!-- Sidebar -->
      <aside id="sidebar" class="sidebar">
        <div class="sidebar-head">
          <img class="brand-logo" src="https://cdn.useblocks.io/66165/250825_3375_jPr1dq0.png" alt="Village">
          <div>
            <div class="brand-title">The Village</div>
            <div style="opacity:.8; font-size:12px">Admin Panel</div>
          </div>
        </div>

        <nav class="nav-rail">
          <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
          <a href="{{ route('admin.newsletters.index') }}" class="{{ request()->routeIs('admin.newsletters.index') ? 'active' : '' }}">
            <i class="bi bi-envelope-paper"></i> Newsletter
          </a>
          <a href="{{ route('admin.subscribers.index') }}" class="{{ request()->routeIs('admin.subscribers.index') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Subscribers
          </a> 
          <a href="{{ route('admin.inquiries.index') }}" class="{{ request()->routeIs('admin.inquiries.index') ? 'active' : '' }}">
            <i class="bi bi-inboxes"></i> Inquiries
          </a>                   
          <a href="#"><i class="bi bi-briefcase"></i> Careers</a>
          <a href="#"><i class="bi bi-gear"></i> Settings</a>
          <a href="{{ route('admin.logout') }}" class="mt-2" style="background:rgba(255,255,255,.10)">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        </nav>
      </aside>

      <!-- Content -->
      <section class="content-wrap">
        <div class="page-header mb-3">
          <div>
            <h1 class="h4 fw-bold mb-1">@yield('title','Dashboard')</h1>
            <div class="text-muted small">Welcome back, {{ Auth::user()->name ?? 'Admin' }}.</div>
          </div>
          {{-- <div class="d-flex gap-2">
            <a class="btn btn-gold" href="#"><i class="bi bi-plus-lg me-1"></i> New</a>
            <a class="btn btn-outline-secondary" href="#"><i class="bi bi-upload me-1"></i> Export</a>
          </div> --}}
        </div>

        @yield('content')
      </section>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const root = document.documentElement;

    // Theme
    (function initTheme(){
      const saved = localStorage.getItem('village-theme');
      if(saved){ document.documentElement.setAttribute('data-theme', saved); }
    })();
    function toggleTheme(){
      const cur = document.documentElement.getAttribute('data-theme') || 'light';
      const next = (cur === 'light') ? 'dark' : 'light';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('village-theme', next);
    }

    // Mobile drawer
    function toggleDrawer(){
      document.getElementById('sidebar').classList.toggle('open');
    }
  </script>
</body>
</html>
