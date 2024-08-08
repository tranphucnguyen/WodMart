<?php

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
// $cartCount = array_sum($_SESSION['cart']);
$products = [];
// Calculate total number of products
$sql_count = "SELECT COUNT(*) as total FROM tbl_product";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_products = $row_count['total'];

// Set the number of products per page
$products_per_page = 9;

// Calculate total number of pages
$total_pages = ceil($total_products / $products_per_page);

// Get current page number from URL, if none is set, default to page 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting product of the current page
$start_from = ($current_page - 1) * $products_per_page;

// Retrieve products for the current page
$sql = "SELECT * FROM tbl_product WHERE product_status = 1 LIMIT $start_from, $products_per_page";
$result = $conn->query($sql);

?>

<style>
.product-title strong {
    font-size: 20px;
    color: black;
    /* Bỏ đi font-size được thiết lập trước đó */
    /* Thêm các thuộc tính khác tại đây nếu cần */
}

#search-results {
    position: absolute;
    background: white;
    width: 25%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 9999;
}

.search-result-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.search-result-item a {
    text-decoration: none;
    color: black;
}

.search-result-item:hover {
    background: #f1f1f1;
}
</style>
<!-- Breadcrumbs S t a r t -->
<section class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Shop</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index.php?quanly" class="single">Home</a>
                            </li>
                            <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                    class="single active">Shop</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End-of Breadcrumbs-->
