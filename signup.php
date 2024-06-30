<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="assest/register.css">
</head>
<body>
    <div class="login-container">
        <div class="login-area">
            <h1>Sign Up</h1>
            <?php
            // Kiểm tra nếu có dữ liệu được gửi từ biểu mẫu
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Xử lý đăng ký ở đây (ví dụ: kiểm tra dữ liệu và lưu vào cơ sở dữ liệu)
                // Kết nối đến cơ sở dữ liệu MySQL
                $servername = "localhost";
                $username = "root";
                $dbpassword = "phu3113";
                $database = "CHATROOM";

                $conn = mysqli_connect($servername, $username, $dbpassword, $database);

                // Kiểm tra kết nối
                if (!$conn) {
                    die("Kết nối thất bại: " . mysqli_connect_error());
                }

                // Lấy dữ liệu từ biểu mẫu đăng ký
                $email = $_POST['email'];
                $phone = $_POST['tel'];
                $name = $_POST['name'];
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Mã hóa mật khẩu
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Tạo truy vấn để chèn dữ liệu vào bảng NGUOIDUNG
                $sql = "INSERT INTO NGUOIDUNG (TENND, EMAIL, SDT, TAIKHOAN, MATKHAU, TTTRUCTUYEN)
                        VALUES ('$name', '$email', '$phone', '$username', '$hashed_password', TRUE)";

                if (mysqli_query($conn, $sql)) {
                    echo "Đăng ký thành công!";
                } else {
                    echo "Lỗi đăng ký" ;
                }

                // Đóng kết nối
                mysqli_close($conn);
            }
            ?>
            <form class="login-form" method="POST" action="">
                <div class="login-input">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email">
                </div>
                <div class="login-input">
                    <i class="fa-solid fa-phone"></i>
                    <input type="tel" name="tel" placeholder="Phone Number">
                </div>
                <div class="login-input">
                    <i class="fa-solid fa-signature"></i>
                    <input type="text" name="name" placeholder="Your Name">
                </div>
                <div class="login-input">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Username">
                </div>
                <div class="login-input">
                    <i class="fa-solid fa-lock"></i>
                    <input style="width: 80%;" type="password" name="password" placeholder="Password">
                    <i class="fa-solid fa-eye" onclick="showPassword()"></i>
                </div>
                <button type="submit" >Sign up</button>
            </form>
            <div class="login-tele">
                <a href="login.php">Already a member? Log in</a>
            </div>
        </div>
    </div>
    <script>
        function showPassword() {
            var eyeIcon = event.target;
            var inputPassword = eyeIcon.closest('.login-input').querySelector('input');
            if (inputPassword) {
                if(inputPassword.type === 'password')
                {
                    inputPassword.type = 'text'
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                }
                else
                {
                    inputPassword.type = 'password'
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            }
        }
    </script>
</body>
</html>
