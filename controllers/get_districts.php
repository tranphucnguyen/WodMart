<?php
// Kết nối CSDL
include("../admin/config/config.php");
// Kiểm tra nếu province_id được truyền vào
if (isset($_GET['province_id']) && !empty($_GET['province_id'])) {
    $provinceId = $_GET['province_id'];

    // Lấy danh sách quận/huyện
    $sql = "SELECT id_districts, name_districts FROM tbl_districts WHERE id_provinces = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $provinceId);
    $stmt->execute();
    $result = $stmt->get_result();

    $districts = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $districts[] = $row;
        }
    }

    $stmt->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($districts);
