<?php

$isLoggedIn = isset($_SESSION['id_account_customer']); // Giả sử session user_id được thiết lập khi người dùng đăng nhập
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Xóa thông báo sau khi đã hiển thị
}
?>
<!-- Breadcrumbs S t a r t -->
<section class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Checout</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index.php?quanly" class="single">Home</a>
                            </li>
                            <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                    class="single active">Checout</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End-of Breadcrumbs-->
<!-- checkout area S t a r t -->
<div class="checkout-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="alert alert-primary d-flex gap-15 flex-wrap align-items-center mb-0" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="18" viewBox="0 0 9 18" fill="none">
                        <path
                            d="M3.8882 5.84839C6.05114 5.84839 7.0777 6.71918 7.18585 8.45035C7.22745 9.11926 7.08519 9.77536 6.87056 10.4162C6.45461 11.6595 6.00871 12.8996 5.79574 14.1926C5.75196 14.4693 5.73138 14.749 5.73418 15.0289C5.73418 15.5609 5.90056 15.7003 6.46376 15.7203C6.91465 15.7363 7.34474 15.6402 7.77068 15.5168C7.95952 15.4623 8.15086 15.3951 8.31807 15.5473C8.50192 15.7139 8.40126 15.9118 8.37547 16.108C8.27148 16.8554 7.84139 17.2616 7.08269 17.4619C6.18757 17.6982 5.31907 18.0154 4.3707 17.9994C3.46056 17.9896 2.58167 17.6784 1.88165 17.1182C1.16871 16.5574 1.10715 15.7563 1.16788 14.9593C1.3118 13.0671 1.98481 11.2902 2.50974 9.48136C2.58603 9.25256 2.62723 9.01425 2.63203 8.77399C2.62371 8.34861 2.454 8.17237 2.0081 8.13712C1.5622 8.10187 1.12629 8.18679 0.697026 8.30295C0.100553 8.46317 -0.0358789 8.30295 0.0073799 7.72776C0.064781 6.9547 0.472412 6.5894 1.21696 6.38993C2.19361 6.13438 3.16112 5.87322 3.8882 5.84839Z"
                            fill="#AD8C5C" />
                        <path
                            d="M3.59592 2.346C3.59197 2.0357 3.65277 1.72779 3.77473 1.44054C3.89668 1.15329 4.0773 0.892549 4.30587 0.673787C4.53444 0.455025 4.80631 0.282696 5.10534 0.167021C5.40438 0.051347 5.7245 -0.00531641 6.0467 0.000392182C6.37097 -0.00504508 6.69311 0.0518025 6.9943 0.167614C7.2955 0.283425 7.5697 0.455877 7.8009 0.674894C8.0321 0.893912 8.21565 1.1551 8.34084 1.44321C8.46602 1.73131 8.53032 2.04055 8.52999 2.35286C8.52966 2.66516 8.4647 2.97427 8.3389 3.26213C8.21311 3.54999 8.029 3.81082 7.79734 4.02938C7.56568 4.24794 7.29111 4.41985 6.98967 4.53507C6.68823 4.65029 6.36597 4.7065 6.04171 4.70042C5.71936 4.70473 5.39938 4.64678 5.10067 4.53C4.80197 4.41322 4.5306 4.23996 4.3026 4.02048C4.0746 3.801 3.8946 3.53974 3.77322 3.25214C3.65184 2.96453 3.59156 2.65642 3.59592 2.346Z"
                            fill="#AD8C5C" />
                    </svg>
                    <p class="pera">
                        Returning customer? <a href="index.php?quanly=Login">Click here to login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End-of checkout-->

