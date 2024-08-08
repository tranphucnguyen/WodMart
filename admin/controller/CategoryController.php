<?php
session_start();
include("../config/config.php"); // Đảm bảo bạn đã kết nối đúng cơ sở dữ liệu

if (isset($_POST['add_category'])) {
    // Lấy dữ liệu từ form
    $category_name = $_POST['category_name'];
    $category_status = $_POST['category_status'];

    // Xác thực dữ liệu nhập vào
    if (empty($category_name) || $category_status === "") {
        echo "<script>console.log('Please fill all fields!');</script>";
    } else {
        // Thêm dữ liệu vào cơ sở dữ liệu
        $query = "INSERT INTO tbl_category (category_name, category_status) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $category_name, $category_status); // 'si' nghĩa là string và integer

        if ($stmt->execute()) {
            $message = "<script>console.log('Category added successfully!');</script>";
            header("location:../index.php?action=danhmucbaibao&query=them");
        } else {
            $message = "<script>console.log('Error adding category: " . addslashes($stmt->error) . "');</script>";
        }

        $stmt->close();
    }
    $conn->close();
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'list') {
        // Lấy danh sách danh mục từ cơ sở dữ liệu
        $query = "SELECT id_category, category_name, category_status FROM tbl_category  ORDER BY id_category ASC ";
        $result = $conn->query($query);

        $categories = array();
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }

        // Trả về dữ liệu dưới dạng JSON
        echo json_encode($categories);
        exit();
    } elseif ($action == 'delete') {
        // Xóa danh mục từ cơ sở dữ liệu
        $id = $_POST['id'];
        $query = "DELETE FROM tbl_category WHERE id_category = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => $stmt->error]);
        }

        $stmt->close();
        $conn->close();
        exit();
    } elseif ($action == 'update') {
        // Cập nhật thông tin danh mục
        $id_category = $_POST['id_category'];
        $category_name = $_POST['category_name'];
        $category_status = $_POST['category_status'];

        if (empty($category_name) || $category_status === "") {
            echo json_encode(['success' => false, 'message' => 'Please fill all fields!']);
        } else {
            $query = "UPDATE tbl_category SET category_name = ?, category_status = ? WHERE id_category = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sii", $category_name, $category_status, $id_category);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Category updated successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => $stmt->error]);
            }

            $stmt->close();
        }

        $conn->close();
        exit();
    }
}
