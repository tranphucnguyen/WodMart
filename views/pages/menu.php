<?php
// Kiểm tra nếu $_SESSION['wishlist'] chưa tồn tại, khởi tạo là một mảng rỗng
// if (!isset($_SESSION['wishlist'])) {
//     $_SESSION['wishlist'] = [];
// }

// Kiểm tra nếu $_SESSION['cart'] chưa tồn tại, khởi tạo là một mảng rỗng
// if (!isset($_SESSION['cart'])) {
//     $_SESSION['cart'] = [];
// }

// Lấy id_account_customer từ session
$id_account_customer = isset($_SESSION['id_account_customer']) ? $_SESSION['id_account_customer'] : null;

$wishlistCount = 0;
$cartCount = 0;

if ($id_account_customer) {
    // Lấy số lượng sản phẩm trong wishlist từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tbl_wishlist_items WHERE id_account_customer = ?");
    $stmt->bind_param("i", $id_account_customer);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $wishlistCount = $row['count'];
    $stmt->close();

    // Lấy số lượng sản phẩm trong giỏ hàng từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tbl_cart_items WHERE id_account_customer = ?");
    $stmt->bind_param("i", $id_account_customer);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cartCount = $row['count'];
    $stmt->close();
} else {

    $wishlistCount = 0;
    $cartCount = 0;
}

// Lấy danh sách danh mục và phân danh mục từ cơ sở dữ liệu
$query = "
    SELECT c.id_category, c.category_name, s.id_subcategory, s.subcategory_name 
    FROM tbl_category c 
    LEFT JOIN tbl_subcategory s 
    ON c.id_category = s.id_category 
    WHERE c.category_status = 1 
    ORDER BY c.id_category, s.id_subcategory";

$result = $conn->query($query);

$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[$row['id_category']]['category_name'] = $row['category_name'];
    if (!empty($row['id_subcategory'])) {
        $categories[$row['id_category']]['subcategories'][] = [
            'id_subcategory' => $row['id_subcategory'],
            'subcategory_name' => $row['subcategory_name']
        ];
    } else {
        $categories[$row['id_category']]['subcategories'] = []; // Ensure subcategories key exists
    }
}
?>

