<?php
// Kết nối CSDL
include("../admin/config/config.php");

// Lấy danh sách tỉnh/thành phố
$sql = "SELECT id_provinces, name_provinces FROM tbl_provinces";
$result = $conn->query($sql);

$provinces = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $provinces[] = $row;
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($provinces);
