<?php
require_once("../admin/config/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password']) && isset($_POST['confirm_password']) && isset($_POST['email'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];

    // Kiểm tra tính hợp lệ của mật khẩu
    if ($new_password !== $confirm_password) {
        $error_message = "Mật khẩu xác nhận không khớp.";
    } elseif (strlen($new_password) < 6) {
        $error_message = "Mật khẩu phải có ít nhất 6 ký tự.";
    } else {
        // Cập nhật mật khẩu mới vào cơ sở dữ liệu
        $sql = "UPDATE tbl_account_customers SET password_customer = '$new_password' WHERE email_customer = '$email'";
        if ($conn->query($sql) === TRUE) {
            // Chuyển hướng đến trang đăng nhập
            header('Location: ../index.php?quanly=Login');
            exit;
        } else {
            $error_message = "Đã xảy ra lỗi khi cập nhật mật khẩu.";
        }
    }

    $conn->close();
}
?>

<!-- Nếu có lỗi, hiển thị thông báo lỗi -->
<?php if (isset($error_message)) {
    echo '<div class="alert alert-danger mt-3">' . $error_message . '</div>';
} ?>