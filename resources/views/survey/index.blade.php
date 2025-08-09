@extends('layouts.app')

@section('content')
    <style>
        :root {
            --codex-primary: #0b3b5a;
            --codex-bg: #0a2740;
            --codex-accent: #1f6fb2;
            --bg: #f4f7fb;
            --card: #ffffff;
            --accent: #4f46e5;
            --muted: #6b7280;
            --radius: 12px;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        * {
            box-sizing: border-box
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #eef2ff 0%, var(--bg) 100%);
            padding: 32px
        }

        .card {
            width: 100%;
            max-width: 820px;
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
            padding: 28px;
        }

        h1 {
            margin: 0 0 6px;
            font-size: 20px
        }

        p.lead {
            margin: 0 0 18px;
            color: var(--muted);
            font-size: 14px
        }

        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px
        }

        .field {
            display: flex;
            flex-direction: column
        }

        label {
            font-size: 13px;
            margin-bottom: 8px;
            color: #111827
        }

        select {
            height: 44px;
            padding: 8px 12px;
            border-radius: 10px;
            border: 1px solid #e6e9ef;
            background: #fff;
            font-size: 14px;
            appearance: none;
        }

        .full {
            grid-column: 1/-1
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            grid-column: 1/-1;
            margin-top: 6px
        }

        button {
            height: 44px;
            padding: 0 16px;
            border-radius: 10px;
            border: 0;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff
        }

        .btn-ghost {
            background: transparent;
            border: 1px solid #e6e9ef;
            color: var(--muted)
        }

        /* responsive */
        @media (max-width:720px) {
            form {
                grid-template-columns: 1fr
            }

            .actions {
                justify-content: stretch
            }

            button {
                width: 100%
            }
        }

        /* small helper text */
        .hint {
            font-size: 12px;
            color: var(--muted);
            margin-top: 6px
        }

        .sv-hero {
            background: linear-gradient(135deg, var(--codex-bg), var(--codex-primary));
            color: #fff;
            border-radius: 16px
        }

        .sv-card {
            border: 0;
            border-radius: 14px;
            background: #0e3553;
            color: #e6eef5
        }

        .sv-card .form-control,
        .sv-card .form-select {
            background: #0b2f4b;
            border-color: #11476e;
            color: #fff
        }

        .nav-pills .nav-link {
            color: #fff;
            background: #0e3553;
            margin-right: 8px
        }

        .nav-pills .nav-link.active {
            background: var(--codex-accent)
        }

        .btn-accent {
            background: var(--codex-accent);
            color: #fff;
            border: none
        }
    </style>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="sv-hero p-4 p-md-5 mb-4">
                <h1 class="h4 mb-2">Khảo sát tư vấn chọn ngành</h1>
                <div class="opacity-75">Nhập điểm, sở thích, kỹ năng và định hướng. AI sẽ phân tích và gợi ý ngành phù hợp.
                </div>
            </div>

            <main class="card" role="main">
                <h1>Biểu mẫu: Sở thích & Kỹ năng</h1>
                <p class="lead">Chọn lựa các trường dưới đây. Tất cả các ô đều dùng dạng <strong>select</strong>.</p>

                <form id="profileForm" onsubmit="handleSubmit(event)">

                    <div class="field full">
                        <label for="interests">Sở thích</label>
                        <select id="interests" name="interests">
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
                        <select id="skills" name="skills">
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
                        <select id="subject" name="subject">
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
                        <select id="career" name="career">
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
                        <select id="techLove" name="techLove">
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
                        <select id="creativity" name="creativity">
                            <option value="" disabled selected>Chọn mức độ</option>
                            <option>Rất sáng tạo</option>
                            <option>Sáng tạo</option>
                            <option>Trung bình</option>
                            <option>Ít sáng tạo</option>
                        </select>
                    </div>

                    <div class="actions">
                        <button type="button" class="btn-ghost"
                            onclick="document.getElementById('profileForm').reset()">Đặt lại</button>
                        <button type="submit" class="btn-primary">Gửi</button>
                    </div>
                </form>
            </main>


        </div>
    </div>
@endsection
