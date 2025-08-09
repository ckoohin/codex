@extends('layouts.app')

@push('styles')
<style>
  :root {
    --cdx-primary: #1363df;
    --cdx-bg: #f6f9ff;
    --cdx-dark: #0f172a;
    --cdx-muted: #64748b;
  }
  body { background: var(--cdx-bg); }
  .sv-card {
    border: none;
    border-radius: 16px;
    background: #fff;
    box-shadow: 0 6px 24px rgba(17, 24, 39, 0.06);
  }
  .sv-card .card-header {
    background: var(--cdx-primary);
    color: #fff;
    border-radius: 16px 16px 0 0;
  }
  label { font-weight: 600; }
  .btn-primary {
    background: var(--cdx-primary);
    border: none;
  }
  .btn-outline-secondary {
    border-radius: 8px;
  }
  .alert {
    border-radius: 10px;
  }
</style>
@endpush

@section('content')
<div class="container py-4">
  <div class="col-lg-8 mx-auto">

    {{-- Alert Messages --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <form id="surveyForm" method="POST" action="{{ route('survey.submit') }}">
      @csrf
      <div class="card sv-card">
        <div class="card-header">
          <h5 class="mb-0">Khảo sát tư vấn chọn ngành</h5>
        </div>
        <div class="card-body">
          <p class="text-muted">Nhập các thông tin cơ bản, sở thích và định hướng của bạn. Hệ thống sẽ đề xuất ngành học phù hợp.</p>

          @php
            $fields = [
              'interests' => ['label' => 'Sở thích', 'options' => ['Âm nhạc','Thể thao','Đọc sách','Du lịch','Game','Nấu ăn']],
              'skills' => ['label' => 'Kỹ năng', 'options' => ['Lập trình','Giao tiếp','Thiết kế','Quản lý dự án','Phân tích dữ liệu']],
              'subject' => ['label' => 'Môn học yêu thích', 'options' => ['Toán','Vật lý','Hóa học','Ngữ văn','Tin học','Tiếng Anh']],
              'career' => ['label' => 'Định hướng nghề nghiệp', 'options' => ['Kỹ sư phần mềm','Data Scientist','Thiết kế UX/UI','Giảng dạy','Kinh doanh / Marketing','Khởi nghiệp']],
              'techLove' => ['label' => 'Mức độ yêu thích công nghệ', 'options' => ['Rất yêu thích','Thích','Bình thường','Ít quan tâm','Không thích']],
              'creativity' => ['label' => 'Sáng tạo', 'options' => ['Rất sáng tạo','Sáng tạo','Trung bình','Ít sáng tạo']],
            ];
          @endphp

          @foreach($fields as $name => $field)
            <div class="mb-3">
              <label for="{{ $name }}" class="form-label">{{ $field['label'] }}</label>
              <select id="{{ $name }}" name="{{ $name }}" class="form-select" required>
                <option value="" disabled selected>-- Chọn {{ strtolower($field['label']) }} --</option>
                @foreach($field['options'] as $option)
                  <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
              </select>
            </div>
          @endforeach
        </div>

        <div class="card-footer d-flex justify-content-between">
          <button type="button" id="saveDraft" class="btn btn-outline-secondary">
            <span class="spinner-border spinner-border-sm d-none"></span>
            Lưu nháp
          </button>
          <button type="submit" id="submitSurvey" class="btn btn-primary">
            <span class="spinner-border spinner-border-sm d-none"></span>
            Gửi khảo sát
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('surveyForm');

  // Auto-save functionality
  let saveTimeout;
  function autoSave() {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => {
      const formData = new FormData(form);
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('is_draft', '1');

      fetch('{{ route("survey.draft") }}', {
        method: 'POST',
        body: formData
      }).then(res => res.json()).then(data => {
        if (data.success) console.log('Auto-saved');
      }).catch(() => console.log('Auto-save failed'));
    }, 2000);
  }
  form.addEventListener('input', autoSave);

  // Save draft button
  document.getElementById('saveDraft').addEventListener('click', function() {
    const btn = this;
    const spinner = btn.querySelector('.spinner-border');
    btn.disabled = true;
    spinner.classList.remove('d-none');

    const formData = new FormData(form);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('is_draft', '1');

    fetch('{{ route("survey.draft") }}', {
      method: 'POST',
      body: formData
    }).then(res => res.json()).then(data => {
      if (data.success) alert('Đã lưu nháp thành công!');
    }).catch(() => alert('Lỗi khi lưu nháp!'))
    .finally(() => {
      btn.disabled = false;
      spinner.classList.add('d-none');
    });
  });

  // Submit form
  form.addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitSurvey');
    const spinner = submitBtn.querySelector('.spinner-border');
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
  });
});
</script>
@endpush
@endsection