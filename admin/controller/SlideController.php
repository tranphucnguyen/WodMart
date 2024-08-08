<?php
session_start();
include("../config/config.php"); // Đảm bảo kết nối đúng cơ sở dữ liệu
// Kiểm tra giá trị của action trong GET hoặc POST request
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if (isset($_POST['add_slide'])) {
    echo "Form submitted";
    // Lấy dữ liệu từ form
    $slide_name = $_POST['slide_name'];
    $slide_status = $_POST['slide_status'];

    // Xử lý upload ảnh
    $slide_img = $_FILES['slide_img']['name'];
    $slide_img_tmp = $_FILES['slide_img']['tmp_name'];
    $slide_img = time() . '_' . $slide_img;

    // Đường dẫn đầy đủ đến thư mục lưu trữ ảnh
    $target_dir = '../modules/quanlyslider/images/';
    $target_file = $target_dir . $slide_img;

    // Xác thực dữ liệu nhập vào
    if (empty($slide_name) || empty($slide_status) || empty($slide_img)) {
        echo "Vui lòng điền đầy đủ thông tin!";
    } else {
        // Thêm dữ liệu vào cơ sở dữ liệu
        $query = "INSERT INTO tbl_slide (slide_name, slide_img, slide_status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            echo "Lỗi chuẩn bị câu truy vấn: " . $conn->error;
            exit();
        }
        $stmt->bind_param("ssi", $slide_name, $slide_img, $slide_status);

        // Di chuyển file đã upload vào thư mục mong muốn
        if (move_uploaded_file($slide_img_tmp, $target_file)) {
            echo "File uploaded successfully.";
            if ($stmt->execute()) {
                echo "Thêm slide thành công!";
                header("Location: ../index.php?action=quanlyslider&query=them");
                exit();
            } else {
                echo "Lỗi khi thêm slide: " . $stmt->error;
            }
        } else {
            echo "Không thể upload ảnh. Vui lòng kiểm tra quyền truy cập thư mục: " . $target_dir;
        }
        $stmt->close();
    }
    $conn->close();
} elseif ($action == 'list') {
    $query = "SELECT * FROM tbl_slide ORDER BY id_slide ASC ";
    $result = $conn->query($query);
    $slides = [];
    while ($row = $result->fetch_assoc()) {
        $slides[] = $row;
    }
    echo json_encode($slides);
    exit();
} elseif ($action == 'delete') {
    $id = $_POST['id'];
    $query = "DELETE FROM tbl_slide WHERE id_slide = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id); // Đảm bảo bạn ràng buộc tham số
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit();
} elseif ($action == 'update') {
    // Lấy dữ liệu từ form
    $id_slide = $_POST['id_slide'];
    $slide_name = $_POST['slide_name'];
    $slide_status = $_POST['slide_status'];

    // Xử lý upload ảnh
    if ($_FILES['slide_img']['name']) {
        $slide_img = $_FILES['slide_img']['name'];
        $slide_img_tmp = $_FILES['slide_img']['tmp_name'];
        $slide_img = time() . '_' . $slide_img;

        // Đường dẫn đầy đủ đến thư mục lưu trữ ảnh
        $target_dir = '../modules/quanlyslider/images/';
        $target_file = $target_dir . $slide_img;

        // Di chuyển file đã upload vào thư mục mong muốn
        if (!move_uploaded_file($slide_img_tmp, $target_file)) {
            echo "Không thể upload ảnh. Vui lòng kiểm tra quyền truy cập thư mục: " . $target_dir;
            exit();
        }

        // Cập nhật slide với ảnh mới
        $query = "UPDATE tbl_slide SET slide_name=?, slide_img=?, slide_status=? WHERE id_slide=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssii", $slide_name, $slide_img, $slide_status, $id_slide);
    } else {
        // Cập nhật slide không có ảnh mới
        $query = "UPDATE tbl_slide SET slide_name=?, slide_status=? WHERE id_slide=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sii", $slide_name, $slide_status, $id_slide);
    }

    if ($stmt->execute()) {
        echo "Cập nhật slide thành công!";
        header("Location: ../index.php?action=quanlyslider&query=them");
        exit();
    } else {
        echo "Lỗi khi cập nhật slide: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
