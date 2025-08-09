(() => {
  const api = {
    post: async (url, data) => {
      const res = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name=_token]')?.value
        },
        body: JSON.stringify(data),
      });
      if (!res.ok) throw new Error(await res.text());
      return res.json();
    }
  };

  function el(id){ return document.getElementById(id); }

  const scoresForm = el('scoresForm');
  const responsesForm = el('responsesForm');
  if (!scoresForm || !responsesForm) return;

  const subjects = [
    {id: 1, name: 'Toán'},
    {id: 2, name: 'Văn'},
    {id: 3, name: 'Anh'},
    {id: 4, name: 'Tin học'},
  ];

  const questions = [
    {id: 101, text: 'Bạn thích lập trình hay thiết kế?', type: 'single', options: ['Lập trình','Thiết kế']},
    {id: 102, text: 'Bạn tự đánh giá mức độ sáng tạo?', type: 'scale'},
  ];

  // Render subjects
  const scoresList = el('scoresList');
  subjects.forEach(s => {
    const col = document.createElement('div');
    col.className = 'col-6 col-md-3';
    col.innerHTML = `<label class="form-label">${s.name}</label>
      <input type="number" min="0" max="10" step="0.1" class="form-control" data-subject-id="${s.id}" value="${loadLS('score_'+s.id) || ''}">`;
    scoresList.appendChild(col);
  });

  // Render questions
  const questionsList = el('questionsList');
  questions.forEach(q => {
    const wrap = document.createElement('div');
    wrap.className = 'card p-3';
    if (q.type === 'single') {
      wrap.innerHTML = `<div class="fw-bold mb-2">${q.text}</div>
        ${q.options.map((op,i)=>`<div class="form-check">
          <input class="form-check-input" type="radio" name="q_${q.id}" value="${op}" ${loadLS('q_'+q.id)===op?'checked':''}>
          <label class="form-check-label">${op}</label>
        </div>`).join('')}`
    } else if (q.type === 'scale') {
      wrap.innerHTML = `<label class="form-label">${q.text}</label>
        <input type="range" min="0" max="10" step="1" class="form-range" name="q_${q.id}" value="${loadLS('q_'+q.id) || 5}">`;
    }
    questionsList.appendChild(wrap);
  });

  function saveLS(key, val){ localStorage.setItem(key, JSON.stringify(val)); }
  function loadLS(key){ try { return JSON.parse(localStorage.getItem(key)); } catch{ return null } }

  el('saveScores').addEventListener('click', ()=>{
    document.querySelectorAll('[data-subject-id]').forEach(inp=>{
      saveLS('score_'+inp.dataset.subjectId, inp.value || '');
    });
  });

  el('saveResponses').addEventListener('click', ()=>{
    questions.forEach(q=>{
      const val = q.type==='single' ? (document.querySelector(`input[name="q_${q.id}"]:checked`)?.value||'') : document.querySelector(`[name="q_${q.id}"]`)?.value;
      saveLS('q_'+q.id, val);
    });
  });

  el('submitSurvey').addEventListener('click', async ()=>{
    try {
      // 1. tạo survey
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '/survey/submit';
      document.body.appendChild(form);
      const csrf = document.querySelector('input[name=_token]');
      if (csrf) form.appendChild(csrf.cloneNode());
      form.submit();
    } catch (e) {
      alert('Có lỗi khi nộp khảo sát: '+e.message);
    }
  });
})();


