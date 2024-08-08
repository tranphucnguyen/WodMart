<?php
// Include database configuration
include("../admin/config/config.php");

// Start session
session_start();

// Handle POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process checkout request
    if (isset($_POST['checkout'])) {
        // Initialize $cartProducts
        $cartProducts = [];

        // Check if user is logged in
        if (isset($_SESSION['id_account_customer'])) {
            $userId = $_SESSION['id_account_customer'];

            // Query to get the details of products in the user's cart from tbl_cart_items
            $sql = "SELECT tbl_product.*, tbl_cart_items.quantity FROM tbl_cart_items 
                    INNER JOIN tbl_product ON tbl_cart_items.product_id = tbl_product.id_product 
                    WHERE tbl_cart_items.id_account_customer = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Save product details to the $cartProducts array
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cartProducts[] = $row;
                }
            }

            // Close the statement
            $stmt->close();
        }

        // Save the product list to the session for use in the checkout page
        $_SESSION['checkout_products'] = $cartProducts;

        // Redirect the user to the checkout page
        header("Location: ../index.php?quanly=Checkout");
        exit;
    }
}

// Return error message if the request method is not valid
echo json_encode(['success' => false, 'message' => 'Invalid request method']);
exit;
