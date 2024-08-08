<?php
require_once("../admin/config/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verification_code']) && isset($_POST['email'])) {

    $email = $_POST['email'];
    // Kết hợp các mã xác thực thành một chuỗi
    $input_code = implode("", $_POST['verification_code']);

    // Kiểm tra mã xác thực trong cơ sở dữ liệu
    $sql = "SELECT verification_code FROM tbl_account_customers WHERE email_customer = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $verification_code = $row['verification_code'];

        if ($input_code == $verification_code) {
            // Mã xác thực đúng, chuyển hướng tới trang đặt lại mật khẩu
            header('Location: ../index.php?quanly=New_password&email=' . urlencode($email));
            exit;
        } else {
            $error_message = "Mã xác thực không đúng.";
        }
    } else {
        $error_message = "Không tìm thấy tài khoản với email này.";
    }

    $conn->close();
}
