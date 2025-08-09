@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-8 mx-auto">
    <h1 class="h4 mb-3">Kết quả tư vấn</h1>
    @if(!$rec)
      <div class="alert alert-warning">Đang phân tích bằng AI... Trang sẽ tự cập nhật.</div>
      <script>
        setTimeout(()=>location.reload(), 3000)
      </script>
    @else
      <div class="vstack gap-3">
        <div class="card p-3">
          <h2 class="h5 mb-2">Ngành gợi ý</h2>
          <ul class="list-group list-group-flush">
          @php
            $displayMajors = $topMajors ?? ($rec->top_major_ids_json ?? []);
          @endphp
          @forelse($displayMajors as $m)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <div class="fw-semibold">{{ $m['name'] ?? ($m['code'] ?? 'N/A') }}</div>
                @if(!empty($m['code']))<div class="small text-muted">Mã: {{ $m['code'] }}</div>@endif
              </div>
              @if(!empty($m['score']))<span class="badge bg-primary">{{ $m['score'] }}%</span>@endif
            </li>
          @empty
            <li class="list-group-item">Chưa có gợi ý cụ thể. Vui lòng đợi thêm hoặc thử lại.</li>
          @endforelse
          </ul>
        </div>
        @if(!empty($rec->explanation_md))
          <div class="card p-3">
            <h2 class="h6">Giải thích</h2>
            <div class="markdown-body">{!! Str::markdown($rec->explanation_md) !!}</div>
          </div>
        @endif
      </div>
    @endif
  </div>
</div>
@endsection


