<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assest/register.css">
</head>
<body>
    <div class="login-container">
        <div class="login-area">
            <h1>Login</h1>
            <?php
            // Bắt đầu một phiên mới hoặc tiếp tục phiên đã tồn tại
            session_start();
            // Kiểm tra nếu có dữ liệu được gửi từ biểu mẫu
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Xử lý đăng nhập ở đây (ví dụ: kiểm tra tên người dùng và mật khẩu)
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

                // Lấy dữ liệu từ biểu mẫu đăng nhập
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Truy vấn SQL để kiểm tra tên người dùng và mật khẩu
                $sql = "SELECT * FROM NGUOIDUNG WHERE TAIKHOAN='$username'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    if (password_verify($password, $row['MATKHAU'])) {
                        echo "Đăng nhập thành công!";
                        // Chuyển hướng đến trang index.php
                        $_SESSION['username'] = $username;
                        header("Location: index.php");
                        exit(); // Dừng script
                    } else {
                        echo "Sai tên người dùng hoặc mật khẩu.";
                    }
                } else {
                    echo "Người dùng không tồn tại.";
                }

                // Đóng kết nối
                mysqli_close($conn);
            }
            ?>
            <form class="login-form" method="POST" action="">
                <div class="login-input">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="username" placeholder="Username">
                </div>
                <div class="login-input">
                    <i class="fa-solid fa-lock"></i>
                    <input style="width: 80%;" type="password" name="password" placeholder="Password">
                    <i class="fa-solid fa-eye" onclick="showPassword()"></i>
                </div>
                <button type="submit" >Login</button>
            </form>
            <div class="login-tele">
                <a href="signup.php">Don't have an account? Sign up</a>
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
