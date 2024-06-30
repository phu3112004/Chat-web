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
    <title>DASHBOARD</title>
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
                <li class="menu-item">
                    <a href="#"><i class="fa-solid fa-gauge"></i></a>
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
        <div class="dashboard-container">
            <h2>DASHBOARD</h2>
            <div class="dashboard-content">
                <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "phu3113";
                    $database = "CHATROOM";
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                
                    $conn = mysqli_connect($servername, $username, $password, $database);

                    $number_of_users_query = "SELECT COUNT(TAIKHOAN) AS 'SLND' FROM NGUOIDUNG";
                    $number_of_users_result = mysqli_query($conn, $number_of_users_query);
                    if ($number_of_users_result) {
                        if (mysqli_num_rows($number_of_users_result) > 0) {
                            $number_of_users_row = mysqli_fetch_assoc($number_of_users_result);
                            echo "<div class='dashboard-content-item'>";
                                echo "<span><i class='fa-solid fa-users'></i></span>";
                                echo "<div class='dashboard-content-item-info'>";
                                    echo "<p>Number of users</p>";
                                    echo "<p>" . $number_of_users_row['SLND'] . "</p>";
                                echo "</div>";
                            echo "</div>";
                        } else { 
                            echo "<div class='dashboard-content-item'><p>No members.</p></div>";
                        }
                    } else {
                        // Hiển thị thông báo nếu có lỗi khi thực hiện truy vấn
                        echo "Error: " . mysqli_error($conn);
                    }

                    $number_of_rooms_query = "SELECT COUNT(MAPC) AS 'SLPC' FROM PHONGCHAT";
                    $number_of_rooms_result = mysqli_query($conn, $number_of_rooms_query);
                    if ($number_of_rooms_result) {
                        if (mysqli_num_rows($number_of_rooms_result) > 0) {
                            $number_of_rooms_row = mysqli_fetch_assoc($number_of_rooms_result);
                            echo "<div class='dashboard-content-item'>";
                                echo "<span><i class='fa-solid fa-door-open'></i></span>";
                                echo "<div class='dashboard-content-item-info'>";
                                    echo "<p>Number of chat rooms</p>";
                                    echo "<p>" . $number_of_rooms_row['SLPC'] . "</p>";
                                echo "</div>";
                            echo "</div>";
                        } else { 
                            echo "<div class='dashboard-content-item'><p>No chatrooms.</p></div>";
                        }
                    } else {
                        // Hiển thị thông báo nếu có lỗi khi thực hiện truy vấn
                        echo "Error: " . mysqli_error($conn);
                    }

                    $number_of_messages_query = "SELECT COUNT(MATN) AS 'SLTN' FROM TINNHAN";
                    $number_of_messages_result = mysqli_query($conn, $number_of_messages_query);
                    if ($number_of_messages_result) {
                        if (mysqli_num_rows($number_of_messages_result) > 0) {
                            $number_of_messages_row = mysqli_fetch_assoc($number_of_messages_result);
                            echo "<div class='dashboard-content-item'>";
                                echo "<span><i class='fa-solid fa-message'></i></span>";
                                echo "<div class='dashboard-content-item-info'>";
                                    echo "<p>Number of messages</p>";
                                    echo "<p>" . $number_of_messages_row['SLTN'] . "</p>";
                                echo "</div>";
                            echo "</div>";
                        } else { 
                            echo "<div class='dashboard-content-item'><p>No messages.</p></div>";
                        }
                    } else {
                        // Hiển thị thông báo nếu có lỗi khi thực hiện truy vấn
                        echo "Error: " . mysqli_error($conn);
                    }

                    $number_of_online_query = "SELECT COUNT(TTTRUCTUYEN) AS 'SLTT' FROM NGUOIDUNG WHERE TTTRUCTUYEN = 1";
                    $number_of_online_result = mysqli_query($conn, $number_of_online_query);
                    if ($number_of_online_result) {
                        if (mysqli_num_rows($number_of_online_result) > 0) {
                            $number_of_online_row = mysqli_fetch_assoc($number_of_online_result);
                            echo "<div class='dashboard-content-item'>";
                                echo "<span><i class='fa-solid fa-earth-americas'></i></span>";
                                echo "<div class='dashboard-content-item-info'>";
                                    echo "<p>Now online users</p>";
                                    echo "<p>" . $number_of_online_row['SLTT'] . "</p>";
                                echo "</div>";
                            echo "</div>";
                        } else { 
                            echo "<div class='dashboard-content-item'><p>No online users.</p></div>";
                        }
                    } else {
                        // Hiển thị thông báo nếu có lỗi khi thực hiện truy vấn
                        echo "Error: " . mysqli_error($conn);
                    }
                ?>
            </div>
            <div class="dashboard-details">
                <label for="checkbox-user-detail" class="dashboard-details-button">User's details</label>
                <input type="checkbox" id="checkbox-user-detail" style="display: none;">
                <label for="checkbox-user-detail" class="dashboard-user-detail-modal">
                    <div class="dashboard-user-detail-area" onclick="stopDefault(event)">
                        <h1>List of Users:</h1>
                        <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "phu3113";
                            $database = "CHATROOM";
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }
                        
                            $conn = mysqli_connect($servername, $username, $password, $database);

                            $name_of_users_query = "SELECT * FROM NGUOIDUNG";
                            $name_of_users_result = mysqli_query($conn, $name_of_users_query);
                            if ($name_of_users_result) {
                                if (mysqli_num_rows($name_of_users_result) > 0) {
                                    while($name_of_users_row = mysqli_fetch_assoc($name_of_users_result)){
                                        echo "<div class='dashboard-user-detail-content'>";
                                            echo "<p>Name: " . $name_of_users_row['TENND'] . "</p>";
                                            echo "<p>Email: " . $name_of_users_row['EMAIL'] . "</p>";
                                            echo "<p>Number phone: " . $name_of_users_row['SDT'] . "</p>";
                                        echo "</div>";
                                    }
                                } 
                                else { 
                                    echo "<p>No users.</p>";
                                }
                            } 
                            else {
                                // Hiển thị thông báo nếu có lỗi khi thực hiện truy vấn
                                echo "Error: " . mysqli_error($conn);
                            }
                        ?>
                    </div>
                </label>
                <label for="checkbox-chatroom-detail" class="dashboard-details-button">Chat room's details</label>
                <input type="checkbox" id="checkbox-chatroom-detail" style="display: none;">
                <label for="checkbox-chatroom-detail" class="dashboard-chatroom-detail-modal">
                    <div class="dashboard-user-detail-area" onclick="stopDefault(event)">
                        <h1>List of Chat rooms:</h1>
                        <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "phu3113";
                            $database = "CHATROOM";
                            if (!$conn) {
                                die("Connection failed: " . mysqli_connect_error());
                            }
                        
                            $conn = mysqli_connect($servername, $username, $password, $database);

                            $name_of_chatrooms_query = "SELECT * FROM PHONGCHAT";
                            $name_of_chatrooms_result = mysqli_query($conn, $name_of_chatrooms_query);
                            if ($name_of_chatrooms_result) {
                                if (mysqli_num_rows($name_of_chatrooms_result) > 0) {
                                    while($name_of_chatrooms_row = mysqli_fetch_assoc($name_of_chatrooms_result)){
                                        echo "<div class='dashboard-user-detail-content'>";
                                            echo "<p>Name: " . $name_of_chatrooms_row['TENPC'] . "</p>";
                                            $date = $name_of_chatrooms_row['NGAYTAO'];
                                            $timestamp = strtotime($date);
                                            $formatted_date = date('d-m-y', $timestamp);
                                            echo "<p>Create at: " . $formatted_date . "</p>"; 
                                        echo "</div>";
                                    }
                                } 
                                else { 
                                    echo "<p>No rooms.</p>";
                                }
                            } 
                            else {
                                // Hiển thị thông báo nếu có lỗi khi thực hiện truy vấn
                                echo "Error: " . mysqli_error($conn);
                            }
                        ?>
                    </div>
                </label>
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
        function stopDefault(event){
            event.preventDefault();
        }
    </script>
</body>
</html>
