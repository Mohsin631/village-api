<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>@yield('title', 'Admin Auth')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root{
      --village-brown:#3B2C22;
      --village-gold:#D4AF37;
      --bg:#f8f8f8;
    }
    body{background:var(--bg);font-family:system-ui,-apple-system,'Segoe UI',Inter,Roboto,Arial,sans-serif;}

    /* Left brand side */
    .brand-side{
      background:var(--village-brown);
      color:#fff;
      display:flex;
      align-items:center;
      justify-content:center;
      text-align:center;
      padding:40px 24px;
    }
    .brand-wrap{max-width:440px}
    .brand-logo{max-width:160px;width:100%}

    /* Right form side */
    .form-side{
      display:flex;
      align-items:center;
      justify-content:center;
      padding:32px 16px;
      background:var(--bg);
    }
    .auth-card{
      background:#fff;
      border-radius:16px;
      box-shadow:0 8px 22px rgba(0,0,0,.12);
      padding:28px;
      width:100%;
      max-width:420px;
    }
    .btn-gold{background:var(--village-gold);color:#fff;font-weight:600}
    .btn-gold:hover{background:#b8962e;color:#fff}

    /* Mobile tweaks */
    @media (max-width: 767.98px){
      .brand-side{padding:28px 18px}
      .brand-logo{max-width:120px}
      .auth-card{padding:22px;box-shadow:0 6px 16px rgba(0,0,0,.10)}
    }
  </style>
</head>
<body>

  <!-- 100% height grid; stacks on mobile, splits on md+ -->
  <div class="container-fluid">
    <div class="row g-0 min-vh-100">
      <!-- LEFT: branding (full width on mobile, 6/12 on md+) -->
      <div class="col-12 col-md-6 brand-side">
        <div class="brand-wrap">
          <img class="brand-logo mb-3" src="https://cdn.useblocks.io/66165/250825_3375_jPr1dq0.png" alt="The Village Logo">
          <h2 class="h4 fw-bold mb-1">@yield('brand_title', 'The Village – Admin')</h2>
          <p class="mb-0 opacity-75">@yield('brand_subtitle', 'Luxury • Culture • Experience')</p>
        </div>
      </div>

      <!-- RIGHT: form (full width on mobile, 6/12 on md+) -->
      <div class="col-12 col-md-6 form-side">
        <div class="auth-card w-100">
          <h3 class="text-center mb-4" style="color:#3B2C22;">@yield('form_title')</h3>

          @if($errors->any())
            <div class="alert alert-danger py-2 px-3 mb-3">{{ $errors->first() }}</div>
          @endif

          @yield('form')
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
