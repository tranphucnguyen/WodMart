<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_product']) && isset($_POST['id_feedback_order']) && isset($_POST['feedback_status'])) {
    $id_product = $_POST['id_product'];
    $id_feedback_order = $_POST['id_feedback_order']; // Lấy id_feedback_order từ yêu cầu POST
    // $feedback_status = 1; // Đặt giá trị feedback_status thành 1
    $feedback_status = $_POST['feedback_status'];
    $update_sql = "UPDATE tbl_feedback_order SET feedback_status = ? WHERE id_product = ? AND id_feedback_order = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("iii", $feedback_status, $id_product, $id_feedback_order); // Sử dụng "iii" để bind ba tham số kiểu integer

    $response = array();

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
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