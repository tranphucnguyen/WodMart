<?php
// admin/modules/quanlydonhang/delete_order.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
    include('../config/config.php');

    $orderId = $_POST['orderId'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete from tbl_order_detail
        $sqlDetail = "DELETE FROM tbl_order_detail WHERE id_order = '$orderId'";
        if ($conn->query($sqlDetail) === TRUE) {
            // Delete from tbl_order
            $sqlOrder = "DELETE FROM tbl_order WHERE id_order = '$orderId'";
            if ($conn->query($sqlOrder) === TRUE) {
                $response = array('success' => true);
            } else {
                throw new Exception('Failed to delete order from tbl_order');
            }
        } else {
            throw new Exception('Failed to delete order details from tbl_order_detail');
        }

        // Commit the transaction
        $conn->commit();
    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        $conn->rollback();
        $response = array('success' => false, 'message' => $e->getMessage());
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    $response = array('success' => false, 'message' => 'Invalid request.');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
