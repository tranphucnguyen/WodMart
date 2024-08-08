<?php
session_start();
include("../config/config.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'add') {
    // Code for adding a subcategory
    $id_category = $_POST['id_category'];
    $subcategory_name = $_POST['subcategory_name'];
    $subcategory_date = $_POST['subcategory_date'];
    $subcategory_status = $_POST['subcategory_status'];

    $query = "INSERT INTO tbl_subcategory (id_category, subcategory_name, subcategory_date, subcategory_status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issi", $id_category, $subcategory_name, $subcategory_date, $subcategory_status);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add subcategory.']);
    }

    $stmt->close();
    $conn->close();
} elseif ($action == 'list') {
    // Code for listing subcategories
    $query = "SELECT s.id_subcategory, s.subcategory_name, s.subcategory_date, s.subcategory_status, c.category_name 
              FROM tbl_subcategory s 
              JOIN tbl_category c ON s.id_category = c.id_category ORDER BY s.id_subcategory ASC ";
    $result = $conn->query($query);

    $subcategories = [];
    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }

    echo json_encode($subcategories);

    $conn->close();
} elseif ($action == 'delete') {
    // Code for deleting a subcategory
    $id = $_POST['id'];

    $query = "DELETE FROM tbl_subcategory WHERE id_subcategory = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete subcategory.']);
    }

    $stmt->close();
    $conn->close();
} elseif ($action == 'update') {
    // Cập nhật thông tin danh mục con
    $id_subcategory = $_POST['id_subcategory'];
    $id_category = $_POST['id_category'];
    $subcategory_name = $_POST['subcategory_name'];
    $subcategory_date = $_POST['subcategory_date'];
    $subcategory_status = $_POST['subcategory_status'];

    if (empty($subcategory_name) || empty($subcategory_date) || $subcategory_status === "") {
        echo json_encode(['success' => false, 'message' => 'Please fill all fields!']);
        exit();
    }

    $query = "UPDATE tbl_subcategory SET id_category=?, subcategory_name=?, subcategory_date=?, subcategory_status=? WHERE id_subcategory=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issii", $id_category, $subcategory_name, $subcategory_date, $subcategory_status, $id_subcategory);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Subcategory updated successfully!', 'id_subcategory' => $id_subcategory]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating subcategory: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
    exit();
}
