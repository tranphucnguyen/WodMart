<?php

// Kiểm tra nếu người dùng đã đăng nhập
$id_account_customer = isset($_SESSION['id_account_customer']) ? $_SESSION['id_account_customer'] : null;
$cartProducts = [];

if ($id_account_customer) {
    // Lấy danh sách sản phẩm trong giỏ hàng từ cơ sở dữ liệu dựa vào id_account_customer
    $stmt = $conn->prepare("SELECT tbl_product.*, tbl_cart_items.quantity FROM tbl_cart_items INNER JOIN tbl_product ON tbl_cart_items.product_id = tbl_product.id_product WHERE tbl_cart_items.id_account_customer = ?");
    $stmt->bind_param("i", $id_account_customer);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cartProducts[] = $row;
        }
    }
    $stmt->close();
} else {
    // Nếu người dùng chưa đăng nhập, sử dụng dữ liệu từ session
    if (!empty($_SESSION['cart'])) {
        // Tạo danh sách các ID sản phẩm từ session
        $productIds = array_keys($_SESSION['cart']);
        $productPlaceholders = implode(',', array_fill(0, count($productIds), '?'));

        // Truy vấn cơ sở dữ liệu để lấy thông tin sản phẩm
        $sql = "SELECT * FROM tbl_product WHERE id_product IN ($productPlaceholders)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(str_repeat('i', count($productIds)), ...$productIds);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['quantity'] = $_SESSION['cart'][$row['id_product']];
                $cartProducts[] = $row;
            }
        }
        $stmt->close();
    }
}

// Tính toán tổng tiền
$subtotal = 0;
$localDeliveryFee = 20; // Có thể thay đổi tùy theo yêu cầu

foreach ($cartProducts as $item) {
    $subtotal += $item['product_price'] * $item['quantity'];
}

$total = $subtotal + $localDeliveryFee;
?>


<!-- CSS cho button tăng giảm số lượng -->

<!-- Breadcrumbs S t a r t -->
<section class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Shopping Cart</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index.php?quanly" class="single">Home</a>
                            </li>
                            <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                    class="single active">Shopping Cart</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End-of Breadcrumbs-->
