@extends('layouts.app')

@section('content')
<style>
  :root{
    --codex-primary:#0b3b5a; /* xanh than */
    --codex-accent:#1f6fb2;
    --codex-bg:#0a2740;
  }
  .codex-hero{background:linear-gradient(135deg,var(--codex-bg),var(--codex-primary));color:#fff;border-radius:16px}
  .stat-card{border:0;border-radius:14px;background:#0e3553;color:#e6eef5}
  .stat-card .value{font-size:28px;font-weight:700;color:#fff}
  .stat-card .label{opacity:.8}
  .list-item{background:#0e3553;border-radius:12px}
  .list-item + .list-item{margin-top:10px}
  .btn-accent{background:var(--codex-accent);color:#fff;border:none}
  .btn-accent:hover{filter:brightness(1.05)}
</style>

<div class="codex-hero p-4 p-md-5 mb-4">
  <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
    <div>
      <h1 class="h3 mb-1">Chào {{ auth()->user()->name }}</h1>
      <div class="opacity-75">Bảng điều khiển tư vấn ngành học</div>
    </div>
    <div class="d-flex gap-2">
      <a href="{{ route('survey.index') }}" class="btn btn-accent">Làm khảo sát</a>
      @can('admin')
      <a href="{{ route('admin.majors.index') }}" class="btn btn-outline-light">Quản trị</a>
      @endcan
    </div>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-6 col-lg-3">
    <div class="stat-card p-3">
      <div class="label">Lượt khảo sát</div>
      <div class="value">12</div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="stat-card p-3">
      <div class="label">Kết quả mới</div>
      <div class="value">3</div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="stat-card p-3">
      <div class="label">Ngành đang mở</div>
      <div class="value">10</div>
    </div>
  </div>
  <div class="col-6 col-lg-3">
    <div class="stat-card p-3">
      <div class="label">Điểm trung bình</div>
      <div class="value">7.8</div>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-lg-7">
    <div class="card border-0" style="border-radius:16px; overflow:hidden">
      <div class="card-header text-white" style="background:#11476e">Kết quả gần đây</div>
      <div class="card-body p-0">
        <div class="p-3 list-item d-flex align-items-center justify-content-between">
          <div>
            <div class="fw-semibold">SE - Software Engineering</div>
            <div class="small opacity-75">Phù hợp 92% - từ bài khảo sát ngày 09/08</div>
          </div>
          <span class="badge bg-success">Top 1</span>
        </div>
        <div class="p-3 list-item d-flex align-items-center justify-content-between">
          <div>
            <div class="fw-semibold">BA - Business Administration</div>
            <div class="small opacity-75">Phù hợp 84% - từ bài khảo sát ngày 07/08</div>
          </div>
          <span class="badge bg-primary">Top 2</span>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card border-0" style="border-radius:16px; overflow:hidden">
      <div class="card-header text-white" style="background:#11476e">Tác vụ nhanh</div>
      <div class="card-body">
        <div class="d-grid gap-2">
          <a class="btn btn-accent" href="{{ route('survey.index') }}">Bắt đầu khảo sát mới</a>
          <a class="btn btn-outline-secondary" href="/">Xem hướng dẫn sử dụng</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
