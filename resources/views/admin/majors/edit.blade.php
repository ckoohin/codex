@extends('layouts.app')

@section('content')
<h1 class="h4 mb-3">Sửa ngành</h1>
<form method="POST" action="{{ route('admin.majors.update',$major) }}" class="card p-3">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="form-label">Mã ngành</label>
    <input name="code" class="form-control" value="{{ old('code',$major->code) }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Tên ngành</label>
    <input name="name" class="form-control" value="{{ old('name',$major->name) }}" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Mô tả</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description',$major->description) }}</textarea>
  </div>
  <div class="form-check form-switch mb-3">
    <input class="form-check-input" type="checkbox" name="is_active" {{ $major->is_active?'checked':'' }}>
    <label class="form-check-label">Kích hoạt</label>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.majors.index') }}" class="btn btn-secondary">Hủy</a>
    <button class="btn btn-primary">Lưu</button>
  </div>
</form>
@endsection


