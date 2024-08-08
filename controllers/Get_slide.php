<?php
// Kết nối CSDL
include("../admin/config/config.php");

// Truy vấn để lấy các slide có slide_status == 1
$sql = "SELECT * FROM tbl_slide WHERE slide_status = 1";
$result = mysqli_query($conn, $sql);

// Tạo một mảng để lưu trữ các slide
$slides = array();

// Kiểm tra kết quả truy vấn
if (mysqli_num_rows($result) > 0) {
    // Duyệt qua từng dòng dữ liệu
    while ($row = mysqli_fetch_assoc($result)) {
        // Thêm slide vào mảng
        $slides[] = $row;
    }
}

// Trả về dữ liệu dưới dạng JSON
echo json_encode(array('slides' => $slides));