<section class="billing-area bottom-padding">
    <div class="container">
        <form action="controllers/Place_order.php" method="post">
            <div class="row g-4">
                <div class="col-xxl-6 col-xl-6">
                    <div class="billing-box">
                        <h4 class="title">Billing Details</h4>

                        <div class="row g-4">
                            <div class="col-sm-6">
                                <input required class="form-control custom-form-control" name="first_name" type="text"
                                    placeholder="First Name*">
                            </div>
                            <div class="col-sm-6">
                                <input required class="form-control custom-form-control" name="last_name" type="text"
                                    placeholder="Last Name*">
                            </div>
                            <div class="col-sm-6">
                                <input required class="form-control custom-form-control" name="email" type="text"
                                    placeholder="Email Address*">
                            </div>
                            <div class="col-sm-6">
                                <input required class="form-control custom-form-control" name="phone_customer"
                                    type="text" placeholder="Phone Number*">
                            </div>
                            <!-- Form HTML -->
                            <div class="col-6">
                                <div class="form-group floating-group floating-diff">
                                    <label class="floating-label">Tỉnh/Thành phố*</label>
                                    <select name="province_id"
                                        class="form-control custom-form-control floating-control">
                                        <option value="">Tỉnh/Thành phố*</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group floating-group floating-diff">
                                    <label class="floating-label">Quận/Huyện*</label>
                                    <select name="district_id"
                                        class="form-control custom-form-control floating-control">
                                        <option value="">Quận/Huyện*</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="form-group floating-group floating-diff">
                                    <label class="floating-label">Xã phường thị trấn*</label>
                                    <select name="town_id" class="form-control custom-form-control floating-control">
                                        <option value="">Xã phường thị trấn*</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <input name="postcode" class="form-control custom-form-control" type="text"
                                    placeholder="Postcode / ZIP*">
                            </div>
                            <div class="col-12">
                                <input name="address" class="form-control custom-form-control" type="text"
                                    placeholder="Địa chỉ*">
                            </div>
                        </div>
                        <div class="divider"></div>
                        <div class="cart-button d-flex justify-content-between flex-wrap gap-16">
                            <a href="index.php?quanly=Shopping Cart" class="outline-pill-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="78" height="19" viewBox="0 0 78 19"
                                    fill="none">
                                    <path
                                        d="M10.4307 8.08519C10.45 8.00902 10.4733 7.93404 10.5005 7.86057C11.0144 6.48086 11.4919 5.08506 11.9655 3.69049C12.0652 3.39928 12.3056 3.10909 12.0209 2.67218C8.41924 5.58385 4.25553 7.51216 0 9.34863C4.377 11.2685 8.53825 13.4042 12.2683 16.3829C12.4931 15.9325 12.2509 15.6395 12.1415 15.3422C11.6228 13.9377 11.1054 12.5293 10.5522 11.141C10.1633 10.1548 10.1204 9.0761 10.4307 8.08519Z"
                                        fill="currentColor" />
                                    <rect x="77.3496" y="10.0935" width="68" height="1" rx="0.5"
                                        transform="rotate(-180 77.3496 10.0935)" fill="currentColor" />
                                </svg>
                                Return to cart
                            </a>
                            <a href="javascript:void(0)" class=" cart-btn">Continue to shipping</a>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6">
                    <div class="billing-box">
                        <h4 class="title mb-22">Order Summary</h4>
                        <div class="table-responsive">
                            <table class="table summary-table">
                                <thead class="thead">
                                    <tr>
                                        <th colspan="2">Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody class="tbody">
                                    <?php
                                    // Check if checkout products are set in session
                                    if (isset($_SESSION['checkout_products'])) {
                                        $checkoutProducts = $_SESSION['checkout_products'];

                                        // Initialize variables
                                        $subtotal = 0;
                                        $tax = 0;
                                        $total = 0;

                                        // Loop through each product and display in table rows
                                        foreach ($checkoutProducts as $product) {
                                            echo '<tr>';
                                            echo '<td class="product-name">';
                                            echo '<p class="pera text-color-tertiary mr-30">' . $product['product_name'] . '</p>';
                                            echo '</td>';
                                            echo '<td class="product-qty">';
                                            echo '<p class="pera text-color-tertiary mr-30">' . $product['quantity'] . '</p>';
                                            echo '</td>';
                                            echo '<td>';
                                            echo '<p class="pera">$' . ($product['product_price'] * $product['quantity']) . '</p>';
                                            echo '</td>';
                                            echo '</tr>';

                                            // Calculate subtotal
                                            $subtotal += $product['product_price'] * $product['quantity'];
                                            echo '<input type="hidden" name="products[]" value="' . htmlspecialchars($product['id_product']) . '">';
                                            echo '<input type="hidden" name="products[]" value="' . htmlspecialchars($product['product_name']) . '">';
                                            echo '<input type="hidden" name="products[]" value="' . $product['quantity'] . '">';
                                            echo '<input type="hidden" name="products[]" value="' . ($product['product_price'] * $product['quantity']) . '">';
                                        }

                                        // Example tax calculation
                                        $tax = 0.1 * $subtotal; // Adjust as needed

                                        // Example total calculation including shipping and local delivery
                                        $shippingFee = 0; // Example, adjust as needed
                                        $localDeliveryFee = 20; // Example, adjust as needed
                                        $total = $subtotal + $shippingFee + $tax + $localDeliveryFee;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="3">
                                            <div class="divider"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="pera text-color-primary">Subtotal</p>
                                        </td>
                                        <td>
                                            <?php echo isset($subtotal) ? '<p class="pera text-color-primary">$' . number_format($subtotal, 2) . '</p>' : '<p class="pera text-color-primary">$0.00</p>'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="pera text-color-primary">Shipping</p>
                                        </td>
                                        <td>
                                            <p class="pera">Free Shipping</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="pera text-color-primary">Tax</p>
                                        </td>
                                        <td>
                                            <?php echo isset($tax) ? '<p class="pera">$' . number_format($tax, 2) . '</p>' : '<p class="pera">$0.00</p>'; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="pera text-color-primary">Local Delivery</p>
                                        </td>
                                        <td>
                                            <p class="pera">$20</p> <!-- Example, adjust as needed -->
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="divider"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p class="pera font-700 text-color-primary">Total</p>
                                        </td>
                                        <td id="totalAmount">
                                            <?php echo isset($total) ? '<p class="pera font-700 text-color-primary2">$' . number_format($total, 2) . '</p>' : '<p class="pera font-700 text-color-primary2">$0.00</p>'; ?>
                                            <input type="hidden" name="total"
                                                value="<?php echo isset($total) ? $total : '0.00'; ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="payment-btn">
                            <div class="payment-wrapper payment-wrapper-blank">
                                <div class="custom-radio-check">
                                    <input class="form-check-input" name="payment_method" type="radio"
                                        id="flexRadioDefault3" value="Cash on Delivery">
                                    <label class="form-check-label" for="flexRadioDefault3">
                                        Cash on Delivery
                                        <span class="custom-radio"></span>
                                    </label>
                                </div>
                                <div class="custom-radio-check">
                                    <input class="form-check-input" name="payment_method" type="radio"
                                        id="flexRadioDefault4" value="Credit/Debit Cards or Paypal">
                                    <label class="form-check-label" for="flexRadioDefault4">
                                        Credit/Debit Cards or Paypal
                                        <span class="custom-radio"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-18 payment-done">
                            <button type="submit" id="placeOrderBtn" class="cart-btn">Place Order Now</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
$(document).ready(function() {
    // Tải danh sách tỉnh/thành phố ban đầu khi tải trang
    $.ajax({
        url: 'controllers/get_provinces.php',
        type: 'GET',
        success: function(response) {
            if (response.length > 0) {
                $.each(response, function(index, province) {
                    $('select[name="province_id"]').append('<option value="' + province
                        .id_provinces + '">' + province.name_provinces + '</option>');
                });
            } else {
                $('select[name="province_id"]').append(
                    '<option value="">No provinces found</option>');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching provinces: ' + error);
        }
    });

    // Sự kiện khi thay đổi tỉnh/thành phố
    $('select[name="province_id"]').change(function() {
        var provinceId = $(this).val();
        if (provinceId !== '') {
            // Gọi Ajax để lấy danh sách quận/huyện
            $.ajax({
                url: 'controllers/get_districts.php',
                type: 'GET',
                data: {
                    province_id: provinceId
                },
                success: function(response) {
                    // Xóa các option cũ trong select quận/huyện
                    $('select[name="district_id"]').empty();
                    $('select[name="district_id"]').append(
                        '<option value="">Quận/Huyện*</option>');
                    // Thêm option mới vào select quận/huyện
                    if (response.length > 0) {
                        $.each(response, function(index, district) {
                            $('select[name="district_id"]').append(
                                '<option value="' +
                                district.id_districts + '">' + district
                                .name_districts + '</option>');
                        });
                    } else {
                        $('select[name="district_id"]').append(
                            '<option value="">No districts found</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching districts: ' + error);
                }
            });
        } else {
            // Nếu không chọn tỉnh/thành phố, xóa toàn bộ option của select quận/huyện
            $('select[name="district_id"]').empty();
            $('select[name="district_id"]').append('<option value="">Quận/Huyện*</option>');
        }
    });

    // Sự kiện khi thay đổi quận/huyện
    $('select[name="district_id"]').change(function() {
        var districtId = $(this).val();
        if (districtId !== '') {
            // Gọi Ajax để lấy danh sách xã/phường/thị trấn
            $.ajax({
                url: 'controllers/get_towns.php',
                type: 'GET',
                data: {
                    district_id: districtId
                },
                success: function(response) {
                    // Xóa các option cũ trong select xã/phường/thị trấn
                    $('select[name="town_id"]').empty();
                    $('select[name="town_id"]').append(
                        '<option value="">Xã phường thị trấn*</option>');
                    // Thêm option mới vào select xã/phường/thị trấn
                    if (response.length > 0) {
                        $.each(response, function(index, town) {
                            $('select[name="town_id"]').append('<option value="' +
                                town
                                .id_town + '">' + town.name_town + '</option>');
                        });
                    } else {
                        $('select[name="town_id"]').append(
                            '<option value="">No towns found</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching towns: ' + error);
                }
            });
        } else {
            // Nếu không chọn quận/huyện, xóa toàn bộ option của select xã/phường/thị trấn
            $('select[name="town_id"]').empty();
            $('select[name="town_id"]').append('<option value="">Xã phường thị trấn*</option>');
        }
    });
});
</script>
<!-- JavaScript để xử lý sự kiện khi nhấn nút "Place Order" -->
<script>
// Xử lý response từ server
$.ajax({
    // Các thiết lập AJAX
    success: function(response) {
        if (!response.success) {
            // Hiển thị thông báo lỗi trên trang hoặc modal
            $('#error-message').html(response.message);

        }
    }
});
</script>