<?php
//Kết nối database
include("../admin/config/config.php");

// Kiểm tra nếu district_id được truyền vào
if (isset($_GET['district_id']) && !empty($_GET['district_id'])) {
    $districtId = $_GET['district_id'];

    // Lấy danh sách xã/phường/thị trấn
    $sql = "SELECT id_town, name_town FROM tbl_town WHERE id_districts = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $districtId);
    $stmt->execute();
    $result = $stmt->get_result();

    $towns = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $towns[] = $row;
        }
    }

    $stmt->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($towns);
