<?php
require_once("../admin/config/config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_order'])) {
    $id_order = $_POST['id_order'];

    // Truy vấn lấy danh sách sản phẩm dựa trên id_order
    $query = "SELECT tbl_product.product_name, tbl_order_detail.quantity, tbl_order_detail.id_product
              FROM tbl_order_detail
              JOIN tbl_product ON tbl_order_detail.id_product = tbl_product.id_product 
              WHERE tbl_order_detail.id_order = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='mb-3'>";
            echo "<label for='feedback-" . $row['id_product'] . "' class='col-form-label'>Đánh giá cho sản phẩm: " . htmlspecialchars($row['product_name']) . ":</label>";
            echo "<textarea class='form-control' id='feedback-" . $row['id_product'] . "' name='feedback[" . $row['id_product'] . "]' placeholder='Nhập đánh giá của bạn'></textarea>";
            echo "</div>";
        }
    } else {
        echo "<p>Không có sản phẩm nào trong đơn hàng này.</p>";
    }

    $stmt->close();
}
$conn->close();
