<?php
// Kết nối cơ sở dữ liệu
session_start();
require_once("../admin/config/config.php");
// Lấy id_order từ POST data
$id_order = $_POST['id_order'];

// Xử lý xóa đơn hàng trong CSDL
$query = "DELETE FROM tbl_order WHERE id_order = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_order);

if ($stmt->execute()) {
    // Nếu xóa thành công
    echo 'success';
} else {
    // Nếu có lỗi xảy ra
    echo 'error';
}

$stmt->close();
$conn->close();
