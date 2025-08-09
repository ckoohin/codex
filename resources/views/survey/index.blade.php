@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-8 mx-auto">
    <h1 class="h3 mb-3">Khảo sát tư vấn ngành học</h1>
    <div class="alert alert-info">Nhập điểm các môn và trả lời vài câu hỏi ngắn. Bạn có thể lưu tạm ở trình duyệt.</div>

    <form id="scoresForm" class="card mb-4 p-3">
      <h2 class="h5">Điểm các môn</h2>
      <div id="scoresList" class="row g-2">
        <!-- JS sẽ render danh sách môn học mẫu nếu chưa seed -->
      </div>
      <button type="button" class="btn btn-outline-secondary mt-2" id="saveScores">Lưu tạm</button>
    </form>

    <form id="responsesForm" class="card p-3">
      <h2 class="h5">Câu hỏi nhanh</h2>
      <div id="questionsList" class="vstack gap-3"></div>
      <div class="d-flex gap-2 mt-3">
        <button type="button" class="btn btn-outline-secondary" id="saveResponses">Lưu tạm</button>
        <button type="button" class="btn btn-primary" id="submitSurvey">Nộp khảo sát</button>
      </div>
    </form>
  </div>
</div>
@endsection


