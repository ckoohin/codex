@extends('layouts.app')

@section('content')
<style>
  :root{ --codex-primary:#0b3b5a; --codex-bg:#0a2740; --codex-accent:#1f6fb2; }
  .sv-hero{background:linear-gradient(135deg,var(--codex-bg),var(--codex-primary));color:#fff;border-radius:16px}
  .sv-card{border:0;border-radius:14px;background:#0e3553;color:#e6eef5}
  .sv-card .form-control,.sv-card .form-select{background:#0b2f4b;border-color:#11476e;color:#fff}
  .nav-pills .nav-link{color:#fff;background:#0e3553;margin-right:8px}
  .nav-pills .nav-link.active{background:var(--codex-accent)}
  .btn-accent{background:var(--codex-accent);color:#fff;border:none}
</style>

<div class="row">
  <div class="col-lg-10 mx-auto">
    <div class="sv-hero p-4 p-md-5 mb-4">
      <h1 class="h4 mb-2">Khảo sát tư vấn chọn ngành</h1>
      <div class="opacity-75">Nhập điểm, sở thích, kỹ năng và định hướng. AI sẽ phân tích và gợi ý ngành phù hợp.</div>
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
        <form id="scoresForm" class="sv-card mb-4 p-3">
          <h2 class="h5">Điểm các môn</h2>
          <div id="scoresList" class="row g-2">
            @foreach(($subjects ?? []) as $s)
              <div class="col-6 col-md-3">
                <label class="form-label">{{ $s->name }}</label>
                <input type="number" min="0" max="10" step="0.1" class="form-control score-input" data-subject-id="{{ $s->id }}" placeholder="0-10">
              </div>
            @endforeach
          </div>
          <div class="d-flex gap-2 mt-2">
            <button type="button" class="btn btn-outline-light" id="saveScores">Lưu tạm</button>
          </div>
        </form>
      </div>

      <div class="tab-pane fade" id="interests" role="tabpanel">
        <div class="sv-card p-3">
          <h2 class="h6">Sở thích</h2>
          <div id="questionsInterests" class="vstack gap-3">
            @foreach(($questions ?? collect())->where('category','interests') as $q)
              <div class="p-2 border rounded">
                <div class="fw-bold mb-2">{{ $q->text }}</div>
                <input class="form-control response-input" data-question-id="{{ $q->id }}" placeholder="Nhập câu trả lời">
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="skills" role="tabpanel">
        <div class="sv-card p-3">
          <h2 class="h6">Kỹ năng/Tố chất</h2>
          <div id="questionsSkills" class="vstack gap-3">
            @foreach(($questions ?? collect())->where('category','skills') as $q)
              <div class="p-2 border rounded">
                <label class="form-label">{{ $q->text }}</label>
                <input type="range" min="0" max="10" step="1" class="form-range response-input" data-question-id="{{ $q->id }}">
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="habits" role="tabpanel">
        <div class="sv-card p-3">
          <h2 class="h6">Thói quen học tập</h2>
          <div id="questionsHabits" class="vstack gap-3">
            @foreach(($questions ?? collect())->where('category','habits') as $q)
              <div class="p-2 border rounded">
                <div class="fw-bold mb-2">{{ $q->text }}</div>
                <input class="form-control response-input" data-question-id="{{ $q->id }}" placeholder="Nhập câu trả lời">
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="career" role="tabpanel">
        <div class="sv-card p-3">
          <h2 class="h6">Định hướng nghề nghiệp</h2>
          <div id="questionsCareer" class="vstack gap-3">
            @foreach(($questions ?? collect())->where('category','career') as $q)
              <div class="p-2 border rounded">
                <div class="fw-bold mb-2">{{ $q->text }}</div>
                <input class="form-control response-input" data-question-id="{{ $q->id }}" placeholder="Nhập câu trả lời">
              </div>
            @endforeach
          </div>
          <div class="d-flex gap-2 mt-3">
            <button type="button" class="btn btn-outline-light" id="saveResponses">Lưu tạm</button>
            <button type="button" class="btn btn-accent" id="submitSurvey">Nộp khảo sát</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


