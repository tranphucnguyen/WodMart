<?php
// Lấy danh sách sản phẩm trong wishlist và cart từ cơ sở dữ liệu nếu người dùng đã đăng nhập
if ($id_account_customer) {
    // Lấy danh sách sản phẩm trong wishlist từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tbl_wishlist_items WHERE id_account_customer = ?");
    $stmt->bind_param("i", $id_account_customer);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $wishlistCount = $row['count'];
    $stmt->close();

    // Lấy danh sách sản phẩm trong cart từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tbl_cart_items WHERE id_account_customer = ?");
    $stmt->bind_param("i", $id_account_customer);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cartCount = $row['count'];
    $stmt->close();
} else {
    // Nếu chưa đăng nhập, không có wishlist và cart
    $wishlistCount = 0;
    $cartCount = 0;
}
$products = [];
// Truy vấn để lấy 8 sản phẩm đầu tiên
$sql = "SELECT * FROM tbl_product WHERE product_status = 1 LIMIT 8";
$result = $conn->query($sql);
$sql_2 = "SELECT * FROM tbl_product WHERE product_status = 1 LIMIT 2";
$result2 = $conn->query($sql_2);
$sql_3 = "SELECT * FROM tbl_product WHERE product_status = 1 LIMIT 4";
$result3 = $conn->query($sql_3);
?>
<style>
.product-title strong {
    font-size: 18px;
    /* Bỏ đi font-size được thiết lập trước đó */
    /* Thêm các thuộc tính khác tại đây nếu cần */
}
</style>
<section class="goal-area position-relative">
    <div class="container">
        <div class="row g-4">
            <div class="col-xxl-3 col-md-4 col-sm-6">
                <div class="goal-card wow fadeInUp" data-wow-delay="0.0s">
                    <div class="circle-icon">
                        <img src="assets/images/goal/icon-1.png" alt="img">
                    </div>
                    <a href="javascript:void(0)">
                        <h4 class="title line-clamp-1 text-color-primary">Original Product</h4>
                        <p class="pera text-color-tertiary line-clamp-2">There are many variations of passages
                            of our
                            Lorem Ipsum available but the.</p>
                    </a>
                </div>
            </div>
            <div class="col-xxl-3 col-md-4 col-sm-6">
                <div class="goal-card wow fadeInUp" data-wow-delay="0.0s">
                    <div class="circle-icon">
                        <img src="assets/images/goal/icon-2.png" alt="img">
                    </div>
                    <a href="javascript:void(0)">
                        <h4 class="title line-clamp-1 text-color-primary">Satisfaction Guarantee</h4>
                        <p class="pera text-color-tertiary line-clamp-2">There are many variations of passages
                            of our
                            Lorem Ipsum available but the.</p>
                    </a>
                </div>
            </div>
            <div class="col-xxl-3 col-md-4 col-sm-6">
                <div class="goal-card wow fadeInUp" data-wow-delay="0.1s">
                    <div class="circle-icon">
                        <img src="assets/images/goal/icon-3.png" alt="img">
                    </div>
                    <a href="javascript:void(0)">
                        <h4 class="title line-clamp-1 text-color-primary">New Arrival Everyday</h4>
                        <p class="pera text-color-tertiary line-clamp-2">There are many variations of passages
                            of our
                            Lorem Ipsum available but the.</p>
                    </a>
                </div>
            </div>
            <div class="col-xxl-3 col-md-4 col-sm-6">
                <div class="goal-card wow fadeInUp" data-wow-delay="0.2s">
                    <div class="circle-icon">
                        <img src="assets/images/goal/icon-4.png" alt="img">
                    </div>
                    <a href="javascript:void(0)">
                        <h4 class="title line-clamp-1 text-color-primary">Fast & Free Shipping</h4>
                        <p class="pera text-color-tertiary line-clamp-2">There are many variations of passages
                            of our
                            Lorem Ipsum available but the.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="shape routedOne">
        <img src="assets/images/goal/shape.png" alt="img">
    </div>
</section>
<!-- End-of goal-->

