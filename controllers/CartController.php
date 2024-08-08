<?php
session_start();
include("../admin/config/config.php");

// Hàm để lưu giỏ hàng vào cơ sở dữ liệu
function saveCartToDatabase($userId, $cart)
{
    global $conn;

    // Xóa tất cả các mục trong giỏ hàng của người dùng trước khi thêm mới
    $stmtDelete = $conn->prepare("DELETE FROM tbl_cart_items WHERE id_account_customer = ?");
    $stmtDelete->bind_param("i", $userId);
    $stmtDelete->execute();
    $stmtDelete->close();

    // Thêm các mục mới vào cơ sở dữ liệu
    foreach ($cart as $productId => $quantity) {
        $stmtInsert = $conn->prepare("INSERT INTO tbl_cart_items (id_account_customer, product_id, quantity, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW()) ON DUPLICATE KEY UPDATE quantity = VALUES(quantity), updated_at = NOW()");
        $stmtInsert->bind_param("iii", $userId, $productId, $quantity);
        $stmtInsert->execute();
        $stmtInsert->close();
    }
}

// Hàm để xóa sản phẩm khỏi giỏ hàng trong cơ sở dữ liệu
function removeProductFromDatabase($userId, $productId)
{
    global $conn;

    $stmt = $conn->prepare("DELETE FROM tbl_cart_items WHERE id_account_customer = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();
    $stmt->close();
}

// Hàm để lấy giỏ hàng từ cơ sở dữ liệu
function getCartFromDatabase($userId)
{
    global $conn;
    $cartProducts = [];

    $stmt = $conn->prepare("SELECT tbl_product.*, tbl_cart_items.quantity FROM tbl_cart_items INNER JOIN tbl_product ON tbl_cart_items.product_id = tbl_product.id_product WHERE tbl_cart_items.id_account_customer = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cartProducts[] = $row;
        }
    }
    $stmt->close();

    return $cartProducts;
}

// Handle POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Xử lý yêu cầu xóa sản phẩm khỏi giỏ hàng (cho yêu cầu AJAX)
    if (isset($_POST['remove_product_id'])) {
        $remove_product_id = $_POST['remove_product_id'];

        // Xóa sản phẩm khỏi cơ sở dữ liệu nếu người dùng đã đăng nhập
        if (isset($_SESSION['id_account_customer'])) {
            removeProductFromDatabase($_SESSION['id_account_customer'], $remove_product_id);

            // Lấy lại giỏ hàng từ cơ sở dữ liệu
            $cartProducts = getCartFromDatabase($_SESSION['id_account_customer']);

            // Cập nhật số lượng sản phẩm trong giỏ hàng
            $cartCount = count($cartProducts);

            echo json_encode(['success' => true, 'message' => 'Product removed', 'cartCount' => $cartCount]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            exit;
        }
    }

    // Xử lý các hành động sản phẩm (thêm/xóa/cập nhật số lượng)
    if (isset($_POST['product_id']) && isset($_POST['action'])) {
        $product_id = $_POST['product_id'];
        $action = $_POST['action']; // 'add', 'remove', hoặc 'update'
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        // Nếu người dùng đã đăng nhập, lấy giỏ hàng từ cơ sở dữ liệu
        if (isset($_SESSION['id_account_customer'])) {
            $cartProducts = getCartFromDatabase($_SESSION['id_account_customer']);
            $cart = [];

            // Cập nhật giỏ hàng dựa trên hành động
            foreach ($cartProducts as $item) {
                $cart[$item['id_product']] = $item['quantity'];
            }

            if ($action == 'add') {
                if (!isset($cart[$product_id])) {
                    $cart[$product_id] = 0;
                }
                $cart[$product_id] += $quantity;
            } elseif ($action == 'remove') {
                if (isset($cart[$product_id])) {
                    unset($cart[$product_id]);
                }
            } elseif ($action == 'update') {
                if (isset($cart[$product_id])) {
                    $cart[$product_id] = $quantity;
                }
            }

            // Lưu giỏ hàng vào cơ sở dữ liệu
            saveCartToDatabase($_SESSION['id_account_customer'], $cart);

            // Lấy lại giỏ hàng từ cơ sở dữ liệu
            $cartProducts = getCartFromDatabase($_SESSION['id_account_customer']);

            // Tính toán subtotal và tổng tiền
            $subtotal = 0;
            $localDeliveryFee = 20; // Điều chỉnh nếu cần
            $updatedPrices = [];

            foreach ($cartProducts as $item) {
                $price = $item['product_price'] * $item['quantity'];
                $subtotal += $price;
                $updatedPrices[$item['id_product']] = $price;
            }

            $total = $subtotal + $localDeliveryFee;

            // Cập nhật số lượng sản phẩm trong giỏ hàng
            $cartCount = count($cartProducts);

            echo json_encode([
                'success' => true,
                'message' => $action == 'add' ? 'Product added' : 'Product updated',
                'cartCount' => $cartCount,
                'updatedPrices' => $updatedPrices,
                'subtotal' => $subtotal,
                'total' => $total
            ]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            exit;
        }
    }

    // Thêm vào đầu file PHP, sau khi gọi session_start() và include config
    error_log('Request Data: ' . print_r($_POST, true)); // Ghi lại toàn bộ dữ liệu POST nhận được

    if (isset($_POST['cart'])) {
        $cartData = $_POST['cart'];

        // Ghi lại dữ liệu giỏ hàng nhận được để kiểm tra
        error_log('Cart Data Received: ' . print_r($cartData, true));

        // Kiểm tra và điều chỉnh dữ liệu giỏ hàng
        $adjustedCartData = [];
        foreach ($cartData as $item) {
            // Kiểm tra xem product_id có phải là số không
            if (isset($item['product_id']) && is_numeric($item['product_id']) && isset($item['quantity']) && is_numeric($item['quantity'])) {
                $productId = (int)$item['product_id'];
                $quantity = (int)$item['quantity'];
                // Thêm vào danh sách giỏ hàng đã điều chỉnh
                $adjustedCartData[$productId] = $quantity;
            } else {
                // Ghi lại lỗi nếu dữ liệu không hợp lệ
                error_log('Invalid data in cart: ' . print_r($item, true));
            }
        }

        // Ghi lại dữ liệu giỏ hàng đã điều chỉnh
        error_log('Adjusted Cart Data: ' . print_r($adjustedCartData, true));

        // Tiếp tục xử lý dữ liệu giỏ hàng đã điều chỉnh
        if (isset($_SESSION['id_account_customer'])) {
            saveCartToDatabase($_SESSION['id_account_customer'], $adjustedCartData);

            $cartProducts = getCartFromDatabase($_SESSION['id_account_customer']);

            $subtotal = 0;
            $localDeliveryFee = 20;
            $updatedPrices = [];

            foreach ($cartProducts as $item) {
                $price = $item['product_price'] * $item['quantity'];
                $subtotal += $price;
                $updatedPrices[$item['id_product']] = $price;
            }

            $total = $subtotal + $localDeliveryFee;
            $cartCount = count($cartProducts);

            echo json_encode([
                'success' => true,
                'updatedPrices' => $updatedPrices,
                'subtotal' => $subtotal,
                'total' => $total,
                'cartCount' => $cartCount
            ]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'User not logged in']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No cart data provided']);
        exit;
    }



    // Trả về thông báo lỗi nếu không có dữ liệu POST hợp lệ
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Trả về thông báo lỗi nếu không phải là phương thức yêu cầu hợp lệ
echo json_encode(['success' => false, 'message' => 'Invalid request method']);
exit;
