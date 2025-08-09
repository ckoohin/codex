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
          <h2 class="h5 mb-2">Ngành gợi ý hàng đầu</h2>
          <ul class="list-group list-group-flush">
          @foreach(($rec->ai_raw_json['top_majors'] ?? []) as $m)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <span>{{ $m['major_code'] }}</span>
              <span class="badge bg-primary">{{ $m['score'] }}%</span>
            </li>
          @endforeach
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


