<?php
include("../config/config.php"); // Kết nối đến cơ sở dữ liệu
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Hàm lấy danh sách feedback từ cơ sở dữ liệu
function getFeedbackList($page, $itemsPerPage)
{
    global $conn;

    $offset = ($page - 1) * $itemsPerPage;
    $sql = "SELECT * FROM tbl_feedback LIMIT ?, ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $offset, $itemsPerPage);
    $stmt->execute();
    $result = $stmt->get_result();

    $feedbackList = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $feedbackList[] = $row;
        }
    }

    // Lấy tổng số mục
    $sqlTotal = "SELECT COUNT(*) AS total FROM tbl_feedback";
    $resultTotal = $conn->query($sqlTotal);
    $totalItems = $resultTotal->fetch_assoc()['total'];

    return ['feedbackList' => $feedbackList, 'totalItems' => $totalItems];
}

// Xử lý request từ list_feedback.php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['page']) && isset($_GET['itemsPerPage'])) {
    $page = (int) $_GET['page'];
    $itemsPerPage = (int) $_GET['itemsPerPage'];

    $data = getFeedbackList($page, $itemsPerPage);
    echo json_encode($data);
}
// Hàm lấy email_customer từ tbl_feedback dựa trên id_feedback
function getEmailCustomerById($id_feedback)
{
    global $conn;

    $stmt = $conn->prepare("SELECT email_customer FROM tbl_feedback WHERE id_feedback = ?");
    $stmt->bind_param("i", $id_feedback);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['email_customer'];
    } else {
        return null;
    }

    $stmt->close();
}

// Hàm lưu phản hồi và gửi email
function saveFeedbackReply($id_feedback, $to_email, $subject, $content_feedback)
{
    global $conn;

    // Lưu phản hồi vào cơ sở dữ liệu (tbl_feedback_reply)
    $stmt = $conn->prepare("INSERT INTO tbl_feedback_reply (id_feedback, to_email, subject, content_feedback) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id_feedback, $to_email, $subject, $content_feedback);

    $result = $stmt->execute();
    $stmt->close();

    // Gửi email cho người nhận bằng PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Cấu hình server email
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tranphucnguyen0908@gmail.com'; // Tài khoản email của bạn
        $mail->Password = 'yxag aunm aqhd uazd'; // Mật khẩu email của bạn
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Người gửi
        $mail->setFrom('tranphucnguyen0908@gmail.com', 'Wordmart');

        // Người nhận
        $mail->addAddress($to_email);

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $content_feedback;

        // Gửi email
        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

// Xử lý request từ form phản hồi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy thông tin từ form
    $id_feedback = $_POST['id_feedback'];
    $to_email = $_POST['to_email'];
    $subject = $_POST['subject'];
    $content_feedback = $_POST['content_feedback'];

    // Lưu phản hồi vào cơ sở dữ liệu và gửi email
    $result = saveFeedbackReply($id_feedback, $to_email, $subject, $content_feedback);

    if ($result) {
        echo '<script>alert("Gửi phản hồi và email thành công.");</script>';
        header("Location: ../index.php?action=phanhoikhachhang&query=lietke");
        exit; // Dừng xử lý để chuyển hướng hoàn toàn
    } else {
        echo '<script>alert("Đã xảy ra lỗi. Vui lòng thử lại sau.");</script>';
        header("Location: ../index.php?action=phanhoikhachhang&query=lietke");
        exit; // Dừng xử lý để chuyển hướng hoàn toàn
    }
}