<!-- Feature area S t a r t -->
<section class="feature-area feature-bg position-relative">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h4 class="title">Featured Products</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="swiper featureSwiper-active">
                    <div class="swiper-wrapper">
                        <?php
                        if ($result->num_rows > 0) {
                            // Lặp qua các sản phẩm và hiển thị chúng
                            while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="swiper-slide">
                            <div class="product-card feature-card h-calc">
                                <div class="top-card">
                                    <div class="price-section">
                                        <h4 class="price discounted"><?php echo $row['product_price'] ?></h4>
                                        <h4 class="price text-color-primary"><?php echo $row['product_price_sales'] ?>
                                        </h4>
                                    </div>
                                    <button class="wishlist-icon" data-product-id="<?php echo $row['id_product']; ?>">
                                        <img src="assets/images/icon/wish-icon-2.png" alt="img">
                                    </button>
                                </div>
                                <div class="product-img-card feature-img-card">
                                    <a href="index.php?quanly=Shop_details&id=<?php echo $row['id_product']; ?>"
                                        class="zoomImg">
                                        <img style="width:166px; height:166px"
                                            src="admin/modules/quanlysanpham/images/<?php echo $row['product_img']; ?>"
                                            alt="img">
                                    </a>
                                    <div class="discount-badge">
                                        <span
                                            class="percentage"><?php echo 100 - ($row['product_price_sales'] * 100 / $row['product_price']) ?>%</span>
                                    </div>
                                    <div class="special-icon">
                                        <button class="icon-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="19"
                                                viewBox="0 0 21 19" fill="none">
                                                <path
                                                    d="M0.978546 2.56816V5.13649H1.65442H2.33029V3.71701V2.292L5.45619 5.35743L8.58209 8.42285L9.07209 7.9368L9.56773 7.45628L6.44183 4.39085L3.31593 1.32542H4.76905H6.21654V0.662629V-0.000165939H3.59754H0.978546V2.56816Z"
                                                    fill="#111111" />
                                                <path
                                                    d="M15.1167 0.662629V1.32542H16.5642H18.0173L14.8914 4.39085L11.7655 7.45628L12.2611 7.9368L12.7511 8.42285L15.877 5.35743L19.0029 2.292V3.71701V5.13649H19.6788H20.3547V2.56816V-0.000165939H17.7357H15.1167V0.662629Z"
                                                    fill="#111111" />
                                                <path
                                                    d="M5.43926 13.6535L2.33026 16.7078V15.2828V13.8633H1.65439H0.978516V16.4317V19H3.59751H6.21651V18.3372V17.6744H4.76902H3.3159L6.4418 14.609L9.5677 11.5436L9.08896 11.0741C8.82988 10.8145 8.59895 10.6046 8.58206 10.6046C8.56516 10.6046 7.15146 11.9799 5.43926 13.6535Z"
                                                    fill="#111111" />
                                                <path
                                                    d="M12.2442 11.0741L11.7655 11.5436L14.8914 14.609L18.0173 17.6744H16.5641H15.1167V18.3372V19H17.7356H20.3546V16.4317V13.8633H19.6788H19.0029V15.2828V16.7078L15.8883 13.6535C14.1817 11.9799 12.768 10.6046 12.7511 10.6046C12.7342 10.6046 12.5033 10.8145 12.2442 11.0741Z"
                                                    fill="#111111" />
                                            </svg>
                                        </button>
                                        <div class="divider"></div>
                                        <button class="icon-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="25"
                                                viewBox="0 0 22 25" fill="none">
                                                <path
                                                    d="M9.4304 0.827005C9.4304 1.27952 9.41567 1.65419 9.40094 1.65419C9.38622 1.65419 9.14565 1.69798 8.87563 1.75637C4.21162 2.6906 0.73079 6.34481 0.0827378 10.9868C-0.0694564 12.0475 -0.00563302 13.663 0.225113 14.7432C0.809342 17.5069 2.62094 20.1004 5.01677 21.6185L5.29661 21.7937L5.98885 21.2779C6.36688 20.9957 6.68109 20.7524 6.68109 20.733C6.68109 20.7184 6.55835 20.6405 6.41107 20.5627C5.65992 20.1734 4.68293 19.3949 4.02015 18.6601C2.76332 17.2636 1.95816 15.5606 1.69796 13.77C1.60468 13.1083 1.60468 11.7945 1.69796 11.1668C1.89925 9.83845 2.37056 8.58308 3.07753 7.48341C3.96123 6.11612 5.30643 4.91914 6.77928 4.1844C7.52552 3.8146 8.56142 3.46426 9.2733 3.33775L9.4304 3.30856V3.98977C9.4304 4.36444 9.44022 4.67098 9.45495 4.67098C9.50404 4.67098 12.5725 2.36946 12.5725 2.3354C12.5725 2.30134 9.50404 -0.000179291 9.45495 -0.000179291C9.44022 -0.000179291 9.4304 0.369621 9.4304 0.827005Z"
                                                    fill="#111111" />
                                                <path
                                                    d="M16.0134 3.6345C15.6354 3.91672 15.331 4.16487 15.3457 4.18434C15.3604 4.20867 15.5077 4.30112 15.6795 4.39357C17.118 5.20129 18.4583 6.56371 19.288 8.07697C19.7888 8.98687 20.211 10.3104 20.3288 11.3419C20.427 12.1545 20.3681 13.551 20.211 14.2906C19.5335 17.4728 17.2997 20.0371 14.2165 21.1757C13.8287 21.3168 12.778 21.6039 12.6406 21.6039C12.5866 21.6039 12.5718 21.4822 12.5718 20.9227C12.5718 20.548 12.562 20.2414 12.5473 20.2414C12.4982 20.2414 9.42976 22.543 9.42976 22.577C9.42976 22.6111 12.4982 24.9126 12.5473 24.9126C12.562 24.9126 12.5718 24.5428 12.5718 24.0854V23.2631L12.7584 23.2339C13.215 23.1609 14.5062 22.8154 14.9284 22.65C18.7578 21.1659 21.3795 17.8767 21.9244 13.8673C22.0668 12.8357 22.003 11.2203 21.7771 10.1693C21.1929 7.40549 19.3813 4.81202 16.9855 3.2939L16.7056 3.11873L16.0134 3.6345Z"
                                                    fill="#111111" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <a href="index.php?quanly=Shop_details&id=<?php echo $row['id_product']; ?>">
                                    <h4 style="font-size: 10px;" class="product-title line-clamp-1">
                                        <p><strong><?php echo $row['product_name']; ?></strong></p>
                                </a>
                                <div class="product-review">
                                    <div class="product-ratting">
                                        <i class="ri-star-s-fill"></i>
                                        <i class="ri-star-s-fill"></i>
                                        <i class="ri-star-s-fill"></i>
                                        <i class="ri-star-s-fill"></i>
                                        <i class="ri-star-s-fill"></i>
                                    </div>
                                    <p class="count-ratting">(52)</p>
                                </div>
                                <div class="cart-card feature-cart-card d-none d-md-block">
                                    <a href="index.php?quanly=Shop_details&id=<?php echo $row['id_product']; ?>">
                                        <h4 class="product-title line-clamp-1">
                                            <p><strong><?php echo $row['product_name']; ?></strong></p>
                                        </h4>
                                    </a>
                                    <div class="product-review">
                                        <div class="product-ratting">
                                            <i class="ri-star-s-fill"></i>
                                            <i class="ri-star-s-fill"></i>
                                            <i class="ri-star-s-fill"></i>
                                            <i class="ri-star-s-fill"></i>
                                            <i class="ri-star-s-fill"></i>
                                        </div>
                                        <p class="count-ratting">(31)</p>
                                    </div>
                                    <div class="button-section"
                                        data-product-cart-id="<?php echo $row['id_product']; ?>">
                                        <a href="javascript:void(0)" class="cart-btn">Add to Cart</a>
                                        <div class="fill-pill-btn qty-btn">
                                            <div class="qty-container featury-qty-container">
                                                <div class="qty-btn-minus qty-btn mr-1">
                                                    <i class="ri-subtract-fill"></i>
                                                </div>
                                                <input type="text" name="qty" value="1" class="input-qty input-rounded">
                                                <div class="qty-btn-plus qty-btn ml-1">
                                                    <i class="ri-add-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- <div class="button-section d-block d-md-none">
                                    <a href="javascript:void(0)" class=" cart-btn">Add to Cart</a>
                                </div> -->
                            </div>
                        </div>
                        <?php

                            }
                        } else {
                            echo "<p>No products available.</p>";
                        }
                        ?>
                    </div>
                    <div class="swiper-button-next swiper-common-btn"><i class="ri-arrow-right-s-line"></i>
                    </div>
                    <div class="swiper-button-prev swiper-common-btn"><i class="ri-arrow-left-s-line"></i></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End-of feature-->

