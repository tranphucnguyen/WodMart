<?php
session_start();
include("../admin/config/config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $comment = $_POST['comment'];

    // Kiểm tra và chuẩn bị dữ liệu
    $phone = preg_replace('/\D/', '', $phone); // Loại bỏ các ký tự không phải số từ số điện thoại

    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (isset($_SESSION['email_customer'])) {
        // Người dùng đã đăng nhập
        $email_customer = $_SESSION['email_customer'];
        $username_customer = $_SESSION['username_customer'];

        // Lấy id_account_customer từ email_customer
        $stmt = $conn->prepare("SELECT id_account_customer FROM tbl_account_customers WHERE email_customer = ?");
        $stmt->bind_param("s", $email_customer);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_account_customer = $row['id_account_customer'];
        } else {
            echo '<script>alert("Không tìm thấy tài khoản.");</script>';
            header("Location: ../index.php?quanly=Contact");
            exit;
        }

        // Thực hiện lưu feedback vào bảng tbl_feedback
        $stmt = $conn->prepare("INSERT INTO tbl_feedback (id_account_customer, name_customer, email_customer, phone_customer, comment) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $id_account_customer, $name, $email, $phone, $comment);
    } else {
        // Người dùng chưa đăng nhập, không có id_account_customer
        $stmt = $conn->prepare("INSERT INTO tbl_feedback (name_customer, email_customer, phone_customer, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $comment);
    }

    if ($stmt->execute()) {
        echo '<script>alert("Gửi phản hồi thành công.");</script>';
        header("Location: ../index.php?quanly=Contact");
    } else {
        echo '<script>alert("Đã xảy ra lỗi. Vui lòng thử lại sau.");</script>';
        header("Location: ../index.php?quanly=Contact");
    }
}
