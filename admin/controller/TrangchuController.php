<?php
session_start();
include("../config/config.php");

// Lấy tổng số đơn hàng
$result_orders = $conn->query("SELECT COUNT(DISTINCT id_order) AS total_orders FROM tbl_order");
$total_orders = $result_orders->fetch_assoc()['total_orders'];

// Tính tổng giá trị của tất cả các đơn hàng
$result_revenue = $conn->query("SELECT SUM(total) AS total_revenue FROM tbl_order");
$total_revenue = $result_revenue->fetch_assoc()['total_revenue'];

// Lấy tổng số lượng khách hàng
$result_customers = $conn->query("SELECT COUNT(*) AS total_customers FROM tbl_account_customers");
$total_customers = $result_customers->fetch_assoc()['total_customers'];

// Lấy tổng số sản phẩm
$result_products = $conn->query("SELECT COUNT(*) AS total_products FROM tbl_product");
$total_products = $result_products->fetch_assoc()['total_products'];

// Lấy dữ liệu cho biểu đồ sales
$result_sales = $conn->query("SELECT DATE(order_date) as order_date, COUNT(id_order) as order_count FROM tbl_order GROUP BY DATE(order_date) ORDER BY DATE(order_date) ASC");
$sales_data = array();
while ($row = $result_sales->fetch_assoc()) {
    $sales_data[] = $row;
}

// Chuẩn bị dữ liệu thống kê
$statistics = array(
    'total_orders' => $total_orders,
    'total_revenue' => $total_revenue,
    'total_customers' => $total_customers,
    'total_products' => $total_products,
    'sales_data' => $sales_data
);

// Trả về dữ liệu dưới dạng JSON
echo json_encode($statistics);
