<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'CodeX Advisor') }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="/">CodeX Advisor</a>
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      @auth
      <li class="nav-item"><a class="nav-link" href="{{ route('survey.index') }}">Khảo sát</a></li>
      @can('admin')
      <li class="nav-item"><a class="nav-link" href="{{ route('admin.majors.index') }}">Quản lý ngành</a></li>
      @endcan
      @endauth
    </ul>
    <div class="d-flex">
      @auth
        <span class="navbar-text me-3">{{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-light btn-sm">Đăng xuất</button></form>
      @endauth
      @guest
        <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">Đăng nhập</a>
      @endguest
    </div>
  </div>
</nav>
<div class="container mb-5">
  @isset($slot)
    {{ $slot }}
  @endisset
  @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script defer src="{{ asset('assets/js/survey.js') }}"></script>
</body>
</html>