<!-- wishlist area S t a r t -->
<div class="wishlist-product section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table product-cart-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Information</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cartProducts)) : ?>
                            <?php foreach ($cartProducts as $product) : ?>
                            <tr>
                                <td class="cart-img">
                                    <div class="thumb-img">
                                        <img src="admin/modules/quanlysanpham/images/<?php echo $product['product_img']; ?>"
                                            alt="img">
                                    </div>
                                </td>
                                <td class="cart-info">
                                    <div class="cart-box">
                                        <a href="shop-details.html">
                                            <p class="cart-pera mb-15"><?php echo $product['product_name']; ?></p>
                                        </a>
                                        <div class="ratting-section mb-18">
                                            <div class="all-ratting">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                                    viewBox="0 0 15 14" fill="none">
                                                    <path
                                                        d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z"
                                                        fill="#FFA800" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                                    viewBox="0 0 15 14" fill="none">
                                                    <path
                                                        d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z"
                                                        fill="#FFA800" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                                    viewBox="0 0 15 14" fill="none">
                                                    <path
                                                        d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z"
                                                        fill="#FFA800" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                                    viewBox="0 0 15 14" fill="none">
                                                    <path
                                                        d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z"
                                                        fill="#FFA800" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                                    viewBox="0 0 15 14" fill="none">
                                                    <path
                                                        d="M7.5 0L9.18386 5.18237H14.6329L10.2245 8.38525L11.9084 13.5676L7.5 10.3647L3.09161 13.5676L4.77547 8.38525L0.367076 5.18237H5.81614L7.5 0Z"
                                                        fill="#FFA800" />
                                                </svg>
                                            </div>
                                            <div class="ratting-count">
                                                <p class="pera">(22)</p>
                                            </div>
                                        </div>
                                        <p class="cart-pera">$<?php echo $product['product_price'] ?></p>
                                    </div>
                                </td>
                                <!-- HTML của button tăng giảm số lượng với class mới -->
                                <td class="cart-qty">
                                    <div class="quantity-section">
                                        <div class="quantity-btn-custom position-relative">
                                            <button class="decrease-num-custom">-</button>
                                            <input type="text" name="qty" value="<?php echo $product['quantity']; ?>"
                                                class="num-count" readonly
                                                data-product-id="<?php echo $product['id_product']; ?>">
                                            <button class="increase-num-custom">+</button>
                                        </div>
                                    </div>
                                </td>
                                <td class="cart-price" data-product-id="<?php echo $product['id_product']; ?>">
                                    <p class="cart-pera text-center price-value"
                                        data-price="<?php echo $product['product_price']; ?>">
                                        $<?php echo $product['product_price'] * $product['quantity']; ?>
                                    </p>
                                </td>




                                <td class=" action">
                                    <div class="text-center">

                                        <a href="javascript:void(0)" class="del-icon"
                                            data-product-id="<?php echo $product['id_product']; ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="21"
                                                viewBox="0 0 20 21" fill="none">
                                                <path
                                                    d="M9.76126 20.9806C8.58921 20.9291 7.11625 21.0958 5.65575 20.9082C4.14925 20.7177 3.06824 19.5157 2.97241 18.0042C2.78074 15.0954 2.58908 12.186 2.39741 9.27591C2.30253 7.90438 2.19424 6.52618 2.11662 5.14989C2.09841 4.8194 1.97382 4.69558 1.65278 4.71082C1.36541 4.72641 1.07733 4.72386 0.790281 4.7032C0.336988 4.66605 0.0331962 4.36412 0.00252952 3.95076C-0.0290955 3.50692 0.237322 3.1707 0.717448 3.09356C0.957043 3.06347 1.19866 3.05232 1.44003 3.06022C2.81237 3.06022 4.18566 3.03641 5.56087 3.06022C6.03142 3.06879 6.18667 2.90973 6.14737 2.45827C6.11989 2.17394 6.13637 1.88711 6.19625 1.60773C6.40612 0.676239 7.21496 0.0447651 8.26242 0.0200014C9.41242 -0.00666715 10.5624 -0.00666715 11.7124 0.0200014C13.0359 0.0523847 13.8639 0.927686 13.8687 2.24492V2.38779C13.8687 3.05451 13.8687 3.05451 14.5165 3.05451L18.7332 3.06308C18.9086 3.057 19.0843 3.06528 19.2584 3.08784C19.7423 3.16594 20.0174 3.48692 19.9992 3.92885C19.9809 4.37079 19.6714 4.67367 19.1903 4.70796C18.9031 4.72546 18.6152 4.72768 18.3278 4.71462C18.0288 4.7032 17.9061 4.82035 17.8889 5.12894C17.7324 7.86628 17.5682 10.603 17.3963 13.3391C17.2957 14.9516 17.2439 16.5717 17.0504 18.1737C16.8424 19.8986 15.5448 20.9596 13.792 20.9806C12.5462 20.9929 11.3013 20.9806 9.76126 20.9806ZM9.28209 4.71748H4.39554C3.78987 4.71748 3.76879 4.71748 3.80233 5.32705C3.91829 7.39863 4.05054 9.47021 4.17608 11.5418C4.3045 13.6762 4.4262 15.8116 4.56516 17.9461C4.57959 18.3168 4.73856 18.6674 5.00846 18.9237C5.27835 19.1801 5.63799 19.322 6.01129 19.3195C8.67674 19.3328 11.3419 19.3328 14.0067 19.3195C14.3714 19.3142 14.7207 19.1724 14.9849 18.9224C15.249 18.6724 15.4086 18.3326 15.4317 17.9708C15.6017 15.57 15.7614 13.1673 15.9109 10.7627C16.0259 8.94445 16.1026 7.12337 16.2492 5.308C16.2856 4.84797 16.1399 4.7813 15.7413 4.76987C13.586 4.70701 11.4316 4.72415 9.27826 4.71748H9.28209ZM9.99988 3.04689C10.5912 3.04689 11.1815 3.04689 11.7718 3.04689C12.0478 3.04689 12.3037 3.04212 12.2654 2.65829C12.2299 2.30493 12.4111 1.77918 11.8418 1.75632C10.6151 1.70679 9.38367 1.70679 8.157 1.75632C7.58871 1.77918 7.77367 2.30588 7.73438 2.65924C7.69604 3.04022 7.95288 3.04879 8.22888 3.04689C8.81921 3.04689 9.40955 3.04689 9.99988 3.04689Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M6.13672 11.978C6.13672 10.6932 6.13672 9.40643 6.13672 8.12253C6.13672 7.51296 6.44818 7.14246 6.93789 7.14246C7.4276 7.14246 7.73235 7.52344 7.73235 8.13205C7.73235 10.7183 7.73235 13.3045 7.73235 15.8907C7.73235 16.506 7.4343 16.8803 6.95226 16.8936C6.47022 16.907 6.13672 16.5174 6.13672 15.8812C6.13672 14.5801 6.13672 13.2791 6.13672 11.978Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M9.20312 11.9714C9.20312 10.7015 9.20312 9.43155 9.20312 8.16162C9.20312 7.51395 9.50979 7.13678 10.0129 7.1444C10.4998 7.15107 10.8007 7.52538 10.8007 8.1359C10.8007 10.7228 10.8007 13.3093 10.8007 15.8955C10.8007 16.5079 10.4978 16.8832 10.0148 16.8918C9.53183 16.9003 9.20504 16.5108 9.20312 15.8726C9.20312 14.5716 9.20312 13.2725 9.20312 11.9714Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M13.8668 12.0686C13.8668 13.3861 13.8668 14.703 13.8668 16.0193C13.8668 16.4565 13.6626 16.7518 13.241 16.867C12.8931 16.9622 12.618 16.8099 12.4101 16.5327C12.3045 16.3724 12.2553 16.1818 12.2702 15.9908C12.2702 13.341 12.2702 10.6904 12.2702 8.04066C12.2702 7.50443 12.595 7.15202 13.057 7.14631C13.5189 7.14059 13.862 7.50633 13.8639 8.07018C13.8706 9.40266 13.8668 10.7361 13.8668 12.0686Z"
                                                    fill="currentColor" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <tr>
                                <td colspan="5" class="text-center">No products in cart</td>
                            </tr>
                            <?php endif; ?>
                            <tr class="cart-button">
                                <td colspan="3">
                                    <a href="index.php?quanly=Shop" class="outline-pill-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="78" height="19"
                                            viewBox="0 0 78 19" fill="none">
                                            <path
                                                d="M10.4307 8.08519C10.45 8.00902 10.4733 7.93404 10.5005 7.86057C11.0144 6.48086 11.4919 5.08506 11.9655 3.69049C12.0652 3.39928 12.3056 3.10909 12.0209 2.67218C8.41924 5.58385 4.25553 7.51216 0 9.34863C4.377 11.2685 8.53825 13.4042 12.2683 16.3829C12.4931 15.9325 12.2509 15.6395 12.1415 15.3422C11.6228 13.9377 11.1054 12.5293 10.5522 11.141C10.1633 10.1548 10.1204 9.0761 10.4307 8.08519Z"
                                                fill="currentColor" />
                                            <rect x="77.3496" y="10.0935" width="68" height="1" rx="0.5"
                                                transform="rotate(-180 77.3496 10.0935)" fill="currentColor" />
                                        </svg>
                                        Continue Shopping
                                    </a>
                                </td>
                                <td colspan="2">
                                    <div class="text-right">
                                        <a href="javascript:void(0)" class="cart-btn">Update Cart</a>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End-of wishlist -->

