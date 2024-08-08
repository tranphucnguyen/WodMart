<?php
session_start();
include("../config/config.php");

$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

if (isset($_POST['add_product'])) {
    // Lấy dữ liệu từ form
    $id_category = $_POST['id_category'];
    $id_subcategory = $_POST['id_subcategory'];
    $product_name = $_POST['product_name'];
    $product_desc = $_POST['product_desc'];
    $product_price = $_POST['product_price'];
    $product_price_sales = $_POST['product_price_sales'];
    $product_quantity = $_POST['product_quantity'];
    $product_status = $_POST['product_status'];

    // Xử lý upload ảnh sản phẩm
    $product_img = $_FILES['product_img']['name'];
    $product_img_tmp = $_FILES['product_img']['tmp_name'];
    $product_img = time() . '_' . $product_img;

    // Xử lý upload ảnh mô tả sản phẩm
    $product_img_desc = $_FILES['product_img_desc']['name'];
    $product_img_desc_tmp = $_FILES['product_img_desc']['tmp_name'];

    // Đường dẫn đầy đủ đến thư mục lưu trữ ảnh
    $target_dir = '../modules/quanlysanpham/images/';

    // Lưu thông tin sản phẩm vào bảng tbl_product
    $query = "INSERT INTO tbl_product (
        id_category, id_subcategory, product_name, product_desc, product_price, product_price_sales, product_quantity, product_img, product_status, product_img_desc
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "iissiiisis",
        $id_category,
        $id_subcategory,
        $product_name,
        $product_desc,
        $product_price,
        $product_price_sales,
        $product_quantity,
        $product_img,
        $product_status,
        $product_img_desc
    );

    // Di chuyển file đã upload vào thư mục mong muốn
    if (move_uploaded_file($product_img_tmp, $target_dir . $product_img)) {
        // Lưu các tên file ảnh mô tả sản phẩm vào một mảng
        $product_img_desc_names = [];
        foreach ($product_img_desc_tmp as $key => $tmp_name) {
            $new_name = time() . '_' . $product_img_desc[$key];
            if (move_uploaded_file($tmp_name, $target_dir . $new_name)) {
                $product_img_desc_names[] = $new_name;
            } else {
                echo "Không thể upload file ảnh mô tả $key.";
            }
        }

        // Nối tên file ảnh mô tả sản phẩm thành một chuỗi
        $product_img_desc_str = implode(',', $product_img_desc_names);

        // Gán chuỗi tên file ảnh mô tả sản phẩm vào biến product_img_desc
        $product_img_desc = $product_img_desc_str;

        if ($stmt->execute()) {
            // Lấy ID của sản phẩm vừa được thêm vào
            $product_id = $stmt->insert_id;

            // Xử lý lưu thông tin màu sắc vào bảng tbl_product_color
            if (isset($_POST['product_color']) && is_array($_POST['product_color'])) {
                foreach ($_POST['product_color'] as $color) {
                    $query_color = "INSERT INTO tbl_product_color (id_product, color) VALUES (?, ?)";
                    $stmt_color = $conn->prepare($query_color);
                    $stmt_color->bind_param("is", $product_id, $color);
                    $stmt_color->execute();
                }
            }

            echo "Thêm sản phẩm thành công!";
            header("Location: ../index.php?action=quanlysanpham&query=them");
            exit();
        } else {
            echo "Lỗi khi thêm sản phẩm: " . $stmt->error;
        }
    } else {
        echo "Không thể upload ảnh hoặc ảnh mô tả. Vui lòng kiểm tra quyền truy cập thư mục: " . $target_dir;
    }

    $stmt->close();
    $conn->close();
} elseif ($action == 'list_subcategories') {
    // Get the category_id parameter from the request
    $category_id = $_GET['category_id'];

    // Code for listing subcategories based on the selected category
    // Truy vấn subcategories từ database
    $query = "SELECT id_subcategory, subcategory_name FROM tbl_subcategory WHERE id_category = ? ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $subcategories = [];
    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }

    // Trả về dữ liệu subcategories dưới dạng JSON
    echo json_encode($subcategories);

    $conn->close();
} elseif ($action == 'list_products') {
    // Truy vấn danh sách sản phẩm từ cơ sở dữ liệu
    $query = "SELECT p.*, c.category_name, sc.subcategory_name 
              FROM tbl_product p
              JOIN tbl_category c ON p.id_category = c.id_category
              JOIN tbl_subcategory sc ON p.id_subcategory = sc.id_subcategory  ORDER BY p.id_product ASC";
    $result = $conn->query($query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Trả về dữ liệu sản phẩm dưới dạng JSON
    echo json_encode($products);

    $conn->close();
} elseif ($action == 'delete_product') {
    // Xử lý xóa sản phẩm
    $product_id = $_POST['id'];

    // Bắt đầu transaction
    $conn->begin_transaction();

    try {
        // Xóa các bản ghi liên quan trong tbl_product_color
        $query_color = "DELETE FROM tbl_product_color WHERE id_product = ?";
        $stmt_color = $conn->prepare($query_color);
        $stmt_color->bind_param("i", $product_id);

        if (!$stmt_color->execute()) {
            throw new Exception($stmt_color->error);
        }

        // Xóa sản phẩm trong tbl_product
        $query_product = "DELETE FROM tbl_product WHERE id_product = ?";
        $stmt_product = $conn->prepare($query_product);
        $stmt_product->bind_param("i", $product_id);

        if (!$stmt_product->execute()) {
            throw new Exception($stmt_product->error);
        }

        // Commit transaction nếu không có lỗi
        $conn->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        // Rollback transaction nếu có lỗi
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    $stmt_color->close();
    $stmt_product->close();
    $conn->close();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit_product'])) {
        // Lấy dữ liệu từ form
        $id_product = $_POST['id_product'];
        $id_category = $_POST['id_category'];
        $id_subcategory = $_POST['id_subcategory'];
        $product_name = $_POST['product_name'];
        $product_desc = $_POST['product_desc'];
        $product_price = $_POST['product_price'];
        $product_price_sales = $_POST['product_price_sales'];
        $product_status = $_POST['product_status'];

        // Xử lý mảng các màu sắc được chọn
        $product_colors = isset($_POST['product_color']) ? implode(',', $_POST['product_color']) : '';

        // Upload ảnh chính nếu có
        if (isset($_FILES['product_img']) && $_FILES['product_img']['error'] == 0) {
            $product_img = basename($_FILES['product_img']['name']);
            $target_file = "../modules/quanlysanpham/images/" . $product_img;
            move_uploaded_file($_FILES['product_img']['tmp_name'], $target_file);

            // Xóa ảnh cũ nếu tồn tại và tải lên ảnh mới thành công
            if (!empty($product['product_img'])) {
                $old_img_path = "../modules/quanlysanpham/images/" . $product['product_img'];
                if (file_exists($old_img_path)) {
                    unlink($old_img_path); // Xóa ảnh cũ
                }
            }
        } else {
            // Nếu không upload ảnh mới thì giữ nguyên ảnh cũ
            $product_img = $product['product_img'];
        }

        // Upload ảnh mô tả nếu có
        if (isset($_FILES['product_img_desc']) && !empty($_FILES['product_img_desc']['name'][0])) {
            $product_img_desc = [];
            foreach ($_FILES['product_img_desc']['name'] as $key => $value) {
                $img_name = basename($value);
                $target_file = "../modules/quanlysanpham/images/" . $img_name;
                move_uploaded_file($_FILES['product_img_desc']['tmp_name'][$key], $target_file);
                $product_img_desc[] = $img_name;
            }
            $product_img_desc = implode(',', $product_img_desc);
        } else {
            // Nếu không upload ảnh mới thì giữ nguyên ảnh cũ
            $product_img_desc = $product['product_img_desc'];
        }

        // Cập nhật sản phẩm trong bảng tbl_product
        $query_update_product = "UPDATE tbl_product SET id_category=?, id_subcategory=?, product_name=?, product_desc=?, product_price=?, product_price_sales=?, product_img=?, product_img_desc=?, product_status=? WHERE id_product=?";
        $stmt_update_product = $conn->prepare($query_update_product);
        $stmt_update_product->bind_param("iissssssii", $id_category, $id_subcategory, $product_name, $product_desc, $product_price, $product_price_sales, $product_img, $product_img_desc, $product_status, $id_product);

        // Thực hiện cập nhật sản phẩm trong bảng tbl_product
        if ($stmt_update_product->execute()) {
            // Cập nhật màu sắc trong bảng tbl_product_color
            if (!empty($product_colors)) {
                // Xóa dữ liệu cũ trong bảng tbl_product_color cho sản phẩm này
                $query_delete_colors = "DELETE FROM tbl_product_color WHERE id_product=?";
                $stmt_delete_colors = $conn->prepare($query_delete_colors);
                $stmt_delete_colors->bind_param("i", $id_product);
                $stmt_delete_colors->execute();

                // Thêm màu sắc mới vào bảng tbl_product_color
                $colors = explode(',', $product_colors);
                foreach ($colors as $color) {
                    $query_insert_color = "INSERT INTO tbl_product_color (id_product, color) VALUES (?, ?)";
                    $stmt_insert_color = $conn->prepare($query_insert_color);
                    $stmt_insert_color->bind_param("is", $id_product, $color);
                    $stmt_insert_color->execute();
                }
            }
        } else {
            // Nếu cập nhật không thành công, thông báo lỗi
            echo "Lỗi: " . $conn->error;
        }
        header("Location: ../index.php?action=quanlysanpham&query=lietke");
    }
} elseif (isset($_GET['action']) && $_GET['action'] == 'list_subcategories' && isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $query_subcategory = "SELECT * FROM tbl_subcategory WHERE id_category = ?";
    $stmt_subcategory = $conn->prepare($query_subcategory);
    $stmt_subcategory->bind_param("i", $category_id);
    $stmt_subcategory->execute();
    $result_subcategory = $stmt_subcategory->get_result();
    $subcategories = [];
    while ($row_subcategory = $result_subcategory->fetch_assoc()) {
        $subcategories[] = $row_subcategory;
    }
    echo json_encode($subcategories);
} else {
    echo "Không có dữ liệu được gửi đến server!";
}
