<?php
// Kết nối cơ sở dữ liệu
require_once("../admin/config/config.php");
session_start();

// Kiểm tra xem form đã được submit chưa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Lấy dữ liệu từ form
    $id_order = $_POST['submit']; // Lấy ID đơn hàng từ giá trị nút submit
    $feedbacks = $_POST['feedback']; // Lấy mảng đánh giá
    $id_account_customer = $_SESSION['id_account_customer'];
    $username_customer = $_SESSION['username_customer'];
    // Chuẩn bị câu lệnh SQL để chèn đơn hàng vào cơ sở dữ liệu
    $feedback_status = 0; // Mặc định feedback_status là 0 (chưa giao hàng)
    // Xử lý dữ liệu (ví dụ: làm sạch dữ liệu để tránh SQL injection)
    $id_order = mysqli_real_escape_string($conn, $id_order);

    // Lặp qua mảng đánh giá và lưu từng đánh giá vào cơ sở dữ liệu
    foreach ($feedbacks as $id_product => $feedback) {
        $feedback = mysqli_real_escape_string($conn, $feedback);
        $id_product = mysqli_real_escape_string($conn, $id_product);

        // Tạo truy vấn để lưu đánh giá
        $sql = "INSERT INTO tbl_feedback_order (id_account_customer, username_customer, id_order, id_product, feedback,feedback_status) 
                VALUES ('$id_account_customer', '$username_customer', '$id_order', '$id_product', '$feedback','$feedback_status')";

        // Thực thi truy vấn
        if (mysqli_query($conn, $sql)) {
            echo "Đánh giá cho sản phẩm $id_product đã được gửi thành công.<br>";
        } else {
            echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Chuyển hướng về trang chủ sau khi gửi đánh giá
    header("Location: ../index.php?quanly=Order Track");
    exit;

    // Đóng kết nối
    mysqli_close($conn);
}
