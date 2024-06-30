<?php
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

// Xử lý yêu cầu tạo nhóm chat khi nhấn nút "Create"
if (isset($_POST['create_group'])) {
    $group_name = $_POST['group_name'];

    // Thực hiện truy vấn SQL để thêm nhóm chat vào cơ sở dữ liệu
    $sql = "INSERT INTO PHONGCHAT (TENPC, NGAYTAO) VALUES ('$group_name', NOW())";

    if (mysqli_query($conn, $sql)) {
         // Lấy ID của nhóm chat vừa được tạo
         $group_id = mysqli_insert_id($conn);
         // Lấy thông tin người dùng từ session
         session_start();
         $user_id = $_SESSION['username'];
         // Thêm dữ liệu vào bảng ND_PC
         $sql_add_user_to_group = "INSERT INTO ND_PC (TAIKHOAN, MAPC, QUYEN, NGAYTG) VALUES ('$user_id', '$group_id', 1, NOW())";
         if (mysqli_query($conn, $sql_add_user_to_group)) {
             // Thêm người dùng vào nhóm chat thành công
             echo "User added to group successfully!";
         } else {
             // Lỗi khi thêm người dùng vào nhóm chat
             echo "Error adding user to group: " . mysqli_error($conn);
         }
        // Cập nhật danh sách nhóm chat
        header("Location: index.php"); // Chuyển hướng về trang index.php sau khi thêm nhóm chat
        exit();
    } else {
        // Lỗi khi thêm nhóm chat
        echo "Error creating group: " . mysqli_error($conn);
    }
}

// Đóng kết nối
mysqli_close($conn);
?>
