<?php
include("../config/config.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['page']) && isset($_GET['itemsPerPage'])) {
    $page = (int) $_GET['page'];
    $itemsPerPage = (int) $_GET['itemsPerPage'];

    $offset = ($page - 1) * $itemsPerPage;
    // Sửa câu truy vấn SQL để sử dụng bind_param đúng cách
    $sql = "SELECT * FROM tbl_account_customers LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $itemsPerPage); // Đổi "ss" thành "ii" vì OFFSET và LIMIT là số nguyên

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        $customerList = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $customerList[] = $row;
            }
        }

        $sqlTotal = "SELECT COUNT(*) AS total FROM tbl_account_customers";
        $resultTotal = $conn->query($sqlTotal);
        $totalItems = $resultTotal->fetch_assoc()['total'];

        echo json_encode(['customerList' => $customerList, 'totalItems' => $totalItems]);
    } else {
        echo json_encode(['customerList' => [], 'totalItems' => 0]);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == 'delete_customer') {
    if (isset($_POST['id'])) {
        $customerId = $_POST['id'];
        $sql = "DELETE FROM tbl_account_customers WHERE id_account_customer = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customerId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete customer.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request. Missing customer ID.']);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'get_customer' && isset($_GET['id'])) {
    $customerId = $_GET['id'];

    $sql = "SELECT * FROM tbl_account_customers WHERE id_account_customer = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $customerId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $customer = $result->fetch_assoc();
            echo json_encode($customer); // Trả về thông tin khách hàng dưới dạng JSON
        } else {
            echo json_encode(['error' => 'Customer not found']);
        }
    } else {
        echo json_encode(['error' => 'Error executing SQL query']);
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['action']) && $_GET['action'] == 'update_customer') {
    // Xử lý yêu cầu cập nhật thông tin khách hàng
    if (
        isset($_POST['id']) &&
        isset($_POST['username']) &&
        isset($_POST['email']) &&
        isset($_POST['password']) &&
        isset($_POST['account_status'])
    ) {
        $customerId = $_POST['id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $accountStatus = $_POST['account_status'];

        $sql = "UPDATE tbl_account_customers SET username_customer = ?, email_customer = ?, password_customer = ?, account_status = ? WHERE id_account_customer = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $username, $email, $password, $accountStatus, $customerId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update customer.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request. Missing required parameters.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method or action.']);
}
