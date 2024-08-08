<?php
// Kiểm tra nếu người dùng đã đăng nhập
$id_account_customer = isset($_SESSION['id_account_customer']) ? $_SESSION['id_account_customer'] : null;

$wishlistProducts = [];

if ($id_account_customer) {
    // Lấy danh sách sản phẩm trong wishlist từ cơ sở dữ liệu dựa vào id_account_customer
    $stmt = $conn->prepare("SELECT tbl_product.*, tbl_wishlist_items.quantity 
                            FROM tbl_wishlist_items 
                            INNER JOIN tbl_product ON tbl_wishlist_items.product_id = tbl_product.id_product 
                            WHERE tbl_wishlist_items.id_account_customer = ?");
    $stmt->bind_param("i", $id_account_customer);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wishlistProducts[] = $row;
        }
    }
    $stmt->close();
} else {
    // Nếu chưa đăng nhập, không có wishlist
    $wishlistProducts = [];
}
?>

<section class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Wishlist</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index.php?quanly" class="single">Home</a>
                            </li>
                            <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                    class="single active">Wishlist</a></li>
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
                                <th>Add to Cart</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($wishlistProducts as $product) : ?>
                            <tr data-product-id="<?php echo $product['id_product']; ?>">
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
                                <td class="cart-qty">
                                    <div class="quantity-section">
                                        <div class="quantity-btn-custom position-relative">
                                            <button class="decrease-num-custom">-</button>
                                            <input type="text" name="qty" value="<?php echo $product['quantity']; ?>"
                                                class="num-count input-qty" readonly>
                                            <button class="increase-num-custom">+</button>
                                        </div>
                                    </div>
                                </td>
                                <td class="cart-price">
                                    <p class="cart-pera text-center price-value"
                                        data-price="<?php echo $product['product_price']; ?>">
                                        $<?php echo $product['product_price']; ?>
                                    </p>
                                </td>
                                <td class="cart-add">
                                    <div class="text-center button-section"
                                        data-product-cart-id="<?php echo $product['id_product']; ?>">
                                        <a href="javascript:void(0)" class="cart-btn">Add to Cart</a>
                                    </div>
                                </td>
                                <td class="action">
                                    <div class="text-center">

                                        <a href="javascript:void(0)" class="del-icon"
                                            onclick="removeFromWishlist(<?php echo $product['id_product']; ?>)">
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
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function removeFromWishlist(productId) {
    $.ajax({
        type: 'POST',
        url: 'controllers/WishlistController.php',
        data: {
            product_id: productId,
            action: 'remove'
        },
        success: function(response) {
            try {
                var parsedResponse = JSON.parse(response);
                if (parsedResponse.message === 'Operation successful') {
                    // Xóa sản phẩm khỏi giao diện wishlist mà không cần reload trang
                    var wishlistItemRow = document.querySelector(`[data-product-id="${productId}"]`)
                        .closest('tr');
                    if (wishlistItemRow) {
                        wishlistItemRow.remove();
                    }
                    // Cập nhật số lượng wishlist trên giao diện menu
                    var wishlistCountElement = document.querySelector('.wishlist-count');
                    if (wishlistCountElement) {
                        wishlistCountElement.textContent = parsedResponse.wishlistCount;
                    }
                } else {
                    alert('Đã xảy ra lỗi khi xóa sản phẩm khỏi wishlist: ' + parsedResponse.message);
                }
            } catch (error) {
                console.error('Invalid JSON response from server');
            }
        },
        error: function() {
            alert('Đã xảy ra lỗi khi gửi yêu cầu xóa sản phẩm.');
        }
    });
}
</script>



<script>
// Cập nhật mã cho giỏ hàng
$(document).ready(function() {
    $('.cart-btn').off('click').on('click', function() {
        var productId = $(this).closest('.button-section').data('product-cart-id');
        var quantity = $(this).closest('td').siblings('.cart-qty').find('.input-qty').val();

        $.ajax({
            type: 'POST',
            url: 'controllers/CartController.php',
            data: {
                product_id: productId,
                quantity: quantity,
                action: 'add'
            },
            dataType: 'json',
            success: function(response) {
                if (response.message === 'Operation successful') {
                    // Cập nhật hiển thị số lượng giỏ hàng mà không cần tải lại trang
                    $('.cart-count').text(response.cartCount);
                    console.log('Sản phẩm được thêm thành công');
                } else {
                    // Xử lý lỗi
                    alert('Đã xảy ra lỗi khi cập nhật giỏ hàng: ' + response.message);
                }
            }
        });
    });

    // Increase quantity
    $('.increase-num-custom').on('click', function() {
        var $input = $(this).siblings('.input-qty');
        var value = parseInt($input.val());
        $input.val(value + 1);
    });

    // Decrease quantity
    $('.decrease-num-custom').on('click', function() {
        var $input = $(this).siblings('.input-qty');
        var value = parseInt($input.val());
        if (value > 1) {
            $input.val(value - 1);
        }
    });
});
</script>