<!-- Categories area S t a r t -->
<section class="category-area section-padding2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-with-button wow fadeInLeft" data-wow-delay="0.0s">
                    <div class="section-title position-relative">
                        <h4 class="title">Choose The <span class="outline-text">Categories</span>
                            That You Want</h4>
                        <div class="shape routedOne">
                            <img src="assets/images/icon/title-shape.png" alt="img">
                        </div>
                    </div>
                    <div class="text-center d-block">
                        <a href="index.php?quanly=Shop" class="outline-pill-btn ">
                            See All Categories
                            <svg xmlns="http://www.w3.org/2000/svg" width="78" height="19" viewBox="0 0 78 19"
                                fill="none">
                                <path
                                    d="M66.918 10.9147C66.8987 10.9909 66.8754 11.0659 66.8482 11.1394C66.3343 12.5191 65.8568 13.9149 65.3832 15.3094C65.2835 15.6007 65.0431 15.8908 65.3278 16.3278C68.9295 13.4161 73.0932 11.4878 77.3487 9.65131C72.9717 7.73141 68.8104 5.59576 65.0804 2.61703C64.8556 3.06744 65.0978 3.36045 65.2072 3.6577C65.7259 5.06223 66.2433 6.47061 66.7965 7.85894C67.1854 8.84516 67.2283 9.92384 66.918 10.9147Z"
                                    fill="currentColor" />
                                <rect y="8.90649" width="68" height="1" rx="0.5" fill="currentColor" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mb-24">
            <div class="col-xl-6">
                <div class="category-card h-calc gallery-one wow fadeInUp" data-wow-delay="0.0s">
                    <a href="shop.html" class="zoomImg">
                        <img src="assets/images/category/category-1.png" alt="img">
                    </a>
                    <div class="collection-card lg">
                        <a href="shop.html">
                            <h4 class="title text-color-primary line-clamp-1">Exclusive Papillon XL Beds</h4>
                            <p class="pera text-color-tertiary">35 Categories</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="row g-4">
                    <div class="col-xl-12 col-lg-6">
                        <div class="category-card h-calc gallery-two wow fadeInUp" data-wow-delay="0.1s">
                            <a href="shop.html" class="zoomImg">
                                <img src="assets/images/category/category-2.png" alt="img">
                            </a>
                            <div class="collection-card">
                                <a href="shop.html">
                                    <h4 class="title text-color-primary">Contemporary Sofa</h4>
                                    <p class="pera text-color-tertiary">48 Categories</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-6">
                        <div class="category-card h-calc gallery-two wow fadeInUp" data-wow-delay="0.2s">
                            <a href="shop.html" class="zoomImg">
                                <img src="assets/images/category/category-3.png" alt="img">
                            </a>
                            <div class="collection-card">
                                <a href="shop.html">
                                    <h4 class="title text-color-primary">Vocan Center Table</h4>
                                    <p class="pera text-color-tertiary">24 Categories</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-xl-4 col-md-6">
                <div class="category-card h-calc gallery-three wow fadeInUp" data-wow-delay="0.0s">
                    <a href="shop.html" class="zoomImg">
                        <img src="assets/images/category/category-4.png" alt="img">
                    </a>
                    <div class="collection-card sm">
                        <a href="shop.html">
                            <h4 class="title text-color-primary line-clamp-1">Glass Coffee Table</h4>
                            <p class="pera text-color-tertiary">15 Categories</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="category-card h-calc gallery-three wow fadeInUp" data-wow-delay="0.1s">
                    <a href="shop.html" class="zoomImg">
                        <img src="assets/images/category/category-5.png" alt="img">
                    </a>
                    <div class="collection-card sm">
                        <a href="shop.html">
                            <h4 class="title text-color-primary line-clamp-1">Mambo Lamp Light</h4>
                            <p class="pera text-color-tertiary">22 Categories</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="category-card h-calc gallery-three wow fadeInUp" data-wow-delay="0.2s">
                    <a href="shop.html" class="zoomImg">
                        <img src="assets/images/category/category-6.png" alt="img">
                    </a>
                    <div class="collection-card sm">
                        <a href="shop.html">
                            <h4 class="title text-color-primary line-clamp-1">Luxury Chat Chair</h4>
                            <p class="pera text-color-tertiary">32 Categories</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- End-of categories-->

