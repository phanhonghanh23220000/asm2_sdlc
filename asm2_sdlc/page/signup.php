<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #6b5b95;
        /* Màu tím đậm cho nền */
        margin: 0;
        padding: 0;
        background-image: url('img/CSS-Particles.gif');
        /* Đường dẫn tới hình nền */
        background-size: cover;
        /* Hiển thị hình ảnh sao cho nó che phủ toàn bộ kích thước của body */
        background-position: center;
        /* Căn giữa hình ảnh */
        background-repeat: no-repeat;
    }

    .container {
        max-width: 400px;
        margin: 50px auto;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.7);
        /* Màu nền trong suốt */
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .container h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #d291bc;
        /* Màu hồng tím cho tiêu đề */
    }

    .container input[type="text"],
    .container input[type="password"],
    .container input[type="email"],
    .container input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #9370db;
        /* Màu tím cho viền */
        border-radius: 5px;
        box-sizing: border-box;
    }

    .container input[type="submit"] {
        background-color: #9370db;
        /* Màu tím cho nút submit */
        color: white;
        border: none;
        cursor: pointer;
    }

    .container input[type="submit"]:hover {
        background-color: #7a67a2;
        /* Màu tím đậm hơn khi hover */
    }

    .container .signin-link {
        text-align: center;
        margin-top: 10px;
        font-size: 14px;
        /* Cỡ chữ phù hợp */
        color: #d291bc;
        /* Màu hồng tím cho liên kết */
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="submit" value="Sign Up">
        </form>
        <div class="signin-link">
            <p>Already have an account? <a href="signin.php">Sign In</a></p>
        </div>
        <?php
        session_start();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Kết nối đến cơ sở dữ liệu
            $servername = "localhost";
            $username_db = "root";
            $password_db = "";
            $dbname = "btec_sdlc_asm2";

            $conn = new mysqli($servername, $username_db, $password_db, $dbname);

            // Kiểm tra kết nối
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Kiểm tra xem dữ liệu đã được gửi từ biểu mẫu hay không
            if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
                // Lấy dữ liệu từ biểu mẫu đăng ký
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                // Kiểm tra xem mật khẩu và mật khẩu xác nhận có khớp nhau không
                if ($password !== $confirm_password) {
                    echo "Passwords do not match.";
                    exit;
                }

                // Kiểm tra xem tên người dùng đã tồn tại trong cơ sở dữ liệu chưa
                $check_username_sql = "SELECT id FROM accounts WHERE username=?";
                $check_username_stmt = $conn->prepare($check_username_sql);
                $check_username_stmt->bind_param("s", $username);
                $check_username_stmt->execute();
                $check_username_result = $check_username_stmt->get_result();

                if ($check_username_result->num_rows > 0) {
                    echo "Username already exists.";
                    exit;
                }

           

                // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Thêm người dùng mới vào cơ sở dữ liệu
                $insert_user_sql = "INSERT INTO accounts (username, email, password) VALUES (?, ?, ?)";
                $insert_user_stmt = $conn->prepare($insert_user_sql);
                $insert_user_stmt->bind_param("sss", $username, $email, $hashed_password);
                if ($insert_user_stmt->execute()) {
                    echo "User registered successfully.";
                } else {
                    echo "Error registering user.";
                }

                $insert_user_stmt->close();
                $conn->close();
            } else {
                echo "Please fill out the form.";
            }
        }
        ?>

    </div>
</body>

</html>