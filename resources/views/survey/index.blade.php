@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-10 mx-auto">
    <h1 class="h3 mb-3">Khảo sát tư vấn chọn ngành FPT Polytechnic</h1>
    <div class="alert alert-info">
      Thu thập: sở thích, kỹ năng/tố chất, điểm các môn, thói quen học, định hướng nghề. Kết quả sẽ được AI phân tích và gợi ý ngành phù hợp.
    </div>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="scores-tab" data-bs-toggle="pill" data-bs-target="#scores" type="button" role="tab">Điểm môn</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="interests-tab" data-bs-toggle="pill" data-bs-target="#interests" type="button" role="tab">Sở thích</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="skills-tab" data-bs-toggle="pill" data-bs-target="#skills" type="button" role="tab">Kỹ năng/Tố chất</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="habits-tab" data-bs-toggle="pill" data-bs-target="#habits" type="button" role="tab">Thói quen</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="career-tab" data-bs-toggle="pill" data-bs-target="#career" type="button" role="tab">Định hướng nghề</button>
      </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="scores" role="tabpanel">
        <form id="scoresForm" class="card mb-4 p-3">
          <h2 class="h5">Điểm các môn</h2>
          <div id="scoresList" class="row g-2"></div>
          <div class="d-flex gap-2 mt-2">
            <button type="button" class="btn btn-outline-secondary" id="saveScores">Lưu tạm</button>
          </div>
        </form>
      </div>

      <div class="tab-pane fade" id="interests" role="tabpanel">
        <div class="card p-3">
          <h2 class="h6">Sở thích</h2>
          <div id="questionsInterests" class="vstack gap-3"></div>
        </div>
      </div>

      <div class="tab-pane fade" id="skills" role="tabpanel">
        <div class="card p-3">
          <h2 class="h6">Kỹ năng/Tố chất</h2>
          <div id="questionsSkills" class="vstack gap-3"></div>
        </div>
      </div>

      <div class="tab-pane fade" id="habits" role="tabpanel">
        <div class="card p-3">
          <h2 class="h6">Thói quen học tập</h2>
          <div id="questionsHabits" class="vstack gap-3"></div>
        </div>
      </div>

      <div class="tab-pane fade" id="career" role="tabpanel">
        <div class="card p-3">
          <h2 class="h6">Định hướng nghề nghiệp</h2>
          <div id="questionsCareer" class="vstack gap-3"></div>
          <div class="d-flex gap-2 mt-3">
            <button type="button" class="btn btn-outline-secondary" id="saveResponses">Lưu tạm</button>
            <button type="button" class="btn btn-primary" id="submitSurvey">Nộp khảo sát</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