<!-- Best product area S t a r t -->
<section class="best-product-area">
    <div class="container">
        <div class="row g-4 mb-24">
            <div class="col-xxl-6">
                <div class="section-with-button">
                    <div class="section-title position-relative  wow fadeInUp" data-wow-delay="0.0s">
                        <h4 class="title">Our Best All Products <span class="outline-text">Collections</span>
                        </h4>
                        <div class="shape routedOne">
                            <img src="assets/images/icon/title-shape.png" alt="img">
                        </div>
                    </div>
                    <div class="all-button">
                        <a href="shop.html" class="outline-pill-btn mb-15  wow fadeInUp" data-wow-delay="0.0s">
                            See All Products
                            <svg xmlns="http://www.w3.org/2000/svg" width="49" height="19" viewBox="0 0 49 19"
                                fill="none">
                                <path
                                    d="M38.643 10.9148C38.6239 10.991 38.6007 11.066 38.5737 11.1394C38.0634 12.5191 37.5893 13.9149 37.119 15.3095C37.02 15.6007 36.7814 15.8909 37.064 16.3278C40.6403 13.4161 44.7745 11.4878 49 9.65137C44.6539 7.73147 40.5221 5.59582 36.8184 2.61709C36.5952 3.06751 36.8357 3.36051 36.9443 3.65776C37.4593 5.06229 37.9731 6.47067 38.5224 7.859C38.9085 8.84522 38.9511 9.92391 38.643 10.9148Z"
                                    fill="currentColor" />
                                <rect y="9" width="39.7174" height="1" rx="0.5" fill="currentColor" />
                            </svg>
                        </a>
                        <a href="shop.html" class="outline-pill-btn mb-15  wow fadeInUp" data-wow-delay="0.1s">
                            Side Table
                            <svg xmlns="http://www.w3.org/2000/svg" width="49" height="19" viewBox="0 0 49 19"
                                fill="none">
                                <path
                                    d="M38.643 10.9148C38.6239 10.991 38.6007 11.066 38.5737 11.1394C38.0634 12.5191 37.5893 13.9149 37.119 15.3095C37.02 15.6007 36.7814 15.8909 37.064 16.3278C40.6403 13.4161 44.7745 11.4878 49 9.65137C44.6539 7.73147 40.5221 5.59582 36.8184 2.61709C36.5952 3.06751 36.8357 3.36051 36.9443 3.65776C37.4593 5.06229 37.9731 6.47067 38.5224 7.859C38.9085 8.84522 38.9511 9.92391 38.643 10.9148Z"
                                    fill="currentColor" />
                                <rect y="9" width="39.7174" height="1" rx="0.5" fill="currentColor" />
                            </svg>
                        </a>
                        <a href="shop.html" class="outline-pill-btn mb-15  wow fadeInUp" data-wow-delay="0.2s">
                            Wall Light
                            <svg xmlns="http://www.w3.org/2000/svg" width="49" height="19" viewBox="0 0 49 19"
                                fill="none">
                                <path
                                    d="M38.643 10.9148C38.6239 10.991 38.6007 11.066 38.5737 11.1394C38.0634 12.5191 37.5893 13.9149 37.119 15.3095C37.02 15.6007 36.7814 15.8909 37.064 16.3278C40.6403 13.4161 44.7745 11.4878 49 9.65137C44.6539 7.73147 40.5221 5.59582 36.8184 2.61709C36.5952 3.06751 36.8357 3.36051 36.9443 3.65776C37.4593 5.06229 37.9731 6.47067 38.5224 7.859C38.9085 8.84522 38.9511 9.92391 38.643 10.9148Z"
                                    fill="currentColor" />
                                <rect y="9" width="39.7174" height="1" rx="0.5" fill="currentColor" />
                            </svg>
                        </a>
                        <a href="shop.html" class="outline-pill-btn   wow fadeInUp" data-wow-delay="0.4s">
                            Sofa Seat
                            <svg xmlns="http://www.w3.org/2000/svg" width="49" height="19" viewBox="0 0 49 19"
                                fill="none">
                                <path
                                    d="M38.643 10.9148C38.6239 10.991 38.6007 11.066 38.5737 11.1394C38.0634 12.5191 37.5893 13.9149 37.119 15.3095C37.02 15.6007 36.7814 15.8909 37.064 16.3278C40.6403 13.4161 44.7745 11.4878 49 9.65137C44.6539 7.73147 40.5221 5.59582 36.8184 2.61709C36.5952 3.06751 36.8357 3.36051 36.9443 3.65776C37.4593 5.06229 37.9731 6.47067 38.5224 7.859C38.9085 8.84522 38.9511 9.92391 38.643 10.9148Z"
                                    fill="currentColor" />
                                <rect y="9" width="39.7174" height="1" rx="0.5" fill="currentColor" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-6">
                <div class="row g-4">
                    <?php
                    if ($result2->num_rows > 0) {
                        // Lặp qua các sản phẩm và hiển thị chúng
                        while ($row2 = $result2->fetch_assoc()) {
                    ?>
                    <div class="col-xxl-6 col-xl-4 col-sm-6">
                        <div class="product-card best-product-card" style="height: 100%;">
                            <div class="top-card">
                                <div class="price-section">
                                    <h4 class="price discounted"><?php echo $row2['product_price'] ?></h4>
                                    <h4 class="price text-color-primary">$<?php echo $row2['product_price_sales'] ?>

                                </div>
                                <button class="wishlist-icon" data-product-id="<?php echo $row2['id_product']; ?>">
                                    <img src="assets/images/icon/wish-icon-2.png" alt="img">
                                </button>
                            </div>
                            <div class="product-img-card best-product-img-card">
                                <a href="index.php?quanly=Shop_details&id=<?php echo $row2['id_product']; ?>"
                                    class="zoomImg">
                                    <img style="width:166px; height:166px"
                                        src="admin/modules/quanlysanpham/images/<?php echo $row2['product_img']; ?>"
                                        alt="img">
                                </a>
                                <div class="discount-badge">
                                    <span class="percentage"><span
                                            class="percentage">-<?php echo 100 - ($row2['product_price_sales'] * 100 / $row2['product_price']) ?>%</span></span>
                                </div>
                                <div class="special-icon">
                                    <button class="icon-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="19"
                                            viewBox="0 0 21 19" fill="none">
                                            <path
                                                d="M0.978546 2.56816V5.13649H1.65442H2.33029V3.71701V2.292L5.45619 5.35743L8.58209 8.42285L9.07209 7.9368L9.56773 7.45628L6.44183 4.39085L3.31593 1.32542H4.76905H6.21654V0.662629V-0.000165939H3.59754H0.978546V2.56816Z"
                                                fill="#111111" />
                                            <path
                                                d="M15.1167 0.662629V1.32542H16.5642H18.0173L14.8914 4.39085L11.7655 7.45628L12.2611 7.9368L12.7511 8.42285L15.877 5.35743L19.0029 2.292V3.71701V5.13649H19.6788H20.3547V2.56816V-0.000165939H17.7357H15.1167V0.662629Z"
                                                fill="#111111" />
                                            <path
                                                d="M5.43926 13.6535L2.33026 16.7078V15.2828V13.8633H1.65439H0.978516V16.4317V19H3.59751H6.21651V18.3372V17.6744H4.76902H3.3159L6.4418 14.609L9.5677 11.5436L9.08896 11.0741C8.82988 10.8145 8.59895 10.6046 8.58206 10.6046C8.56516 10.6046 7.15146 11.9799 5.43926 13.6535Z"
                                                fill="#111111" />
                                            <path
                                                d="M12.2442 11.0741L11.7655 11.5436L14.8914 14.609L18.0173 17.6744H16.5641H15.1167V18.3372V19H17.7356H20.3546V16.4317V13.8633H19.6788H19.0029V15.2828V16.7078L15.8883 13.6535C14.1817 11.9799 12.768 10.6046 12.7511 10.6046C12.7342 10.6046 12.5033 10.8145 12.2442 11.0741Z"
                                                fill="#111111" />
                                        </svg>
                                    </button>
                                    <div class="divider"></div>
                                    <button class="icon-btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="25"
                                            viewBox="0 0 22 25" fill="none">
                                            <path
                                                d="M9.4304 0.827005C9.4304 1.27952 9.41567 1.65419 9.40094 1.65419C9.38622 1.65419 9.14565 1.69798 8.87563 1.75637C4.21162 2.6906 0.73079 6.34481 0.0827378 10.9868C-0.0694564 12.0475 -0.00563302 13.663 0.225113 14.7432C0.809342 17.5069 2.62094 20.1004 5.01677 21.6185L5.29661 21.7937L5.98885 21.2779C6.36688 20.9957 6.68109 20.7524 6.68109 20.733C6.68109 20.7184 6.55835 20.6405 6.41107 20.5627C5.65992 20.1734 4.68293 19.3949 4.02015 18.6601C2.76332 17.2636 1.95816 15.5606 1.69796 13.77C1.60468 13.1083 1.60468 11.7945 1.69796 11.1668C1.89925 9.83845 2.37056 8.58308 3.07753 7.48341C3.96123 6.11612 5.30643 4.91914 6.77928 4.1844C7.52552 3.8146 8.56142 3.46426 9.2733 3.33775L9.4304 3.30856V3.98977C9.4304 4.36444 9.44022 4.67098 9.45495 4.67098C9.50404 4.67098 12.5725 2.36946 12.5725 2.3354C12.5725 2.30134 9.50404 -0.000179291 9.45495 -0.000179291C9.44022 -0.000179291 9.4304 0.369621 9.4304 0.827005Z"
                                                fill="#111111" />
                                            <path
                                                d="M16.0134 3.6345C15.6354 3.91672 15.331 4.16487 15.3457 4.18434C15.3604 4.20867 15.5077 4.30112 15.6795 4.39357C17.118 5.20129 18.4583 6.56371 19.288 8.07697C19.7888 8.98687 20.211 10.3104 20.3288 11.3419C20.427 12.1545 20.3681 13.551 20.211 14.2906C19.5335 17.4728 17.2997 20.0371 14.2165 21.1757C13.8287 21.3168 12.778 21.6039 12.6406 21.6039C12.5866 21.6039 12.5718 21.4822 12.5718 20.9227C12.5718 20.548 12.562 20.2414 12.5473 20.2414C12.4982 20.2414 9.42976 22.543 9.42976 22.577C9.42976 22.6111 12.4982 24.9126 12.5473 24.9126C12.562 24.9126 12.5718 24.5428 12.5718 24.0854V23.2631L12.7584 23.2339C13.215 23.1609 14.5062 22.8154 14.9284 22.65C18.7578 21.1659 21.3795 17.8767 21.9244 13.8673C22.0668 12.8357 22.003 11.2203 21.7771 10.1693C21.1929 7.40549 19.3813 4.81202 16.9855 3.2939L16.7056 3.11873L16.0134 3.6345Z"
                                                fill="#111111" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <a href="index.php?quanly=Shop_details&id=<?php echo $row2['id_product']; ?>">
                                <h4 style="font-size: 10px;" class="product-title line-clamp-1">
                                    <p><strong><?php echo $row2['product_name']; ?></strong></p>
                            </a>
                            <div class="product-review">
                                <div class="product-ratting">
                                    <i class="ri-star-s-fill"></i>
                                    <i class="ri-star-s-fill"></i>
                                    <i class="ri-star-s-fill"></i>
                                    <i class="ri-star-s-fill"></i>
                                    <i class="ri-star-s-fill"></i>
                                </div>
                                <p class="count-ratting">(36)</p>
                            </div>
                            <div class="cart-card best-product-cart-card d-none d-md-block">
                                <a href="index.php?quanly=Shop_details&id=<?php echo $row2['id_product']; ?>">
                                    <h4 class="product-title line-clamp-1">
                                        <p><strong><?php echo $row2['product_name']; ?></strong></p>
                                    </h4>
                                </a>

                                <div class="product-review">
                                    <div class="product-ratting">
                                        <i class="ri-star-s-fill"></i>
                                        <i class="ri-star-s-fill"></i>
                                        <i class="ri-star-s-fill"></i>
                                        <i class="ri-star-s-fill"></i>
                                        <i class="ri-star-s-fill"></i>
                                    </div>
                                    <p class="count-ratting">(36)</p>
                                </div>
                                <div class="button-section" data-product-cart-id="<?php echo $row2['id_product']; ?>">
                                    <a href="javascript:void(0)" class="cart-btn">Add to Cart</a>
                                    <div class="fill-pill-btn qty-btn">
                                        <div class="qty-container best-product-qty-container">
                                            <div class="qty-btn-minus qty-btn mr-1">
                                                <i class="ri-subtract-fill"></i>
                                            </div>
                                            <input type="text" name="qty" value="1" class="input-qty input-rounded">
                                            <div class="qty-btn-plus qty-btn ml-1">
                                                <i class="ri-add-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="button-section d-block d-md-none">
                                <a href="javascript:void(0)" class=" cart-btn">Add to Cart</a>
                            </div> -->
                        </div>
                    </div>
                    <?php

                        }
                    } else {
                        echo "<p>No products available.</p>";
                    }
                    ?>


                </div>
            </div>
        </div>
        <div class="row g-4">
            <?php
            if ($result3->num_rows > 0) {
                // Lặp qua các sản phẩm và hiển thị chúng
                while ($row3 = $result3->fetch_assoc()) {
            ?>
            <div class="col-xxl-3 col-xl-4 col-sm-6">
                <div class="product-card best-product-card">
                    <div class="top-card">
                        <div class="price-section">
                            <h4 class="price discounted"><?php echo $row3['product_price'] ?></h4>

                            <h4 class="price text-color-primary">$<?php echo $row3['product_price_sales'] ?>
                        </div>
                        <button class="wishlist-icon" data-product-id="<?php echo $row3['id_product']; ?>">
                            <img src="assets/images/icon/wish-icon-2.png" alt="img">
                        </button>
                    </div>
                    <div class="product-img-card best-product-img-card">
                        <a href="index.php?quanly=Shop_details&id=<?php echo $row3['id_product']; ?>" class="zoomImg">
                            <img style="width:166px; height:166px"
                                src="admin/modules/quanlysanpham/images/<?php echo $row3['product_img']; ?>" alt="img">
                        </a>

                        <div class="discount-badge">
                            <span class="percentage"><span
                                    class="percentage">-<?php echo 100 - ($row3['product_price_sales'] * 100 / $row3['product_price']) ?>%</span></span>
                        </div>
                        <div class="special-icon">
                            <button class="icon-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="19" viewBox="0 0 21 19"
                                    fill="none">
                                    <path
                                        d="M0.978546 2.56816V5.13649H1.65442H2.33029V3.71701V2.292L5.45619 5.35743L8.58209 8.42285L9.07209 7.9368L9.56773 7.45628L6.44183 4.39085L3.31593 1.32542H4.76905H6.21654V0.662629V-0.000165939H3.59754H0.978546V2.56816Z"
                                        fill="#111111" />
                                    <path
                                        d="M15.1167 0.662629V1.32542H16.5642H18.0173L14.8914 4.39085L11.7655 7.45628L12.2611 7.9368L12.7511 8.42285L15.877 5.35743L19.0029 2.292V3.71701V5.13649H19.6788H20.3547V2.56816V-0.000165939H17.7357H15.1167V0.662629Z"
                                        fill="#111111" />
                                    <path
                                        d="M5.43926 13.6535L2.33026 16.7078V15.2828V13.8633H1.65439H0.978516V16.4317V19H3.59751H6.21651V18.3372V17.6744H4.76902H3.3159L6.4418 14.609L9.5677 11.5436L9.08896 11.0741C8.82988 10.8145 8.59895 10.6046 8.58206 10.6046C8.56516 10.6046 7.15146 11.9799 5.43926 13.6535Z"
                                        fill="#111111" />
                                    <path
                                        d="M12.2442 11.0741L11.7655 11.5436L14.8914 14.609L18.0173 17.6744H16.5641H15.1167V18.3372V19H17.7356H20.3546V16.4317V13.8633H19.6788H19.0029V15.2828V16.7078L15.8883 13.6535C14.1817 11.9799 12.768 10.6046 12.7511 10.6046C12.7342 10.6046 12.5033 10.8145 12.2442 11.0741Z"
                                        fill="#111111" />
                                </svg>
                            </button>
                            <div class="divider"></div>
                            <button class="icon-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="25" viewBox="0 0 22 25"
                                    fill="none">
                                    <path
                                        d="M9.4304 0.827005C9.4304 1.27952 9.41567 1.65419 9.40094 1.65419C9.38622 1.65419 9.14565 1.69798 8.87563 1.75637C4.21162 2.6906 0.73079 6.34481 0.0827378 10.9868C-0.0694564 12.0475 -0.00563302 13.663 0.225113 14.7432C0.809342 17.5069 2.62094 20.1004 5.01677 21.6185L5.29661 21.7937L5.98885 21.2779C6.36688 20.9957 6.68109 20.7524 6.68109 20.733C6.68109 20.7184 6.55835 20.6405 6.41107 20.5627C5.65992 20.1734 4.68293 19.3949 4.02015 18.6601C2.76332 17.2636 1.95816 15.5606 1.69796 13.77C1.60468 13.1083 1.60468 11.7945 1.69796 11.1668C1.89925 9.83845 2.37056 8.58308 3.07753 7.48341C3.96123 6.11612 5.30643 4.91914 6.77928 4.1844C7.52552 3.8146 8.56142 3.46426 9.2733 3.33775L9.4304 3.30856V3.98977C9.4304 4.36444 9.44022 4.67098 9.45495 4.67098C9.50404 4.67098 12.5725 2.36946 12.5725 2.3354C12.5725 2.30134 9.50404 -0.000179291 9.45495 -0.000179291C9.44022 -0.000179291 9.4304 0.369621 9.4304 0.827005Z"
                                        fill="#111111" />
                                    <path
                                        d="M16.0134 3.6345C15.6354 3.91672 15.331 4.16487 15.3457 4.18434C15.3604 4.20867 15.5077 4.30112 15.6795 4.39357C17.118 5.20129 18.4583 6.56371 19.288 8.07697C19.7888 8.98687 20.211 10.3104 20.3288 11.3419C20.427 12.1545 20.3681 13.551 20.211 14.2906C19.5335 17.4728 17.2997 20.0371 14.2165 21.1757C13.8287 21.3168 12.778 21.6039 12.6406 21.6039C12.5866 21.6039 12.5718 21.4822 12.5718 20.9227C12.5718 20.548 12.562 20.2414 12.5473 20.2414C12.4982 20.2414 9.42976 22.543 9.42976 22.577C9.42976 22.6111 12.4982 24.9126 12.5473 24.9126C12.562 24.9126 12.5718 24.5428 12.5718 24.0854V23.2631L12.7584 23.2339C13.215 23.1609 14.5062 22.8154 14.9284 22.65C18.7578 21.1659 21.3795 17.8767 21.9244 13.8673C22.0668 12.8357 22.003 11.2203 21.7771 10.1693C21.1929 7.40549 19.3813 4.81202 16.9855 3.2939L16.7056 3.11873L16.0134 3.6345Z"
                                        fill="#111111" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <a href="index.php?quanly=Shop_details&id=<?php echo $row3['id_product']; ?>">
                        <h4 style="font-size: 10px;" class="product-title line-clamp-1">
                            <p><strong><?php echo $row3['product_name']; ?></strong></p>
                        </h4>
                    </a>

                    <div class="product-review">
                        <div class="product-ratting">
                            <i class="ri-star-s-fill"></i>
                            <i class="ri-star-s-fill"></i>
                            <i class="ri-star-s-fill"></i>
                            <i class="ri-star-s-fill"></i>
                            <i class="ri-star-s-fill"></i>
                        </div>
                        <p class="count-ratting">(41)</p>
                    </div>
                    <div class="cart-card best-product-cart-card d-none d-md-block">
                        <a href="index.php?quanly=Shop_details&id=<?php echo $row3['id_product']; ?>">
                            <h4 class="product-title line-clamp-1">
                                <p><strong><?php echo $row3['product_name']; ?></strong></p>
                            </h4>
                        </a>

                        <div class="product-review">
                            <div class="product-ratting">
                                <i class="ri-star-s-fill"></i>
                                <i class="ri-star-s-fill"></i>
                                <i class="ri-star-s-fill"></i>
                                <i class="ri-star-s-fill"></i>
                                <i class="ri-star-s-fill"></i>
                            </div>
                            <p class="count-ratting">(41)</p>
                        </div>
                        <div class="button-section" data-product-cart-id="<?php echo $row3['id_product']; ?>">
                            <a href="javascript:void(0)" class="cart-btn">Add to Cart</a>
                            <div class="fill-pill-btn qty-btn">
                                <div class="qty-container best-product-qty-container">
                                    <div class="qty-btn-minus qty-btn mr-1">
                                        <i class="ri-subtract-fill"></i>
                                    </div>
                                    <input type="text" name="qty" value="1" class="input-qty input-rounded">
                                    <div class="qty-btn-plus qty-btn ml-1">
                                        <i class="ri-add-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="button-section d-block d-md-none">
                                <a href="javascript:void(0)" class=" cart-btn">Add to Cart</a>
                            </div> -->
                </div>
            </div>
            <?php

                }
            } else {
                echo "<p>No products available.</p>";
            }
            ?>
        </div>

    </div>
