<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    // Nếu chưa, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Kiểm tra xem đã nhận dữ liệu tin nhắn từ form gửi chưa
if (isset($_POST['send_message'])) {
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "phu3113";
    $database = "CHATROOM";

    $conn = mysqli_connect($servername, $username, $password, $database);

    // Kiểm tra kết nối
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Lấy thông tin người dùng từ session
    $user_id = $_SESSION['username'];

    // Lấy MAPC từ URL
    if (isset($_GET['group_id'])) {
        $group_id = $_GET['group_id'];
        
        // Lấy nội dung tin nhắn từ form
        $message_content = $_POST['message_content'];

        // Thêm tin nhắn vào cơ sở dữ liệu
        $insert_message_query = "INSERT INTO tinnhan (TAIKHOAN, MAPC, NOIDUNG, NGAYGUI, TINHTRANG) VALUES ('$user_id', '$group_id', '$message_content', NOW(), 'Da gui')";
        $insert_message_result = mysqli_query($conn, $insert_message_query);

        if (!$insert_message_result) {
            echo "Error: " . mysqli_error($conn);
        } else {
            // Chuyển hướng người dùng về trang chat sau khi gửi tin nhắn thành công
            header("Location: chat.php?group_id=$group_id");
            exit();
        }
    } else {
        echo "Group ID not provided!";
    }

    // Đóng kết nối
    mysqli_close($conn);
} else {
    // Nếu không nhận dữ liệu tin nhắn từ form gửi, hiển thị thông báo lỗi
    echo "No message data received!";
}
?>
