<?php
session_start();
include("../admin/config/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra nếu là yêu cầu đăng ký
    if (isset($_POST['Register'])) {
        // Lấy dữ liệu form
        $username = $_POST['username_customer'];
        $email = $_POST['email_customer'];
        $password = $_POST['password_customer'];
        $confirm_password = $_POST['confirm_password_customer'];

        // Kiểm tra nếu mật khẩu khớp
        if ($password !== $confirm_password) {
            echo "Mật khẩu không khớp.";
            exit();
        }

        // Kiểm tra nếu email đã tồn tại
        $stmt = $conn->prepare("SELECT * FROM tbl_account_customers WHERE email_customer = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "Email đã tồn tại. Vui lòng sử dụng email khác.";
            header("Location: ../index.php?quanly=Signup");
            $stmt->close();
            $conn->close();
            exit();
        }

        // Chèn dữ liệu vào cơ sở dữ liệu
        $query = "INSERT INTO tbl_account_customers (username_customer, password_customer, email_customer, account_status) VALUES (?, ?, ?, 1)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $password, $email);

        if ($stmt->execute()) {
            echo "Đăng ký thành công!";
            header("Location: ../index.php?quanly=Login");
        } else {
            echo "Lỗi khi đăng ký: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }

    // Xử lý đăng nhập
    if (isset($_POST['Login'])) {
        $email = $_POST['email_customer'];
        $password = $_POST['password_customer'];

        // Kiểm tra xem email đã tồn tại chưa
        $stmt = $conn->prepare("SELECT * FROM tbl_account_customers WHERE email_customer = ? AND account_status = 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Kiểm tra mật khẩu
            if ($password == $row['password_customer']) {
                // Đăng nhập thành công, đặt giá trị vào session
                $_SESSION[' '] = $row['id_account_customer'];
                $_SESSION['email_customer'] = $email;
                $_SESSION['username_customer'] = $row['username_customer'];
                header("Location: ../index.php");
            } else {
                echo '<script>alert("Mật khẩu không đúng. Vui lòng thử lại.")</script>';
                header("Location: ../index.php?quanly=Login");
            }
        } else {
            echo '<script>alert("Email không tồn tại. Vui lòng thử lại.")</script>';
            header("Location: ../index.php?quanly=Login");
        }

        $stmt->close();
        $conn->close();
    }
} else {
    echo "Không có dữ liệu được gửi đến server!";
}
if (isset($_GET['action']) && $_GET['action'] == 'logout') {

    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit();
}