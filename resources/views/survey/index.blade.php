@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-lg-10 mx-auto">
    <!-- Alert Messages -->
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
      <div class="sv-hero p-4 p-md-5 mb-4">
        <h1 class="h4 mb-1 title">Khảo sát tư vấn chọn ngành</h1>
        <div class="desc">Nhập các thông tin cơ bản, sở thích và định hướng của bạn. Hệ thống sẽ đề xuất ngành học phù hợp.</div>
      </div>

      <main class="survey-main" role="main">
        <h2 class="h5 mb-2">Biểu mẫu: Sở thích & Kỹ năng</h2>
        <p class="text-muted">Chọn lựa các trường dưới đây.</p>

        <div id="profileForm" class="survey-form">

                    <div class="field full">
                        <label for="interests">Sở thích</label>
                        <select id="interests" name="interests" class="form-select">
                            <option value="" disabled selected>Chọn sở thích</option>
                            <option>Âm nhạc</option>
                            <option>Thể thao</option>
                            <option>Đọc sách</option>
                            <option>Du lịch</option>
                            <option>Game</option>
                            <option>Nấu ăn</option>
                        </select>
                        <div class="hint">Chọn 1 giá trị mô tả sở thích chính của bạn.</div>
                    </div>

                    <div class="field">
                        <label for="skills">Kỹ năng</label>
                        <select id="skills" name="skills" class="form-select">
                            <option value="" disabled selected>Chọn kỹ năng</option>
                            <option>Lập trình</option>
                            <option>Giao tiếp</option>
                            <option>Thiết kế</option>
                            <option>Quản lý dự án</option>
                            <option>Phân tích dữ liệu</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="subject">Môn học yêu thích</label>
                        <select id="subject" name="subject" class="form-select">
                            <option value="" disabled selected>Chọn môn học</option>
                            <option>Toán</option>
                            <option>Vật lý</option>
                            <option>Hóa học</option>
                            <option>Ngữ văn</option>
                            <option>Tin học</option>
                            <option>Tiếng Anh</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="career">Định hướng nghề nghiệp</label>
                        <select id="career" name="career" class="form-select">
                            <option value="" disabled selected>Chọn định hướng</option>
                            <option>Kỹ sư phần mềm</option>
                            <option>Data Scientist</option>
                            <option>Thiết kế UX/UI</option>
                            <option>Giảng dạy</option>
                            <option>Kinh doanh / Marketing</option>
                            <option>Khởi nghiệp</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="techLove">Mức độ yêu thích công nghệ</label>
                        <select id="techLove" name="techLove" class="form-select">
                            <option value="" disabled selected>Chọn mức độ</option>
                            <option>Rất yêu thích</option>
                            <option>Thích</option>
                            <option>Bình thường</option>
                            <option>Ít quan tâm</option>
                            <option>Không thích</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="creativity">Sáng tạo</label>
                        <select id="creativity" name="creativity" class="form-select">
                            <option value="" disabled selected>Chọn mức độ</option>
                            <option>Rất sáng tạo</option>
                            <option>Sáng tạo</option>
                            <option>Trung bình</option>
                            <option>Ít sáng tạo</option>
                        </select>
                    </div>

          <div class="survey-actions">
            <button type="button" class="btn-ghost" onclick="document.getElementById('surveyForm').reset()">Đặt lại</button>
            <button type="button" id="saveDraft" class="btn btn-outline-secondary">
              <span class="spinner-border spinner-border-sm d-none"></span>
              Lưu nháp
            </button>
            <button type="submit" id="submitSurvey" class="btn-primary-soft">Gửi</button>
          </div>
        </div>
      </main>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Update range values
  document.querySelectorAll('.skill-range').forEach(function(range) {
    const target = range.getAttribute('data-target');
    range.addEventListener('input', function() {
      document.getElementById(target).textContent = this.value;
    });
  });

  // Auto-save functionality
  let saveTimeout;
  const form = document.getElementById('surveyForm');
  
  function autoSave() {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(function() {
      const formData = new FormData(form);
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('is_draft', '1');
      
      fetch('{{ route("survey.draft") }}', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          console.log('Auto-saved');
        }
      })
      .catch(error => console.log('Auto-save failed'));
    }, 3000);
  }

  // Add auto-save listeners
  form.addEventListener('input', autoSave);
  form.addEventListener('change', autoSave);

  // Manual save draft
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
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert('Đã lưu nháp thành công!');
      }
    })
    .catch(error => {
      alert('Lỗi khi lưu nháp!');
    })
    .finally(() => {
      btn.disabled = false;
      spinner.classList.add('d-none');
    });
  });

  // Form submission
  form.addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitSurvey');
    const spinner = submitBtn.querySelector('.spinner-border');
    
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
  });
});
</script>
@endsection