<!-- product area S t a r t -->
<section class="product-area section-padding">
    <div class="container">
        <div class="row g-4">
            <div class="col-xxl-9 col-xl-8">
                <div class="expand-icon hamburger block d-xl-none" id="hamburger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path
                            d="M3 7H10M10 7C10 8.65685 11.3431 10 13 10H14C15.6569 10 17 8.65685 17 7C17 5.34315 15.6569 4 14 4H13C11.3431 4 10 5.34315 10 7ZM16 17H21M20 7H21M3 17H6M6 17C6 18.6569 7.34315 20 9 20H10C11.6569 20 13 18.6569 13 17C13 15.3431 11.6569 14 10 14H9C7.34315 14 6 15.3431 6 17Z"
                            stroke="#071516" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <div class="row g-4">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-lg-4 col-sm-6">
                        <div class="product-card best-product-card">
                            <div class="top-card">
                                <div class="price-section">
                                    <h4 class="price discounted"><?php echo $row['product_price'] ?></h4>
                                    <h4 class="price text-color-primary"><?php echo $row['product_price_sales'] ?>
                                </div>
                                <button class="wishlist-icon" data-product-id="<?php echo $row['id_product']; ?>">
                                    <img src="assets/images/icon/wish-icon-2.png" alt="img">
                                </button>
                            </div>
                            <div class="product-img-card best-product-img-card">
                                <a href="index.php?quanly=Shop_details&id=<?php echo $row['id_product']; ?>"
                                    class="zoomImg">
                                    <img style="width:166px; height:166px"
                                        src="admin/modules/quanlysanpham/images/<?php echo $row['product_img']; ?>"
                                        alt="img">
                                </a>
                                <div class="discount-badge">
                                    <span
                                        class="percentage"><?php echo $row['product_price_sales'] * 100 / $row['product_price'] ?>%</span>
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
                                <p class="count-ratting">(11)</p>
                            </div>
                            <div class="cart-card best-product-cart-card d-none d-md-block">
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
                                    <p class="count-ratting">(11)</p>
                                </div>
                                <div class="button-section" data-product-cart-id="<?php echo $row['id_product']; ?>">
                                    <a href=" javascript:void(0)" class=" cart-btn">Add to Cart</a>
                                    <div class="fill-pill-btn qty-btn">
                                        <div class="qty-container best-product-qty-container">
                                            <div class="qty-btn-minus qty-btn mr-1">
                                                <i class="ri-subtract-fill"></i>
                                            </div>
                                            <input type="text" name="qty" value="0" class="input-qty input-rounded">
                                            <div class="qty-btn-plus qty-btn ml-1">
                                                <i class="ri-add-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="button-section d-block d-md-none">
                                <a href="javascript:void(0)" class=" cart-btn">Add to Cart</a>
                            </div>
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

            <div class="col-xxl-3 col-xl-4">
                <div class="search-filter-section">
                    <div class="expand-icon close-btn block d-xl-none">
                        <i class="ri-arrow-left-double-line"></i>
                    </div>
                    <div class="search-box">
                        <input class="search-input" type="search" name="search" id="search"
                            placeholder="Search Products">
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path
                                    d="M23.9993 23.9041C23.9917 23.6857 23.9993 23.4667 23.9993 23.2476V22.7779C23.8772 22.4503 23.6347 22.2154 23.3946 21.9753C21.2773 19.8615 19.1608 17.7478 17.0451 15.634C16.9112 15.5013 16.9071 15.4221 17.0204 15.2759C17.967 14.0484 18.598 12.6075 18.8581 11.0795C19.1182 9.55144 18.9995 7.98291 18.5124 6.51143C17.9443 4.81175 16.9085 3.30673 15.5237 2.16917C14.139 1.0316 12.4615 0.307615 10.6839 0.0803287C9.01156 -0.141797 7.31036 0.098851 5.76528 0.776104C3.86408 1.60282 2.37212 2.91276 1.31936 4.70593C0.184388 6.64353 -0.226034 8.72675 0.118038 10.9391C0.464459 13.1656 1.48082 15.0563 3.17124 16.5529C5.44117 18.561 8.09217 19.3272 11.0867 18.8546C12.6385 18.6103 14.0377 17.9821 15.2783 17.0144C15.4269 16.897 15.5044 16.9117 15.6353 17.0432C17.6739 19.0904 19.7164 21.1343 21.7629 23.1748C22.0635 23.4755 22.3418 23.8013 22.7323 23.9969H23.202C23.4368 23.9969 23.6717 23.9922 23.9066 23.9998C23.9847 24.0021 24.004 23.9851 23.9993 23.9041ZM9.48256 16.9921C5.31376 16.971 1.99517 13.6095 2.00691 9.49475C2.01865 5.35355 5.41241 1.97919 9.51955 2.00678C11.5044 2.01608 13.4049 2.81015 14.8063 4.21567C16.2078 5.62119 16.9963 7.52402 16.9999 9.50884C16.9517 13.7387 13.5815 17.0115 9.48256 16.9915V16.9921Z"
                                    fill="#111111" />
                            </svg>
                        </div>
                    </div>
                    <div id="search-results"></div>
                    <div class="search-section">
                        <div class="heading">
                            <h4 class="title">Categories</h4>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="10" viewBox="0 0 20 10"
                                fill="none">
                                <path
                                    d="M20 1.05636C19.9113 0.744994 19.7615 0.47255 19.4676 0.263351C18.9685 -0.0820697 18.2475 -0.0917998 17.7484 0.258486C17.6541 0.326597 17.5598 0.399573 17.4711 0.477415C15.042 2.60832 12.6073 4.74409 10.1782 6.875C10.1228 6.92365 10.0784 6.98203 9.94531 7.0696C9.90649 7.01122 9.88431 6.93824 9.82885 6.88959C7.37757 4.73436 4.92074 2.58399 2.46946 0.428762C2.03688 0.0492861 1.53775 -0.0966664 0.938797 0.0687463C0.0680942 0.312 -0.286842 1.29475 0.262201 1.93694C0.323206 2.00991 0.395302 2.07802 0.467398 2.14614C3.2958 4.62733 6.11865 7.10852 8.94705 9.58485C9.46282 10.0373 10.1172 10.1249 10.7106 9.82323C10.8548 9.75026 10.9824 9.64323 11.0989 9.54106C13.8441 7.13285 16.5837 4.72463 19.3345 2.32128C19.6395 2.0537 19.9113 1.78126 20 1.39692C20 1.28502 20 1.17312 20 1.05636Z"
                                    fill="currentColor" />
                            </svg>
                        </div>
                        <div class="offer-list">
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Office Chair</p>
                                    <p class="pera">(12)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Dining Chair</p>
                                    <p class="pera">(51)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Office Table</p>
                                    <p class="pera">(10)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Dining Table</p>
                                    <p class="pera">(24)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Bed Light</p>
                                    <p class="pera">(31)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Sofa Set</p>
                                    <p class="pera">(25)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Office Chair</p>
                                    <p class="pera">(11)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="search-section">
                        <div class="heading">
                            <h4 class="title">Price Filter</h4>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="10" viewBox="0 0 20 10"
                                fill="none">
                                <path
                                    d="M20 1.05636C19.9113 0.744994 19.7615 0.47255 19.4676 0.263351C18.9685 -0.0820697 18.2475 -0.0917998 17.7484 0.258486C17.6541 0.326597 17.5598 0.399573 17.4711 0.477415C15.042 2.60832 12.6073 4.74409 10.1782 6.875C10.1228 6.92365 10.0784 6.98203 9.94531 7.0696C9.90649 7.01122 9.88431 6.93824 9.82885 6.88959C7.37757 4.73436 4.92074 2.58399 2.46946 0.428762C2.03688 0.0492861 1.53775 -0.0966664 0.938797 0.0687463C0.0680942 0.312 -0.286842 1.29475 0.262201 1.93694C0.323206 2.00991 0.395302 2.07802 0.467398 2.14614C3.2958 4.62733 6.11865 7.10852 8.94705 9.58485C9.46282 10.0373 10.1172 10.1249 10.7106 9.82323C10.8548 9.75026 10.9824 9.64323 11.0989 9.54106C13.8441 7.13285 16.5837 4.72463 19.3345 2.32128C19.6395 2.0537 19.9113 1.78126 20 1.39692C20 1.28502 20 1.17312 20 1.05636Z"
                                    fill="currentColor" />
                            </svg>
                        </div>
                        <div class="price-range-slider">
                            <div id="slider-range" class="range-bar"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="range-value">
                                    <p class="pera">price: </p> <input type="text" id="amount" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="search-section">
                        <div class="heading">
                            <h4 class="title">Color</h4>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="10" viewBox="0 0 20 10"
                                fill="none">
                                <path
                                    d="M20 1.05636C19.9113 0.744994 19.7615 0.47255 19.4676 0.263351C18.9685 -0.0820697 18.2475 -0.0917998 17.7484 0.258486C17.6541 0.326597 17.5598 0.399573 17.4711 0.477415C15.042 2.60832 12.6073 4.74409 10.1782 6.875C10.1228 6.92365 10.0784 6.98203 9.94531 7.0696C9.90649 7.01122 9.88431 6.93824 9.82885 6.88959C7.37757 4.73436 4.92074 2.58399 2.46946 0.428762C2.03688 0.0492861 1.53775 -0.0966664 0.938797 0.0687463C0.0680942 0.312 -0.286842 1.29475 0.262201 1.93694C0.323206 2.00991 0.395302 2.07802 0.467398 2.14614C3.2958 4.62733 6.11865 7.10852 8.94705 9.58485C9.46282 10.0373 10.1172 10.1249 10.7106 9.82323C10.8548 9.75026 10.9824 9.64323 11.0989 9.54106C13.8441 7.13285 16.5837 4.72463 19.3345 2.32128C19.6395 2.0537 19.9113 1.78126 20 1.39692C20 1.28502 20 1.17312 20 1.05636Z"
                                    fill="currentColor" />
                            </svg>
                        </div>
                        <div class="color-section">
                            <div class="color-checkbox">
                                <input class="check-color" type="checkbox" id="checkbox1">
                                <div></div>
                            </div>
                            <div class="color-checkbox">
                                <input class="check-color" type="checkbox" id="checkbox2">
                                <div></div>
                            </div>
                            <div class="color-checkbox">
                                <input class="check-color" type="checkbox" id="checkbox3">
                                <div></div>
                            </div>
                            <div class="color-checkbox">
                                <input class="check-color" type="checkbox" id="checkbox4">
                                <div></div>
                            </div>
                            <div class="color-checkbox">
                                <input class="check-color" type="checkbox" id="checkbox5">
                                <div></div>
                            </div>
                            <div class="color-checkbox">
                                <input class="check-color" type="checkbox" id="checkbox6">
                                <div></div>
                            </div>
                            <div class="color-checkbox">
                                <input class="check-color" type="checkbox" id="checkbox7">
                                <div></div>
                            </div>
                            <div class="color-checkbox">
                                <input class="check-color" type="checkbox" id="checkbox8">
                                <div></div>
                            </div>
                            <div class="color-checkbox">
                                <input class="check-color" type="checkbox" id="checkbox9">
                                <div></div>
                            </div>
                            <div class="color-checkbox">
                                <input class="check-color" type="checkbox" id="checkbox10">
                                <div></div>
                            </div>
                        </div>

                    </div>
                    <div class="search-section">
                        <div class="heading">
                            <h4 class="title">Manufactures</h4>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="10" viewBox="0 0 20 10"
                                fill="none">
                                <path
                                    d="M20 1.05636C19.9113 0.744994 19.7615 0.47255 19.4676 0.263351C18.9685 -0.0820697 18.2475 -0.0917998 17.7484 0.258486C17.6541 0.326597 17.5598 0.399573 17.4711 0.477415C15.042 2.60832 12.6073 4.74409 10.1782 6.875C10.1228 6.92365 10.0784 6.98203 9.94531 7.0696C9.90649 7.01122 9.88431 6.93824 9.82885 6.88959C7.37757 4.73436 4.92074 2.58399 2.46946 0.428762C2.03688 0.0492861 1.53775 -0.0966664 0.938797 0.0687463C0.0680942 0.312 -0.286842 1.29475 0.262201 1.93694C0.323206 2.00991 0.395302 2.07802 0.467398 2.14614C3.2958 4.62733 6.11865 7.10852 8.94705 9.58485C9.46282 10.0373 10.1172 10.1249 10.7106 9.82323C10.8548 9.75026 10.9824 9.64323 11.0989 9.54106C13.8441 7.13285 16.5837 4.72463 19.3345 2.32128C19.6395 2.0537 19.9113 1.78126 20 1.39692C20 1.28502 20 1.17312 20 1.05636Z"
                                    fill="currentColor" />
                            </svg>
                        </div>
                        <div class="offer-list">
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Hatil Furniture</p>
                                    <p class="pera">(14)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Navana Furniture</p>
                                    <p class="pera">(22)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Akhtar Furnishers</p>
                                    <p class="pera">(10)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Lamp Lighting</p>
                                    <p class="pera">(51)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Otobi Furniture</p>
                                    <p class="pera">(42)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Nadia Furniture</p>
                                    <p class="pera">(25)</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <label class="checkbox-label">
                                    <input class="checkbox-style" type="checkbox" value="remember" name="remember">
                                    <span class="checkmark-style"></span>
                                </label>
                                <div class="content pl-24 d-flex justify-content-between w-100">
                                    <p class="pera">Regal Furniture</p>
                                    <p class="pera">(62)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cover"></div>
            </div>
        </div>
        <!-- pagination -->

        <nav class="pagination-nav">
            <ul class="pagination">
                <?php if ($current_page > 1) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $current_page - 1; ?>" aria-label="Previous"><i
                            class="ri-arrow-left-s-line"></i></a>
                </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <li class="page-item <?php if ($current_page == $i) echo 'active'; ?>">
                    <a class="page-link"
                        href="?page=<?php echo $i; ?>"><?php echo str_pad($i, 2, '0', STR_PAD_LEFT); ?></a>
                </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages) : ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $current_page + 1; ?>" aria-label="Next"><i
                            class="ri-arrow-right-s-line"></i></a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- End pagination -->
    </div>
</section>
<!-- End-of goal-->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
$(document).ready(function() {
    $('#search').on('keyup', function() {
        let query = $(this).val();
        if (query !== '') {
            $.ajax({
                url: "controllers/SearchProduct.php",
                method: "POST",
                data: {
                    query: query
                },
                success: function(data) {
                    $('#search-results').html(data);
                }
            });
        } else {
            $('#search-results').html('');
        }
    });
});
</script>
<script>
// Cập nhật mã cho wishlist
document.querySelectorAll('.wishlist-icon').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const isInWishlist = this.classList.contains('added');
        const quantity = this.closest('tr').querySelector('.input-qty').value || 1;

        fetch('controllers/WishlistController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&action=${isInWishlist ? 'remove' : 'add'}&quantity=${quantity}`
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