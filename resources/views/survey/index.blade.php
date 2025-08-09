@extends('layouts.app')

@section('content')
    <style>
        :root {
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
    </style>

    <div class="row">
        <main class="card" role="main">
            <h1>Biểu mẫu: Sở thích & Kỹ năng</h1>
            <p class="lead">Chọn lựa các trường dưới đây. Tất cả các ô đều dùng dạng <strong>select</strong>.</p>

            <form action="{{ route('survey.post') }}" method="POST" id="profileForm">
                @csrf
                <div class="field full">
                    <label for="interests">Sở thích</label>
                    <input type="text" class="like" name="like" value="">
                    <div class="hint">Chọn 1 giá trị mô tả sở thích chính của bạn.</div>
                </div>

                <div class="field">
                    <label for="skills">Kỹ năng</label>
                    <select id="skills" name="skills">
                        <option value="" disabled selected>Chọn kỹ năng</option>
                        <option value="Lập trình">Lập trình</option>
                        <option value="Giao tiếp">Giao tiếp</option>
                        <option value="Thiết kế">Thiết kế</option>
                        <option value="Quản lý dự án">Quản lý dự án</option>
                        <option value="Phân tích dữ liệu">Phân tích dữ liệu</option>
                    </select>
                </div>

                <div class="field">
                    <label for="subject">Môn học yêu thích</label>
                    <select id="subject" name="subject">
                        <option value="" disabled selected>Chọn môn học</option>
                        <option value="Toán">Toán</option>
                        <option value="Vật lý">Vật lý</option>
                        <option value="Hóa học">Hóa học</option>
                        <option value="Ngữ văn">Ngữ văn</option>
                        <option value="Tin học">Tin học</option>
                        <option value="Tiếng Anh">Tiếng Anh</option>
                    </select>
                </div>

                <div class="field">
                    <label for="career">Định hướng nghề nghiệp</label>
                    <select id="career" name="career">
                        <option value="" disabled selected>Chọn định hướng</option>
                        <option value="Kỹ sư phần mềm">Kỹ sư phần mềm</option>
                        <option value="Data Scientist">Data Scientist</option>
                        <option value="Thiết kế UX/UI">Thiết kế UX/UI</option>
                        <option value="Giảng dạy">Giảng dạy</option>
                        <option value="Kinh doanh / Marketing">Kinh doanh / Marketing</option>
                        <option value="Khởi nghiệp">Khởi nghiệp</option>
                    </select>
                </div>

                <div class="field">
                    <label for="techLove">Mức độ yêu thích công nghệ</label>
                    <select id="techLove" name="techLove">
                        <option value="" disabled selected>Chọn mức độ</option>
                        <option value="Rất yêu thích">Rất yêu thích</option>
                        <option value="Thích">Thích</option>
                        <option value="Bình thường">Bình thường</option>
                        <option value="Ít quan tâm">Ít quan tâm</option>
                        <option value="Không thích">Không thích</option>
                    </select>
                </div>

                <div class="field">
                    <label for="creativity">Sáng tạo</label>
                    <select id="creativity" name="creativity">
                        <option value="" disabled selected>Chọn mức độ</option>
                        <option value="Rất sáng tạo">Rất sáng tạo</option>
                        <option value="Sáng tạo">Sáng tạo</option>
                        <option value="Trung bình">Trung bình</option>
                        <option value="Ít sáng tạo">Ít sáng tạo</option>
                    </select>
                </div>

                <div class="actions">
                    <button type="submit" class="btn-primary">Gửi</button>
                </div>
            </form>
        </main>
        <script></script>
    </div>
@endsection
