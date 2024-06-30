<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "phu3113";
    $database = "CHATROOM";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Lấy thông tin từ form
    $user_id = $_SESSION['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE NGUOIDUNG SET TENND='$name', EMAIL='$email', SDT='$phone' WHERE TAIKHOAN='$user_id'";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn); header("Location: profile.php");
        exit();
    } 
    else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Nếu không phải là phương thức POST, chuyển hướng người dùng đến trang profile.php
    header("Location: profile.php");
    exit();
}
?>