<!-- shopping cart card area S t a r t -->
<section class="all-mini-card bottom-padding1">
    <div class="container">
        <div class="row g-4">
            <div class="col-xl-12 col-md-6">
                <div class="mini-card h-100">
                    <div class="header">
                        <h4 class="title">Cart Totals</h4>
                    </div>
                    <div class="body">
                        <div class="price-list">
                            <h4 class="title text-color-primary">Subtotal</h4>
                            <div class="title text-color-tertiary" id="cart-subtotal">
                                $<?php echo number_format($subtotal, 2); ?></div>
                        </div>
                        <div class="divider"></div>
                        <div class="price-list">
                            <h4 class="title text-color-primary">Shipping</h4>
                            <div class="title text-color-tertiary">Free Shipping</div>
                        </div>
                        <div class="price-list">
                            <h4 class="title text-color-primary">Tax</h4>
                            <div class="title text-color-tertiary">$00</div>
                        </div>
                        <div class="price-list">
                            <h4 class="title text-color-primary">Local Delivery</h4>
                            <div class="title text-color-tertiary">$20</div>
                        </div>
                        <div class="divider"></div>
                        <div class="price-list">
                            <h4 class="title text-color-primary font-600">Total</h4>
                            <div class="title text-color-tertiary" id="cart-total">
                                $<?php echo number_format($total, 2); ?></div>
                        </div>
                        <div class="button-section">
                            <form action="controllers/CheckoutController.php" method="POST">
                                <button type="submit" name="checkout" class="cart-btn checkout-btn">Checkout</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<script>
