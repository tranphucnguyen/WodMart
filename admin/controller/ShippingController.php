<?php
session_start();
include("../config/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    $_SESSION['order_id'] = $orderId;

    // Update the order status
    $updateSql = "UPDATE tbl_order SET order_status = 1 WHERE id_order = '$orderId'";
    if ($conn->query($updateSql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
