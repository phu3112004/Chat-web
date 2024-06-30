<?php
    session_start();

    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (!isset($_SESSION['username'])) {
        // Nếu chưa, chuyển hướng người dùng đến trang đăng nhập
        header("Location: login.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="assest/style.css">
    <link rel="stylesheet" href="assest/responsive.css">
</head>
<body>
    <div class="main">
        <div class="menu-container">
            <label class="menu-bar menu-item" for="sub-menu-checkbox">
                <i class="fa-solid fa-bars"></i>
            </label>
            <input type="checkbox" id="sub-menu-checkbox" style="display: none;">
            <label class="sub-menu-container" for="sub-menu-checkbox">
            </label>
            <div class="sub-menu-area"> 
                <a href="index.php">All rooms <i class="fa-solid fa-caret-right"></i></a>
                <div>
                    <h2>Your Rooms:</h2>
                    <ul id="your-rooms">
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
                            $user_id = $_SESSION['username'];
                            // Truy vấn SQL để lấy danh sách nhóm chat từ cơ sở dữ liệu
                            $sql = "SELECT TENPC, PHONGCHAT.MAPC FROM PHONGCHAT JOIN ND_PC ON PHONGCHAT.MAPC = ND_PC.MAPC WHERE TAIKHOAN = '$user_id'";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                // Duyệt qua từng dòng kết quả và hiển thị tên nhóm chat
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<li><a href='chat.php?group_id=" . $row['MAPC'] . "'>" . $row['TENPC'] . " <i class='fa-solid fa-caret-right'></i></a></li>";
                                }
                            } else {
                                // Không có nhóm chat nào trong cơ sở dữ liệu
                                echo "No group chats found.";
                            }

                            // Đóng kết nối
                            mysqli_close($conn);
                        ?>
                    </ul>
                </div>
            </div>
           
            <ul class="menu-item-container">
                <li class="menu-item" title="dashboard">
                    <a href="dashboard.php"><i class="fa-solid fa-gauge"></i></a>
                </li>
                <li class="menu-item">
                    <i class="fa-solid fa-bell"></i>
                </li>
                <li class="menu-item">
                    <i class="fa-solid fa-user"></i>
                    <ul class="sub-menu-item">
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="logout.php">Log out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="profile-container">
            <button class="profile-edit" onclick="changeToForm()">Edit <i class="fa-solid fa-pen-to-square"></i></button>
            <div class="profile-area">
                <?php
                    // Kết nối đến cơ sở dữ liệu
                    $servername = "localhost";
                    $username = "root";
                    $password = "phu3113";
                    $database = "CHATROOM";

                    $conn = mysqli_connect($servername, $username, $password, $database);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $user_id = $_SESSION['username'];
                    $sql = "SELECT * FROM NGUOIDUNG WHERE TAIKHOAN = '$user_id'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        echo "<h1>Basic information</h1>";
                        echo "<div class='profile-info-item'>";
                            echo "<span>Username:</span>";
                            echo "<span>" . $row['TAIKHOAN'] . "</span>";
                        echo "</div>";
                        echo "<div class='profile-info-item'>";
                            echo "<span>Name:</span>";
                            echo "<span>" . $row['TENND'] . "</span>";
                        echo "</div>";
                        echo "<div class='profile-info-item'>";
                            echo "<span>Email:</span>";
                            echo "<span>" . $row['EMAIL'] . "</span>";
                        echo "</div>";
                        echo "<div class='profile-info-item'>";
                            echo "<span>Phone number:</span>";
                            echo "<span>" . $row['SDT'] . "</span>";
                        echo "</div>";

                    } 
                    else { 
                        echo "Cannot found profile.";
                    }
                    // Đóng kết nối
                    mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/assest/main.js"></script>
    <script>
       $(document).ready(function() {
            $('.menu-item').mouseenter(function() {
                $(this).children('.sub-menu-item').stop().slideDown(300).css({
                    'height': 'fit-content',
                    'display': 'block'
                });
            }).mouseleave(function() {
                $(this).children('.sub-menu-item').stop().slideUp(300).css({
                    'height': 'fit-content',
                    'display': 'block'
                });
            });
        });

    </script>
    <script>
        function changeToForm(){
            document.querySelector('.profile-container').innerHTML = `
                <form action="edit_profile.php" method="POST" class="profile-area">
                    <?php
                        // Kết nối đến cơ sở dữ liệu
                        $servername = "localhost";
                    $username = "root";
                    $password = "phu3113";
                    $database = "CHATROOM";

                    $conn = mysqli_connect($servername, $username, $password, $database);

                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $user_id = $_SESSION['username'];
                    $sql = "SELECT * FROM NGUOIDUNG WHERE TAIKHOAN = '$user_id'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        echo "<h1>Basic information</h1>";
                        echo "<div class='profile-info-item'>";
                            echo "<span>Username:</span>";
                            echo "<p>" . $row['TAIKHOAN'] . "</p>";
                        echo "</div>";
                        echo "<div class='profile-info-item'>";
                            echo "<span>Name:</span>";
                            echo "<input type='text' name='name' value='" . $row['TENND'] . "'>";
                        echo "</div>";
                        echo "<div class='profile-info-item'>";
                            echo "<span>Email:</span>";
                            echo "<input type='email' name='email' value='" . $row['EMAIL'] . "'>";
                        echo "</div>";
                        echo "<div class='profile-info-item'>";
                            echo "<span>Phone number:</span>";
                            echo "<input type='text' name='phone' value='" . $row['SDT'] . "'>";
                        echo "</div>";
                        echo "<button type='submit'>Save</button>";

                    } 
                    else { 
                        echo "Cannot found profile.";
                    }
                    // Đóng kết nối
                    mysqli_close($conn);
                ?>
            </form>
        `
        }  
    </script>

</body>
</html>
