<?php
session_start();
// Kết nối cơ sở dữ liệu
require_once("../admin/config/config.php");

if (isset($_GET['id_order'])) {
    $order_id = $_GET['id_order'];

    // Truy vấn chi tiết đơn hàng từ cơ sở dữ liệu
    $query = "SELECT * FROM tbl_order_detail WHERE id_order = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Hiển thị chi tiết đơn hàng
    while ($row = $result->fetch_assoc()) {
        echo "<p>Sản phẩm: " . htmlspecialchars($row['product_name']) . "</p>";
        echo "<p>Số lượng: " . htmlspecialchars($row['quantity']) . "</p>";
        echo "<p>Giá: " . htmlspecialchars($row['total_price']) . "</p>";
        // Thêm các trường khác tùy theo cấu trúc bảng của bạn
    }

    $stmt->close();
} else {
    echo "Không tìm thấy chi tiết đơn hàng.";
}
$conn->close();
