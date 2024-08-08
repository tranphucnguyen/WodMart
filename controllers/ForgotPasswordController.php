<?php
require_once("../admin/config/config.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Kiểm tra email có tồn tại trong cơ sở dữ liệu không
    $sql = "SELECT id_account_customer FROM tbl_account_customers WHERE email_customer = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Tạo mã xác thực gồm 4 số
        $verification_code = rand(1000, 9999);

        // Lưu mã xác thực vào cơ sở dữ liệu
        $sql = "UPDATE tbl_account_customers SET verification_code = '$verification_code' WHERE email_customer = '$email'";
        if ($conn->query($sql) === TRUE) {
            // Gửi mã xác thực tới email của người dùng
            $subject = "Mã xác thực đặt lại mật khẩu";
            $message = "Mã xác thực đặt lại mật khẩu của bạn là: $verification_code";

            // Gửi email cho khách hàng
            $mail = new PHPMailer(true);

            try {
                // Cấu hình server email
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tranphucnguyen0908@gmail.com'; // Tài khoản email của bạn
                $mail->Password = 'yxag aunm aqhd uazd'; // Mật khẩu email của bạn
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Cấu hình người gửi và người nhận
                $mail->setFrom('tranphucnguyen0908@gmail.com', 'Your Name'); // Địa chỉ email và tên của người gửi
                $mail->addAddress($email); // Địa chỉ email của người nhận

                // Nội dung email
                $mail->isHTML(true); // Đặt định dạng email là HTML
                $mail->Subject = $subject;
                $mail->Body    = $message;

                // Gửi email
                $mail->send();
                // Chuyển hướng tới trang xác thực
                header('Location: ../index.php?quanly=Verification&email=' . urlencode($email));
                exit;
            } catch (Exception $e) {
                echo "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
            }
        } else {
            echo "Lỗi cập nhật mã xác thực: " . $conn->error;
        }
    } else {
        echo "Không tìm thấy tài khoản với email này.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}

$conn->close();
