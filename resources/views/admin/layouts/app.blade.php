<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --village-brown: #3B2C22;
      --village-gold: #D4AF37;
      --sidebar-width: 240px;
    }

    body {
      margin: 0;
      font-family: 'Inter', sans-serif;
      background: #f8f8f8;
    }

    /* Sidebar */
    .sidebar {
      width: var(--sidebar-width);
      min-height: 100vh;
      background: var(--village-brown);
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      transition: transform 0.3s ease;
      z-index: 1030;
    }

    .sidebar .brand {
      padding: 20px;
      text-align: center;
      border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar .brand img {
      max-width: 120px;
    }

    .sidebar .nav-link {
      color: #fff;
      padding: 12px 20px;
      display: block;
      font-weight: 500;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background: var(--village-gold);
      color: #fff;
    }

    /* Content area */
    .content {
      margin-left: var(--sidebar-width);
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    /* Top navbar */
    .topbar {
      background: #fff;
      border-bottom: 1px solid #e5e5e5;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .btn-gold {
      background: var(--village-gold);
      color: #fff;
      font-weight: 600;
    }

    .btn-gold:hover {
      background: #b8962e;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }
      .sidebar.active {
        transform: translateX(0);
      }
      .content {
        margin-left: 0;
      }
      .topbar .menu-toggle {
        display: inline-block;
      }
    }

    .topbar .menu-toggle {
      display: none;
      background: var(--village-brown);
      border: none;
      padding: 6px 10px;
      color: #fff;
      border-radius: 6px;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="brand">
      <img src="https://cdn.useblocks.io/66165/250825_3375_jPr1dq0.png" alt="The Village">
    </div>
    <nav>
      <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
      <a href="#" class="nav-link">Users</a>
      <a href="#" class="nav-link">Settings</a>
      <a href="{{ route('admin.logout') }}" class="nav-link text-danger">Logout</a>
    </nav>
  </div>

  <!-- Content -->
  <div class="content">
    <!-- Topbar -->
    <div class="topbar">
      <button class="menu-toggle" onclick="toggleSidebar()">☰</button>
      <div>
        <span class="me-3">Hello, {{ Auth::user()->name }}</span>
        <a href="{{ route('admin.logout') }}" class="btn btn-sm btn-gold">Logout</a>
      </div>
    </div>

    <!-- Page Content -->
    <div class="mt-4">
      @yield('content')
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
    }
  </script>
</body>
</html>
