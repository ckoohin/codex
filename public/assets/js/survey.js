// (() => {
//   const api = {
//     post: async (url, data) => {
//       const res = await fetch(url, {
//         method: 'POST',
//         headers: {
//           'Content-Type': 'application/json',
//           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name=_token]')?.value
//         },
//         body: JSON.stringify(data),
//       });
//       if (!res.ok) throw new Error(await res.text());
//       return res.json();
//     }
//   };

//   function el(id) { return document.getElementById(id); }

//   const scoresForm = el('scoresForm');
//   const responsesForm = el('responsesForm');
//   if (!scoresForm || !responsesForm) return;

//   // Lấy dữ liệu từ DOM (server render) thay vì dữ liệu mẫu
//   const subjects = Array.from(document.querySelectorAll('.score-input')).map(inp => ({ id: +inp.dataset.subjectId }));

//   // Render subjects
//   const scoresList = el('scoresList');
//   subjects.forEach(s => {
//     const col = document.createElement('div');
//     col.className = 'col-6 col-md-3';
//     col.innerHTML = `<label class="form-label">${s.name}</label>
//       <input type="number" min="0" max="10" step="0.1" class="form-control" data-subject-id="${s.id}" value="${loadLS('score_' + s.id) || ''}" placeholder="0-10">`;
//     scoresList.appendChild(col);
//   });

//   // Khôi phục dữ liệu đã lưu
//   document.querySelectorAll('.score-input').forEach(inp => {
//     const v = loadLS('score_' + inp.dataset.subjectId);
//     if (v !== null) inp.value = v;
//   });
//   document.querySelectorAll('.response-input').forEach(inp => {
//     const v = loadLS('q_' + inp.dataset.questionId);
//     if (v !== null) inp.value = v;
//   });

//   function saveLS(key, val) { localStorage.setItem(key, JSON.stringify(val)); }
//   function loadLS(key) { try { return JSON.parse(localStorage.getItem(key)); } catch { return null } }

//   el('saveScores').addEventListener('click', () => {
//     document.querySelectorAll('.score-input').forEach(inp => {
//       saveLS('score_' + inp.dataset.subjectId, inp.value || '');
//     });
//   });

//   el('saveResponses').addEventListener('click', () => {
//     document.querySelectorAll('.response-input').forEach(inp => {
//       saveLS('q_' + inp.dataset.questionId, inp.value || '');
//     });
//   });

//   el('submitSurvey').addEventListener('click', async () => {
//     try {
//       const payload = {
//         scores: {},
//         responses: {}
//       };
//       document.querySelectorAll('.score-input').forEach(inp => {
//         const v = parseFloat(inp.value);
//         if (!isNaN(v)) payload.scores[inp.dataset.subjectId] = v;
//       });
//       document.querySelectorAll('.response-input').forEach(inp => {
//         payload.responses[inp.dataset.questionId] = inp.value;
//       });
//       const res = await api.post('/survey/submit', payload);
//       if (res.redirect) location.href = res.redirect;
//     } catch (e) {
//       alert('Có lỗi khi nộp khảo sát: ' + e.message);
//     }
//   });
// })();

// console.log(123);


const profileForm = document.querySelector('#profileForm');

const likeE = document.querySelector('.like');
const skillsE = document.querySelector('#skills');

const subjectE = document.querySelector('#subject');
const careerE = document.querySelector('#career');
const techLoveR = document.querySelector('#techLove');
const creativityE = document.querySelector('#creativity');

const btnSubmit = document.querySelector('.btn-primary');

btnSubmit.onclick = function (event) {
  event.preventDefault();
  let likeContent = likeE.value;
  let skillsContent = skillsE.value;
  let subjectContent = subjectE.value;
  let careerContent = careerE.value;
  let techLoveRContent = careerE.value;
  let creativityContent = likeE.value;

  profileForm.submit();
}




