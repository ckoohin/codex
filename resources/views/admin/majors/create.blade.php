@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Thêm ngành</h1>

@if($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<form method="POST" action="{{ route('admin.majors.store') }}" class="card p-3">
  @csrf
  <div class="mb-3">
    <label class="form-label">Mã ngành</label>
    <input name="code" class="form-control" value="{{ old('code') }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Tên ngành</label>
    <input name="name" class="form-control" value="{{ old('name') }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Mô tả</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Tags (phân tách bằng dấu phẩy)</label>
    <input name="tags" class="form-control" placeholder="AI, Data, Design" value="{{ is_array(old('tags')) ? implode(', ', old('tags')) : old('tags') }}">
  </div>
  <div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" name="is_active" checked>
    <label class="form-check-label">Kích hoạt</label>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.majors.index') }}" class="btn btn-secondary">Hủy</a>
    <button type="submit" class="btn btn-primary">Lưu</button>
  </div>
</form>
@endsection


