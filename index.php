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
    <title>HOME</title>
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
        <div class="group-container">
            <div class="group-main">
                <form action="" class="group-search">
                    <input type="text" name="search-group" placeholder="Search name of group">
                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
                <ul id="all-groups">
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

                        // Truy vấn SQL để lấy danh sách nhóm chat từ cơ sở dữ liệu
                        $sql = "SELECT * FROM PHONGCHAT";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            // Duyệt qua từng dòng kết quả và hiển thị tên nhóm chat
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<li><a href='chat.php?group_id=" . $row['MAPC'] . "'>" . $row['TENPC'] . " <i class='fa-solid fa-caret-right'></i></a></li>";
                            }
                        } else {
                            // Không có nhóm chat nào trong cơ sở dữ liệu
                            echo "No groups found.";
                        }

                        // Đóng kết nối
                        mysqli_close($conn);
                    ?>
                </ul>
            </div>
            <div class="group-create">
                <h1>Create new chat room</h1>
                <form action="create_group.php" method="POST" onsubmit="return validateGroupName();">
                    <p>Chat's name:</p>
                    <input type="text" name="group_name" id="group-name">
                    <button type="submit" name="create_group">Create</button>
                </form>
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
        function validateGroupName() {
            var groupName = document.getElementById("group-name").value;
            if (groupName.trim() === "") {
                alert("Vui lòng nhập tên phòng chat!");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