</section>
<!-- End-of best product-->

<!-- Subscription area S t a r t -->
<section class="subscription-area subscription-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="subscription-wrapper">
                    <div class="left-wrapper">
                        <div class="subscription-content">
                            <h4 class="title">Get a surprise discount</h4>
                            <p class="pera">Join our email subscription now</p>
                        </div>
                        <div class="subscription-input-section">
                            <input type="text" class="subscription-input" placeholder="Enter your email address">
                            <button type="submit" class="subscribe-btn"><span class="btn-text">Subscribe</span><span
                                    class="icon"><i class="ri-arrow-right-line"></i></span></button>
                        </div>
                    </div>
                    <div class="right-wrapper">
                        <div class="subscription-content">
                            <h4 class="title">Download App</h4>
                            <p class="pera">Save $3 With App & New User only</p>
                        </div>
                        <div class="download-app">
                            <a href="javascript:void(0)" target="_blank" class="  wow fadeInUp" data-wow-delay="0.0s">
                                <img src="assets/images/icon/google-play.png" alt="img">
                            </a>
                            <a href="javascript:void(0)" target="_blank" class="  wow fadeInUp" data-wow-delay="0.1s">
                                <img src="assets/images/icon/app-store.png" alt="img">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End-of subscription-->
<script>
// Cập nhật mã cho wishlist
document.querySelectorAll('.wishlist-icon').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const isInWishlist = this.classList.contains('added');


        fetch('controllers/WishlistController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&action=${isInWishlist ? 'remove' : 'add'}`
            })
            .then(response => response.json())
            .then(parsedResponse => {
                if (parsedResponse.message === 'Operation successful') {
                    document.querySelector('.wishlist-count').textContent = parsedResponse
                        .wishlistCount;
                    if (isInWishlist) {
                        this.classList.remove('added');
                    } else {
                        this.classList.add('added');
                    }
                } else {
                    alert('Đã xảy ra lỗi khi cập nhật wishlist: ' + parsedResponse.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});

// Cập nhật mã cho giỏ hàng
$('.cart-btn').off('click').on('click', function() {
    var productId = $(this).closest('.button-section').data('product-cart-id');
    var quantity = $(this).siblings('.qty-btn').find('.input-qty').val();

    $.ajax({
        type: 'POST',
        url: 'controllers/CartController.php',
        data: {
            product_id: productId,
            quantity: quantity,
            action: 'add' // Hành động thêm sản phẩm vào giỏ hàng
        },
        dataType: 'json',
        success: function(response) {
            console.log('Response from server:', response); // Log phản hồi từ server

            if (response.success) {
                // Cập nhật số lượng sản phẩm trong giỏ hàng
                $('.cart-count').text(response.cartCount);

                // Hiển thị thông báo thành công
                // alert('Sản phẩm đã được thêm vào giỏ hàng thành công');

                // Cập nhật giá subtotal và total nếu có
                $('#subtotal').text(response.subtotal.toFixed(2));
                $('#total').text(response.total.toFixed(2));

                // Cập nhật giá của các sản phẩm trong giỏ hàng nếu cần
                for (const [productId, price] of Object.entries(response.updatedPrices)) {
                    $('#price-' + productId).text(price.toFixed(2));
                }
            } else {
                // Xử lý lỗi
                alert('Đã xảy ra lỗi khi cập nhật giỏ hàng: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX error:', status, error);
            alert('Có lỗi xảy ra trong quá trình gửi yêu cầu. Vui lòng thử lại sau.');
        }
    });
});
</script>