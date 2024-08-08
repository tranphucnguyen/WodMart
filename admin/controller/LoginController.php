<?php
session_start();
include("../config/config.php");

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    // Xử lý chức năng đăng xuất
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}




if (isset($_POST['dangnhap'])) {
    $email_admin = $_POST['email_admin'];
    $password = $_POST['password'];
    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM tbl_login_admin WHERE email_admin = ? AND password = ?");
    $stmt->bind_param("ss", $email_admin, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;
    if ($count > 0) {
        $_SESSION['dangnhap'] = $email_admin;
        header("location:../index.php");
    } else {
        echo '<script>alert("Taì khoản không đúng xin vùi lòng nhập lại")</script>';
        header("location:login.php");
    }
    $stmt->close();
    $conn->close();
}