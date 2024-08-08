<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderId'])) {
    include('../config/config.php');

    $orderId = $_POST['orderId'];
    // Start a transaction
    $conn->begin_transaction();

    try {
        // Update tbl_order
        $sqlOrder = "UPDATE tbl_order SET order_status = 1 WHERE id_order = '$orderId'";
        if ($conn->query($sqlOrder) === TRUE) {
            $response = array('success' => true, 'message' => 'Order status updated successfully.');
            header('location: ../index.php?action=quanlydonhang&query=lietke');
        } else {
            throw new Exception('Failed to update order status in tbl_order');
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
