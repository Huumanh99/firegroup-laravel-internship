<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Trang Login</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin-style.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>
</head>

<body>
    <section>
        <!--Bắt Đầu Phần Hình Ảnh-->
        <div class="img-bg">
            <img src="https://niemvuilaptrinh.ams3.cdn.digitaloceanspaces.com/tao_trang_dang_nhap/hinh_anh_minh_hoa.jpg"
                alt="Hình Ảnh Minh Họa">
        </div>
        <!--Kết Thúc Phần Hình Ảnh-->
        <!--Bắt Đầu Phần Nội Dung-->
        <div class="noi-dung">
            <div class="form">
                <h2>Trang Đăng Nhập</h2>
                <form action="/authenticate" method="post" id="loginForm">
                    {{ csrf_field() }}
                    <div class="input-form">
                        <span>Email Người Dùng</span>
                        <input type="text" name="email" id="email">
                    </div>
                    <div class="input-form">
                        <span>Mật Khẩu</span>
                        <input type="password" name="password" id="password">
                    </div>
                    <div class="nho-dang-nhap">
                        <label><input type="checkbox" name=""> Nhớ Đăng Nhập</label>
                    </div>
                    <div class="input-form">
                        <input type="submit" value="Đăng Nhập">
                    </div>
                    <div class="input-form">
                        <p>Bạn Chưa Có Tài Khoản? <a href="#">Đăng Ký</a></p>
                    </div>
                </form>
                <h3>Đăng Nhập Bằng Mạng Xã Hội</h3>
                <ul class="icon-dang-nhap">
                    <li><i class="fa fa-facebook" aria-hidden="true"></i></li>
                    <li><i class="fa fa-google" aria-hidden="true"></i></li>
                    <li><i class="fa fa-twitter" aria-hidden="true"></i></li>
                </ul>
            </div>
        </div>
        <!--Kết Thúc Phần Nội Dung-->
    </section>
</body>

</html>