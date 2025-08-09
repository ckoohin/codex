@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1 class="h4">Ngành học</h1>
  <a href="{{ route('admin.majors.create') }}" class="btn btn-primary btn-sm">Thêm ngành</a>
  </div>

@if(session('ok'))<div class="alert alert-success">{{ session('ok') }}</div>@endif

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
  @foreach($majors as $m)
  <div class="col">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title mb-1">{{ $m->name }}</h5>
        <div class="small text-muted">{{ $m->code }}</div>
        <p class="mt-2 text-truncate">{{ $m->description }}</p>
        <span class="badge {{ $m->is_active?'bg-success':'bg-secondary' }}">{{ $m->is_active?'Active':'Inactive' }}</span>
      </div>
      <div class="card-footer d-flex gap-2">
        <a href="{{ route('admin.majors.edit',$m) }}" class="btn btn-outline-primary btn-sm">Sửa</a>
        <form method="POST" action="{{ route('admin.majors.destroy',$m) }}" onsubmit="return confirm('Xóa ngành này?')">
          @csrf @method('DELETE')
          <button class="btn btn-outline-danger btn-sm">Xóa</button>
        </form>
      </div>
    </div>
  </div>
  @endforeach
</div>

<div class="mt-3">{{ $majors->links() }}</div>
@endsection