$(document).ready(function() {
    // Function to update price based on quantity change
    function updatePrice(element, newQuantity, productPrice) {
        var newPrice = newQuantity * productPrice;
        element.closest('tr').find('.price-value').text('$' + newPrice.toFixed(2));
    }

    // Click event for increasing the product count
    $(".increase-num-custom").click(function() {
        var $input = $(this).siblings(".num-count");
        var currentValue = parseInt($input.val());
        var newValue = currentValue + 1;
        $input.val(newValue.toString().padStart(2, "0"));

        // Update price based on quantity change
        var productPrice = parseFloat($input.closest('tr').find('.price-value').data('price'));
        updatePrice($input, newValue, productPrice);
    });

    // Click event for decreasing the product count
    $(".decrease-num-custom").click(function() {
        var $input = $(this).siblings(".num-count");
        var currentValue = parseInt($input.val());
        if (currentValue > 1) {
            var newValue = currentValue - 1;
            $input.val(newValue.toString().padStart(2, "0"));

            // Update price based on quantity change
            var productPrice = parseFloat($input.closest('tr').find('.price-value').data('price'));
            updatePrice($input, newValue, productPrice);
        }
    });

    // Ensure minimum quantity is 1 on page load
    $('.num-count').each(function() {
        var $input = $(this);
        var currentValue = parseInt($input.val());
        if (currentValue < 1) {
            $input.val("01");
        }
    });

    // Update price based on quantity on page load
    $('.num-count').each(function() {
        var $input = $(this);
        var productPrice = parseFloat($input.closest('tr').find('.price-value').data('price'));
        var currentValue = parseInt($input.val());
        updatePrice($input, currentValue, productPrice);
    });

    $(".cart-btn").click(function() {
        var cartData = [];
        $(".num-count").each(function() {
            var $input = $(this);
            var productId = $input.data('product-id');
            var quantity = parseInt($input.val(), 10);
            if (quantity > 0) {
                cartData.push({
                    product_id: productId,
                    quantity: quantity
                });
            }
        });

        console.log('Cart Data Sent:', cartData); // Debugging: Kiểm tra dữ liệu gửi lên

        $.ajax({
            url: 'controllers/CartController.php',
            type: 'POST',
            data: {
                cart: cartData
            },
            dataType: 'json',
            success: function(response) {
                console.log(response); // Kiểm tra phản hồi từ server
                if (response.success) {
                    $(".cart-price").each(function() {
                        var productId = $(this).data('product-id');
                        var newPrice = response.updatedPrices[productId];
                        if (newPrice !== undefined) {
                            $(this).text('$' + newPrice.toFixed(2));
                        } else {
                            console.warn('Product ID ' + productId +
                                ' has an undefined price.');
                        }
                    });
                    $("#cart-subtotal").text('$' + response.subtotal.toFixed(2));
                    $("#cart-total").text('$' + response.total.toFixed(2));
                    $("#cart-count").text(response.cartCount);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('Error updating cart.');
            }
        });
    });




    // Click event for "Delete" icon to remove product from cart
    $(".del-icon").click(function() {
        var productId = $(this).data('product-id');
        var $this = $(this);

        // AJAX request to remove product from cart
        $.ajax({
            url: 'controllers/CartController.php',
            type: 'POST',
            data: {
                remove_product_id: productId // Ensure correct key name
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $this.closest('tr').remove(); // Remove product row from UI
                    $("#cart-count").text(response.cartCount); // Update cart count display
                    $(".cart-count").text(response
                        .cartCount); // Update cart count in menu.php
                } else {
                    console.log('Error removing product from cart: ' + response.message);
                    // Optionally show an alert or handle the error here
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Error removing product from cart: ' + textStatus);
                // Optionally show an alert or handle the error here
            }
        });

        return false; // Prevent default action of button (e.g., form submission)
    });

});
</script>