<div class="header-bottom header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="menu-wrapper">
                    <!-- Main-menu for desktop -->
                    <div class="main-menu">
                        <nav>
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Logo-->
                                <div class="logo logo-large light-logo">
                                    <a href="index.php?quanly"><img src="assets/images/logo/logo.png" alt="logo"></a>
                                </div>
                                <div class="search-header-position d-block d-lg-none">
                                    <div class="d-flex gap-15">
                                        <div class="search-bar">
                                            <a href="javascript:void(0)" class="rounded-btn">
                                                <i class="ri-search-line"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="listing d-none d-lg-block" id="navigation">
                                    <?php foreach ($categories as $id_category => $category) : ?>
                                    <li class="single-list">
                                        <a href="index.php?quanly=<?php echo urlencode($category['category_name']); ?>"
                                            class="single">
                                            <?php echo $category['category_name']; ?>
                                            <?php if (!empty($category['subcategories'])) : ?>
                                            <i class="ri-arrow-down-s-line"></i>
                                            <?php endif; ?>
                                        </a>
                                        <?php if (!empty($category['subcategories'])) : ?>
                                        <ul class="submenu">
                                            <?php foreach ($category['subcategories'] as $subcategory) : ?>
                                            <li class="single-list">
                                                <a href="index.php?quanly=<?php echo urlencode($subcategory['subcategory_name']); ?>&id_subcategory=<?php echo urlencode($subcategory['id_subcategory']); ?>"
                                                    class="single"><?php echo $subcategory['subcategory_name']; ?></a>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <?php endif; ?>
                                    </li>
                                    <?php endforeach; ?>
                                    <li class="d-block d-lg-none">
                                        <div class="login-wrapper">
                                            <a href="login.html">
                                                <p class="pera text-color-primary">
                                                    Login/ Regeister
                                                </p>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="d-block d-lg-none">
                                        <div class="login-wrapper">
                                            <a href="shopping-cart.html">
                                                <p class="pera text-color-primary">
                                                    Cart
                                                </p>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="d-block d-lg-none">
                                        <div class="login-wrapper">
                                            <a href="index.php?quanly=Wishlist">
                                                <p class="pera text-color-primary">
                                                    Wishlist
                                                </p>
                                            </a>
                                        </div>
                                    </li>
                                    <li class="d-block d-lg-none">
                                        <div class="login-wrapper">
                                            <a href="order-track.html">
                                                <p class="pera text-color-primary">
                                                    Track Order
                                                </p>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="d-none d-lg-block">
                                    <div class="header-right">
                                        <div class="header-icon search-bar">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M22.785 23.9941C22.5326 23.8063 22.2509 23.6479 22.0337 23.4249C19.9089 21.3181 17.8017 19.1996 15.6886 17.0869C15.624 17.0224 15.583 16.9344 15.5301 16.8522C13.0884 18.7242 10.4177 19.3991 7.47701 18.7653C5.02937 18.2372 3.07479 16.8991 1.67195 14.8334C-1.0046 10.9192 -0.370684 5.87229 2.88109 2.71505C6.52026 -0.811896 11.932 -0.817765 15.5712 2.2045C19.3747 5.36174 20.3021 11.1539 16.8978 15.4672C16.9564 15.5318 17.0151 15.5963 17.0797 15.6609C19.1928 17.7736 21.3117 19.8862 23.4189 22.0106C23.642 22.2395 23.8063 22.5211 24 22.7794C24 22.9202 24 23.061 24 23.2019C23.865 23.6009 23.6009 23.865 23.2017 24C23.0667 23.9941 22.9259 23.9941 22.785 23.9941ZM17.0034 9.49314C16.9799 5.34413 13.6166 1.99323 9.49616 2.00497C5.35807 2.02258 1.99478 5.39108 2.01238 9.51075C2.02999 13.648 5.35807 17.0048 9.51377 16.993C13.7164 16.9813 16.9799 13.6069 17.0034 9.49314Z"
                                                    fill="currentColor" />
                                            </svg>

                                        </div>
                                        <div class="header-icon">
                                            <a href="index.php?quanly=Login">
                                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_366_11241)">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M13 1.75C6.7868 1.75 1.75 6.7868 1.75 13C1.75 16.0203 2.9395 18.7622 4.8774 20.7837C6.40175 17.853 9.4662 15.85 13 15.85C16.5338 15.85 19.5983 17.853 21.1226 20.7837C23.0605 18.7622 24.25 16.0203 24.25 13C24.25 6.7868 19.2132 1.75 13 1.75ZM19.9665 21.8341C18.762 19.188 16.0948 17.35 13 17.35C9.9052 17.35 7.23801 19.188 6.03354 21.8341C7.94968 23.3474 10.3686 24.25 13 24.25C15.6314 24.25 18.0503 23.3474 19.9665 21.8341ZM0.25 13C0.25 5.95837 5.95837 0.25 13 0.25C20.0416 0.25 25.75 5.95837 25.75 13C25.75 16.8422 24.0496 20.2881 21.3627 22.6245C19.1245 24.5709 16.199 25.75 13 25.75C9.80096 25.75 6.87546 24.5709 4.63726 22.6245C1.95044 20.2881 0.25 16.8422 0.25 13Z"
                                                            fill="currentColor" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M13 12.25C11.6193 12.25 10.5 11.1307 10.5 9.75C10.5 8.36929 11.6193 7.25 13 7.25C14.3807 7.25 15.5 8.36929 15.5 9.75C15.5 11.1307 14.3807 12.25 13 12.25ZM9 9.75C9 11.9591 10.7909 13.75 13 13.75C15.2091 13.75 17 11.9591 17 9.75C17 7.54086 15.2091 5.75 13 5.75C10.7909 5.75 9 7.54086 9 9.75Z"
                                                            fill="currentColor" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_366_11241">
                                                            <rect width="26" height="26" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                            </a>
                                        </div>
                                        <div class="header-icon">
                                            <a href="index.php?quanly=Wishlist">
                                                <svg width="28" height="24" viewBox="0 0 28 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M7.36008 0.0339781C5.72822 0.245365 4.36236 0.937658 3.20625 2.14257C2.16779 3.22064 1.54369 4.36213 1.1856 5.84713C0.551267 8.42076 1.01167 10.9574 2.53611 13.3408C3.51318 14.8681 4.77672 16.2685 7.09408 18.4035C8.56736 19.7617 13.0639 23.7252 13.2839 23.8573C13.4885 23.9841 13.5653 24 14.0001 24C14.4349 24 14.5116 23.9841 14.7163 23.8573C14.9362 23.7252 19.4431 19.7564 20.9061 18.4035C23.2337 16.2579 24.487 14.8628 25.4641 13.3408C26.9885 10.9574 27.4489 8.42076 26.8146 5.84713C26.4565 4.36213 25.8324 3.22064 24.7939 2.14257C23.7606 1.06978 22.6556 0.451468 21.2079 0.134387C20.4815 -0.0241534 19.1412 -0.0400074 18.5069 0.107964C16.7369 0.504315 15.3813 1.41856 14.1433 3.04625L14.0001 3.23121L13.862 3.04625C12.6393 1.45027 11.3042 0.536023 9.6007 0.134387C9.09426 0.0128394 7.92791 -0.0400074 7.36008 0.0339781ZM9.06868 1.64581C10.5215 1.91004 11.7748 2.77673 12.7672 4.20887C12.9361 4.45725 13.1458 4.7532 13.2276 4.87474C13.6062 5.42435 14.394 5.42435 14.7725 4.87474C14.8544 4.7532 15.0641 4.45725 15.2329 4.20887C16.5886 2.25354 18.4762 1.33401 20.5327 1.62467C22.8142 1.94703 24.5944 3.59585 25.2748 6.02152C25.8119 7.93986 25.5766 9.95332 24.5995 11.766C23.781 13.2827 22.4152 14.8734 20.0365 17.0771C18.8855 18.1393 14.0461 22.441 14.0001 22.441C13.9489 22.441 9.13007 18.1551 7.96372 17.0771C4.30609 13.6896 2.8635 11.5757 2.51564 9.0972C2.29056 7.49595 2.61284 5.77314 3.39552 4.41498C4.5721 2.36981 6.86388 1.24945 9.06868 1.64581Z"
                                                        fill="currentColor" />
                                                </svg>

                                                <div class="count">
                                                    <span class="wishlist-count"><?php echo $wishlistCount; ?></span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="header-icon">
                                            <a href="index.php?quanly=Shopping Cart">
                                                <svg width="22" height="24" viewBox="0 0 22 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M19.7472 6.21264C19.5903 5.81551 19.2308 5.78119 17.464 5.78119H15.9959V5.15364C15.9959 4.17798 15.8541 3.49649 15.5099 2.79539C14.8872 1.52556 13.8443 0.638157 12.4926 0.226322C11.8345 0.0302096 10.8524 -0.053138 10.255 0.0351124C8.59958 0.290058 7.18715 1.31474 6.46828 2.77578C6.11896 3.49159 5.97721 4.17798 5.97721 5.15364V5.7861H4.50403C2.73722 5.7861 2.37778 5.82042 2.22084 6.23225C2.13984 6.4921 1.38047 12.0764 1.05647 14.4837C0.772972 16.5821 0.509722 18.5628 0.317347 20.0532C-0.0167771 22.6223 -0.00665214 22.6615 0.00347284 22.7057V22.7106C0.0490353 22.8773 0.499597 23.3136 0.636284 23.4411L1.2286 24H20.7091L21.1495 23.6225C21.3469 23.4509 22 22.8675 22 22.5782C22 22.3821 19.7877 6.32541 19.7472 6.21264ZM20.4003 22.2056C20.3952 22.2399 20.3547 22.3429 20.2838 22.4164L20.1826 22.5243H1.79053L1.52728 22.2497L2.56509 14.7435C2.92959 12.0715 3.25359 9.74266 3.44597 8.35026C3.53203 7.74231 3.57253 7.43344 3.59278 7.28145C4.27622 7.27655 7.26309 7.27165 10.979 7.27165H18.3702L18.3803 7.32558C18.4613 7.7178 20.3648 21.7692 20.4003 22.2056ZM7.50102 5.7861V5.22718C7.50102 4.84966 7.55165 4.32997 7.60734 4.08973C7.90602 2.86403 8.92358 1.86876 10.1943 1.55008C10.7258 1.4226 11.5966 1.46673 12.1281 1.65304H12.1332C12.6901 1.83444 13.1457 2.12861 13.5659 2.57967C14.2443 3.29547 14.4721 3.93774 14.4721 5.12422V5.7861H7.50102Z"
                                                        fill="#13172B" />
                                                </svg>

                                                <div class="count">
                                                    <span class="cart-count"><?php echo $cartCount; ?></span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="div">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>