<main>
    <?php
    if (isset($_GET['quanly'])) {
        $quanly = $_GET['quanly'];
    } else {
        $quanly = '';
    }
    if ($quanly == '' || $quanly == 'Home') {
        // Chỉ hiển thị slider.php khi ở trang index.php
        include("slider.php");
    }
    if ($quanly == "Login") {
        include("views/maincontent/login.php");
    } elseif ($quanly == "Signup") {
        include("views/maincontent/signup.php");
    } elseif ($quanly == "About") {
        include("views/maincontent/about.php");
    } elseif ($quanly == "Contact") {
        include("views/maincontent/contact.php");
    } elseif ($quanly == "Wishlist") {
        include("views/maincontent/wishlist.php");
    } elseif ($quanly == "Shopping Cart") {
        include("views/maincontent/shoppingcart.php");
    } elseif ($quanly == "Checkout") {
        include("views/maincontent/checkout.php");
    } elseif ($quanly == "Shop") {
        include("views/maincontent/shop.php");
    } elseif ($quanly == "Blog") {
        include("views/maincontent/blog.php");
    } elseif ($quanly == "Shop_details") {
        include("views/maincontent/shop_details.php");
    } elseif ($quanly == "Forgot_password") {
        include("views/maincontent/forgot_password.php");
    } elseif ($quanly == "Verification") {
        include("views/maincontent/verification.php");
    } elseif ($quanly == "New_password") {
        include("views/maincontent/new_password.php");
    } elseif ($quanly == "Order Track") {
        include("views/maincontent/order_track.php");
    } else {
        include("views/maincontent/index.php");
    }
    ?>


</main>