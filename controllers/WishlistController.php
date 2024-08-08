<?php
session_start();
include("../admin/config/config.php");

// Hàm để lưu sản phẩm vào wishlist trong cơ sở dữ liệu
function saveWishlistToDatabase($userId, $wishlist)
{
    global $conn;

    // Xóa tất cả sản phẩm hiện có trong wishlist của người dùng
    $stmtDelete = $conn->prepare("DELETE FROM tbl_wishlist_items WHERE id_account_customer = ?");
    $stmtDelete->bind_param("i", $userId);
    $stmtDelete->execute();
    $stmtDelete->close();

    foreach ($wishlist as $productId => $quantity) {
        // Chèn sản phẩm mới vào cơ sở dữ liệu
        $stmtInsert = $conn->prepare("INSERT INTO tbl_wishlist_items (id_account_customer, product_id, quantity, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())");
        $stmtInsert->bind_param("iii", $userId, $productId, $quantity);
        $stmtInsert->execute();
        $stmtInsert->close();
    }
}

// Hàm để xóa sản phẩm khỏi wishlist trong cơ sở dữ liệu
function removeWishlistFromDatabase($userId, $productId)
{
    global $conn;

    $stmt = $conn->prepare("DELETE FROM tbl_wishlist_items WHERE id_account_customer = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id']) && isset($_POST['action'])) {
        $product_id = $_POST['product_id'];
        $action = $_POST['action']; // 'add' hoặc 'remove'
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($action == 'add') {
            // Nếu người dùng đã đăng nhập
            if (isset($_SESSION['id_account_customer'])) {
                // Lấy wishlist hiện tại từ cơ sở dữ liệu
                $userId = $_SESSION['id_account_customer'];
                $stmt = $conn->prepare("SELECT product_id, quantity FROM tbl_wishlist_items WHERE id_account_customer = ?");
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();

                $wishlist = [];
                while ($row = $result->fetch_assoc()) {
                    $wishlist[$row['product_id']] = $row['quantity'];
                }
                $stmt->close();

                // Thêm sản phẩm vào wishlist
                $wishlist[$product_id] = $quantity;
                saveWishlistToDatabase($userId, $wishlist);

                echo json_encode(['message' => 'Operation successful', 'wishlistCount' => count($wishlist)]);
                exit;
            } else {
                echo json_encode(['message' => 'User not logged in']);
                exit;
            }
        } elseif ($action == 'remove') {
            // Nếu người dùng đã đăng nhập
            if (isset($_SESSION['id_account_customer'])) {
                $userId = $_SESSION['id_account_customer'];

                // Xóa sản phẩm khỏi wishlist
                removeWishlistFromDatabase($userId, $product_id);

                echo json_encode(['message' => 'Operation successful']);
                exit;
            } else {
                echo json_encode(['message' => 'User not logged in']);
                exit;
            }
        }
    } elseif (isset($_POST['id'])) {
        $product_id = $_POST['id']; // Sử dụng key 'id' thay vì 'product_id'

        // Nếu người dùng đã đăng nhập
        if (isset($_SESSION['id_account_customer'])) {
            $userId = $_SESSION['id_account_customer'];

            // Xóa sản phẩm khỏi wishlist
            removeWishlistFromDatabase($userId, $product_id);

            echo json_encode(['message' => 'Operation successful']);
            exit;
        } else {
            echo json_encode(['message' => 'User not logged in']);
            exit;
        }
    } else {
        echo json_encode(['message' => 'Missing product_id or action in POST request']);
        exit;
    }
} else {
    echo json_encode(['message' => 'Invalid request method']);
    exit;
}