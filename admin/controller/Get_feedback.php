<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_order'])) {
    $id_order = $_GET['id_order'];
    $feedback_sql = "SELECT tbl_feedback_order.id_feedback_order, tbl_feedback_order.feedback, tbl_feedback_order.id_product,tbl_feedback_order.feedback_status, tbl_product.product_name FROM tbl_feedback_order INNER JOIN tbl_product ON tbl_feedback_order.id_product = tbl_product.id_product WHERE tbl_feedback_order.id_order = ?";
    $stmt = $conn->prepare($feedback_sql);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();
    $feedback_result = $stmt->get_result();

    $response = array();

    if ($feedback_result->num_rows > 0) {
        $feedback_items = array();
        while ($row = $feedback_result->fetch_assoc()) {
            $feedback_items[] = $row;
        }
        $response['success'] = true;
        $response['feedback'] = $feedback_items;
    } else {
        $response['success'] = false;
        $response['feedback'] = array(); // Trả về mảng rỗng nếu không có đánh giá
    }

    $stmt->close();
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    $response = array('success' => false, 'message' => 'Yêu cầu không hợp lệ.');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
