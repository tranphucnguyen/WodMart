<?php
require_once("../admin/config/config.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Đảm bảo rằng session 'checkout_products' đã được khởi tạo
if (!isset($_SESSION['checkout_products'])) {
    $_SESSION['checkout_products'] = array(); // Khởi tạo mảng nếu chưa tồn tại
}

// Kiểm tra nếu là phương thức POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Biến phản hồi mặc định
    $response = array('success' => false);

    try {
        // Kiểm tra và lấy dữ liệu từ form
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $email_customer = $_SESSION['email_customer'];
        $phone_customer = $_POST['phone_customer'];
        $address = $_POST['address'];
        $province_id = $_POST['province_id'];
        $district_id = $_POST['district_id'];
        $town_id = $_POST['town_id'];
        $postcode = $_POST['postcode'];
        $total = $_POST['total'];
        $payment_method = $_POST['payment_method'];

        // Generate a random order code
        $order_code = generateOrderCode();

        // Chuẩn bị câu lệnh SQL để chèn đơn hàng vào cơ sở dữ liệu
        $order_status = 0; // Mặc định order_status là 0 (chưa giao hàng)

        // Kiểm tra số lượng sản phẩm trong kho
        $canPlaceOrder = true; // Biến kiểm tra có thể đặt hàng hay không

        // Xử lý thông tin sản phẩm
        if (isset($_POST['products']) && is_array($_POST['products'])) {
            // Phân chia các sản phẩm thành các mảng con cho ID, tên, số lượng và giá
            $products = array_chunk($_POST['products'], 4);

            foreach ($products as $product) {
                $id_product = htmlspecialchars($product[0]);
                $product_name = htmlspecialchars($product[1]);
                $quantity = $product[2];
                $total_price = $product[3];

                // Kiểm tra số lượng sản phẩm trong kho
                $stmt_check_stock = $conn->prepare("SELECT product_quantity FROM tbl_product WHERE id_product = ?");
                $stmt_check_stock->bind_param("i", $id_product);
                $stmt_check_stock->execute();
                $stmt_check_stock->bind_result($stock_quantity);
                $stmt_check_stock->fetch();
                $stmt_check_stock->close();

                if ($stock_quantity < $quantity) {
                    // Lưu thông báo lỗi vào session và chuyển hướng lại về trang form
                    $_SESSION['error_message'] = "Số lượng sản phẩm không đủ trong kho cho sản phẩm $product_name.";
                    $canPlaceOrder = false;
                    break; // Thoát khỏi vòng lặp
                }
            }
        }

        // Nếu không đủ số lượng sản phẩm trong kho, không tiếp tục đặt hàng
        if (!$canPlaceOrder) {
            header('Location: ../index.php?quanly=Checkout'); // Chuyển hướng về trang form
            exit;
        }

        // Sử dụng Prepared Statement để chèn dữ liệu vào bảng tbl_order
        $stmt_order = $conn->prepare("INSERT INTO tbl_order (ma_dh, first_name, last_name, email, email_customer, phone_customer, address_customer, id_provinces, id_districts, id_town, postcode, total, payment_method, order_status)
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_order->bind_param("ssssssssssssss", $order_code, $first_name, $last_name, $email, $email_customer, $phone_customer, $address, $province_id, $district_id, $town_id, $postcode, $total, $payment_method, $order_status);

        // Thực thi câu lệnh SQL
        if ($stmt_order->execute()) {
            // Lấy id_order vừa được chèn vào
            $id_order = $conn->insert_id;

            // Xử lý thông tin sản phẩm
            if (isset($_POST['products']) && is_array($_POST['products'])) {
                // Phân chia các sản phẩm thành các mảng con cho ID, tên, số lượng và giá
                $products = array_chunk($_POST['products'], 4);

                foreach ($products as $product) {
                    $id_product = htmlspecialchars($product[0]);
                    $product_name = htmlspecialchars($product[1]);
                    $quantity = $product[2];
                    $total_price = $product[3];

                    // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào bảng tbl_order_detail
                    $stmt_product = $conn->prepare("INSERT INTO tbl_order_detail (id_order, id_product, product_name, quantity, total_price)
                                                   VALUES (?, ?, ?, ?, ?)");
                    $stmt_product->bind_param("iisdd", $id_order, $id_product, $product_name, $quantity, $total_price);

                    // Thực thi câu lệnh SQL
                    if (!$stmt_product->execute()) {
                        throw new Exception('Lỗi khi thêm chi tiết đơn hàng.');
                    }

                    // Giảm số lượng sản phẩm trong kho
                    $stmt_update_stock = $conn->prepare("UPDATE tbl_product SET product_quantity = product_quantity - ? WHERE id_product = ?");
                    $stmt_update_stock->bind_param("ii", $quantity, $id_product);
                    $stmt_update_stock->execute();
                    $stmt_update_stock->close();

                    // Đóng statement của tbl_order_detail
                    $stmt_product->close();
                }
            }

            // Xóa sản phẩm đã checkout khỏi session sau khi đặt hàng thành công (nếu cần thiết)
            unset($_SESSION['checkout_products']);

            // Gửi email cho khách hàng
            $mail = new PHPMailer(true);
            try {
                // Cấu hình server email
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tranphucnguyen0908@gmail.com';
                $mail->Password = 'yxag aunm aqhd uazd';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Người gửi
                $mail->setFrom('tranphucnguyen0908@gmail.com', 'Wordmart');

                // Người nhận
                $mail->addAddress($email_customer, $first_name . ' ' . $last_name);

                // Nội dung email
                $mail->isHTML(true);
                $mail->Subject = 'Cảm ơn bạn đã mua hàng!';
                $mail->Body = 'Kính chào ' . $first_name . ' ' . $last_name . ',<br><br>Cảm ơn bạn đã mua hàng. Đơn hàng của bạn có mã: ' . $order_code . ' đã được đặt thành công.<br><br>Trân trọng,<br>Wordmart';

                $mail->send();
            } catch (Exception $e) {
                // Nếu email không thể gửi, ghi log lỗi hoặc xử lý theo nhu cầu
            }

            // Đặt hàng thành công
            $response['success'] = true;
            $response['message'] = 'Đặt hàng thành công.';
            header('Location: ../index.php?quanly=Checkout'); // Chuyển hướng về trang Checkout
            exit;
        } else {
            throw new Exception('Lỗi khi đặt hàng.');
        }

        // Đóng kết nối
        $stmt_order->close();
        $conn->close();
    } catch (Exception $e) {
        // Xử lý ngoại lệ và trả về thông báo lỗi
        $_SESSION['error_message'] = $e->getMessage();
        header('Location: ../index.php?quanly=Checkout'); // Chuyển hướng về trang form
        exit;
    }
} else {
    // Phản hồi nếu phương thức yêu cầu không hợp lệ
    $_SESSION['error_message'] = 'Phương thức yêu cầu không hợp lệ.';
    header('Location: ../index.php?quanly=Checkout'); // Chuyển hướng về trang form
    exit;
}

// Function to generate a random order code
function generateOrderCode()
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $order_code = '';
    for ($i = 0; $i < 10; $i++) {
        $order_code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $order_code;
}
echo '<pre>';
print_r($_POST);
echo '</pre>';
exit;