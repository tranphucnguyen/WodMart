<?php
// Kết nối CSDL
include("../admin/config/config.php");
if (isset($_POST['query'])) {
    $query = $conn->real_escape_string($_POST['query']);
    $sql = "SELECT * FROM tbl_product WHERE product_name LIKE '%$query%' LIMIT 10";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="search-result-item">';
            echo '<a href="index.php?quanly=Shop_details&id=' . $row['id_product'] . '">' . $row['product_name'] . '</a>';
            echo '</div>';
        }
    } else {
        echo '<p>No products found</p>';
    }
}