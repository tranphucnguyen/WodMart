 <?php
    $id_product = $_GET['id'];
    $sql = "SELECT * FROM tbl_product WHERE id_product=$id_product ";
    $result = $conn->query($sql);
    $sql_1 = "SELECT * FROM tbl_product WHERE product_status = 1";
    $result1 = $conn->query($sql_1);
    ?>
 <?php


    // Hàm để lấy phản hồi dựa trên id_product
    function getFeedbacks($id_product)
    {
        global $conn;
        $feedbacks = array();
        $sql = "SELECT tbl_feedback_order.*, tbl_order.email_customer 
            FROM tbl_feedback_order 
            JOIN tbl_order ON tbl_feedback_order.id_order = tbl_order.id_order 
            WHERE tbl_feedback_order.id_product = ? AND tbl_feedback_order.feedback_status = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_product);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $feedbacks[] = $row;
        }
        $stmt->close();
        return $feedbacks;
    }
    ?>
 <style>
b,
strong {
    font-weight: bolder;
    font-size: 30px;
    color: black;
}

.color-section {
    margin-top: 10px;
}

.color-option {
    position: relative;
    display: inline-block;
}

.color-option input.check-color {
    display: none;
}

.color-option .color-display {
    width: 20px;
    height: 20px;
    margin: 5px;
    border: none;
    cursor: pointer;
    border-radius: 50%;
    transition: transform 0.3s ease-in-out;
}

.color-option input.check-color:checked+label .color-display {
    /* transform: translateY(4px); */
    box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.2);
}

.product-title strong {
    font-size: 18px;
    /* Bỏ đi font-size được thiết lập trước đó */
    /* Thêm các thuộc tính khác tại đây nếu cần */
}
 </style>
 <!-- Breadcrumbs S t a r t -->
 <section class="breadcrumb-section breadcrumb-bg">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <div class="breadcrumb-text">
                     <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Shop Details</h1>
                     <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                         <ul class="breadcrumb listing">
                             <li class="breadcrumb-item single-list"><a href="index.php?quanly" class="single">Home</a>
                             </li>
                             <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                     class="single active">Shop Details</a></li>
                         </ul>
                     </nav>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!-- End-of Breadcrumbs-->
 <!-- product area S t a r t -->
 <?php
    if ($result->num_rows > 0) {
        // Đã tìm thấy sản phẩm
        while ($row = $result->fetch_assoc()) {
            $images = explode(',', $row["product_img_desc"]);
    ?>
 <section class="product-details-area top-padding">
     <div class="container">
         <div class="row g-4">
             <div class="col-xxl-6 col-lg-6">
                 <div class="product-image-container">
                     <div class="xzoom-box">
                         <img class="xzoom"
                             src="admin/modules/quanlysanpham/images/<?php echo htmlspecialchars($row['product_img']); ?>"
                             xoriginal="admin/modules/quanlysanpham/images/<?php echo htmlspecialchars($row['product_img']); ?>"
                             data-fancybox="gallery" alt="img">
                         <div class="shape-01">
                             <img src="assets/images/product/preview-shape-01.png" alt="img">
                         </div>
                         <div class="shape-02">
                             <img src="assets/images/product/preview-shape-02.png" alt="img">
                         </div>
                     </div>

                     <div class="xzoom-thumbs">
                         <?php
                                    // Display thumbnails
                                    foreach ($images as $image) {
                                        $image_path = 'admin/modules/quanlysanpham/images/' . htmlspecialchars(trim($image));
                                        echo '<div class="xzoom-gallery-box">';
                                        echo '<a href="' . $image_path . '">';
                                        echo '<img class="xzoom-gallery" width="80" src="' . $image_path . '" data-fancybox="gallery" alt="img">';
                                        echo '</a>';
                                        echo '</div>';
                                    }
                                    ?>
                     </div>
                 </div>
             </div>

             <div class="col-xxl-6 col-lg-6">
                 <div class="product-details-content">
                     <div class="first-section">
                         <h4 class="product-name">
                             <p><strong><?php echo  $row["product_name"] ?></strong></p>
                         </h4>
                         <div class="product-price-section">
                             <div class="price-section">
                                 <h4 class="price discounted">$<?php echo  $row["product_price"] ?></h4>
                                 <h4 class="price">$<?php echo  $row["product_price_sales"] ?></h4>
                             </div>
                             <div class="ratting-section">
                                 <div class="all-ratting">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                         fill="none">
                                         <path
                                             d="M14 5.39116V5.70526C13.9143 5.90196 13.7892 6.07722 13.6332 6.21924C12.687 7.07588 11.7485 7.94194 10.8032 8.80001C10.7159 8.87939 10.6937 8.94735 10.7189 9.06471C11.0086 10.3759 11.2933 11.6883 11.5789 13.0004C11.6132 13.139 11.6138 13.2843 11.5808 13.4233C11.4492 13.9298 10.9112 14.1514 10.4678 13.8761C9.3554 13.1846 8.2441 12.4897 7.1339 11.7917C7.03433 11.7291 6.9643 11.7311 6.86583 11.7917C5.75982 12.4865 4.65208 13.1783 3.5426 13.867C3.25238 14.0475 2.96079 14.0509 2.68807 13.8365C2.41945 13.6252 2.34806 13.3339 2.42082 12.9981C2.70776 11.6792 2.99416 10.3571 3.28493 9.03729C3.30736 8.93593 3.28493 8.88281 3.21655 8.82056C2.43751 8.1107 1.65382 7.40569 0.885446 6.6844C0.566226 6.38458 0.170415 6.15328 0 5.70526V5.36261L0.0202418 5.33405H0V5.27694C0.00481165 5.28329 0.0100202 5.2893 0.0155917 5.29493C0.0265333 5.28722 0.0410307 5.27951 0.0454074 5.26809C0.187921 4.87918 0.489361 4.76125 0.854809 4.73469C1.30861 4.70157 1.76159 4.65645 2.21457 4.61391C2.99826 4.54024 3.78168 4.46257 4.56564 4.39232C4.67314 4.3829 4.73277 4.34806 4.77681 4.23927C5.27739 3.00514 5.78371 1.77387 6.28702 0.540886C6.34173 0.408107 6.40628 0.283895 6.51242 0.189951C6.90741 -0.164411 7.49907 -0.00850327 7.71599 0.537174C8.20836 1.77473 8.72179 3.00286 9.22237 4.2367C9.26586 4.3435 9.32221 4.38433 9.4319 4.39261C9.88543 4.42688 10.3387 4.46971 10.7917 4.51225C11.5758 4.58592 12.3594 4.66074 13.1425 4.73669C13.314 4.75354 13.4857 4.76782 13.6406 4.86405C13.8364 4.9854 13.9275 5.18043 14 5.39116Z"
                                             fill="#FCC013" />
                                     </svg>
                                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                         fill="none">
                                         <path
                                             d="M14 5.39116V5.70526C13.9143 5.90196 13.7892 6.07722 13.6332 6.21924C12.687 7.07588 11.7485 7.94194 10.8032 8.80001C10.7159 8.87939 10.6937 8.94735 10.7189 9.06471C11.0086 10.3759 11.2933 11.6883 11.5789 13.0004C11.6132 13.139 11.6138 13.2843 11.5808 13.4233C11.4492 13.9298 10.9112 14.1514 10.4678 13.8761C9.3554 13.1846 8.2441 12.4897 7.1339 11.7917C7.03433 11.7291 6.9643 11.7311 6.86583 11.7917C5.75982 12.4865 4.65208 13.1783 3.5426 13.867C3.25238 14.0475 2.96079 14.0509 2.68807 13.8365C2.41945 13.6252 2.34806 13.3339 2.42082 12.9981C2.70776 11.6792 2.99416 10.3571 3.28493 9.03729C3.30736 8.93593 3.28493 8.88281 3.21655 8.82056C2.43751 8.1107 1.65382 7.40569 0.885446 6.6844C0.566226 6.38458 0.170415 6.15328 0 5.70526V5.36261L0.0202418 5.33405H0V5.27694C0.00481165 5.28329 0.0100202 5.2893 0.0155917 5.29493C0.0265333 5.28722 0.0410307 5.27951 0.0454074 5.26809C0.187921 4.87918 0.489361 4.76125 0.854809 4.73469C1.30861 4.70157 1.76159 4.65645 2.21457 4.61391C2.99826 4.54024 3.78168 4.46257 4.56564 4.39232C4.67314 4.3829 4.73277 4.34806 4.77681 4.23927C5.27739 3.00514 5.78371 1.77387 6.28702 0.540886C6.34173 0.408107 6.40628 0.283895 6.51242 0.189951C6.90741 -0.164411 7.49907 -0.00850327 7.71599 0.537174C8.20836 1.77473 8.72179 3.00286 9.22237 4.2367C9.26586 4.3435 9.32221 4.38433 9.4319 4.39261C9.88543 4.42688 10.3387 4.46971 10.7917 4.51225C11.5758 4.58592 12.3594 4.66074 13.1425 4.73669C13.314 4.75354 13.4857 4.76782 13.6406 4.86405C13.8364 4.9854 13.9275 5.18043 14 5.39116Z"
                                             fill="#FCC013" />
                                     </svg>
                                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                         fill="none">
                                         <path
                                             d="M14 5.39116V5.70526C13.9143 5.90196 13.7892 6.07722 13.6332 6.21924C12.687 7.07588 11.7485 7.94194 10.8032 8.80001C10.7159 8.87939 10.6937 8.94735 10.7189 9.06471C11.0086 10.3759 11.2933 11.6883 11.5789 13.0004C11.6132 13.139 11.6138 13.2843 11.5808 13.4233C11.4492 13.9298 10.9112 14.1514 10.4678 13.8761C9.3554 13.1846 8.2441 12.4897 7.1339 11.7917C7.03433 11.7291 6.9643 11.7311 6.86583 11.7917C5.75982 12.4865 4.65208 13.1783 3.5426 13.867C3.25238 14.0475 2.96079 14.0509 2.68807 13.8365C2.41945 13.6252 2.34806 13.3339 2.42082 12.9981C2.70776 11.6792 2.99416 10.3571 3.28493 9.03729C3.30736 8.93593 3.28493 8.88281 3.21655 8.82056C2.43751 8.1107 1.65382 7.40569 0.885446 6.6844C0.566226 6.38458 0.170415 6.15328 0 5.70526V5.36261L0.0202418 5.33405H0V5.27694C0.00481165 5.28329 0.0100202 5.2893 0.0155917 5.29493C0.0265333 5.28722 0.0410307 5.27951 0.0454074 5.26809C0.187921 4.87918 0.489361 4.76125 0.854809 4.73469C1.30861 4.70157 1.76159 4.65645 2.21457 4.61391C2.99826 4.54024 3.78168 4.46257 4.56564 4.39232C4.67314 4.3829 4.73277 4.34806 4.77681 4.23927C5.27739 3.00514 5.78371 1.77387 6.28702 0.540886C6.34173 0.408107 6.40628 0.283895 6.51242 0.189951C6.90741 -0.164411 7.49907 -0.00850327 7.71599 0.537174C8.20836 1.77473 8.72179 3.00286 9.22237 4.2367C9.26586 4.3435 9.32221 4.38433 9.4319 4.39261C9.88543 4.42688 10.3387 4.46971 10.7917 4.51225C11.5758 4.58592 12.3594 4.66074 13.1425 4.73669C13.314 4.75354 13.4857 4.76782 13.6406 4.86405C13.8364 4.9854 13.9275 5.18043 14 5.39116Z"
                                             fill="#FCC013" />
                                     </svg>
                                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                         fill="none">
                                         <path
                                             d="M14 5.39116V5.70526C13.9143 5.90196 13.7892 6.07722 13.6332 6.21924C12.687 7.07588 11.7485 7.94194 10.8032 8.80001C10.7159 8.87939 10.6937 8.94735 10.7189 9.06471C11.0086 10.3759 11.2933 11.6883 11.5789 13.0004C11.6132 13.139 11.6138 13.2843 11.5808 13.4233C11.4492 13.9298 10.9112 14.1514 10.4678 13.8761C9.3554 13.1846 8.2441 12.4897 7.1339 11.7917C7.03433 11.7291 6.9643 11.7311 6.86583 11.7917C5.75982 12.4865 4.65208 13.1783 3.5426 13.867C3.25238 14.0475 2.96079 14.0509 2.68807 13.8365C2.41945 13.6252 2.34806 13.3339 2.42082 12.9981C2.70776 11.6792 2.99416 10.3571 3.28493 9.03729C3.30736 8.93593 3.28493 8.88281 3.21655 8.82056C2.43751 8.1107 1.65382 7.40569 0.885446 6.6844C0.566226 6.38458 0.170415 6.15328 0 5.70526V5.36261L0.0202418 5.33405H0V5.27694C0.00481165 5.28329 0.0100202 5.2893 0.0155917 5.29493C0.0265333 5.28722 0.0410307 5.27951 0.0454074 5.26809C0.187921 4.87918 0.489361 4.76125 0.854809 4.73469C1.30861 4.70157 1.76159 4.65645 2.21457 4.61391C2.99826 4.54024 3.78168 4.46257 4.56564 4.39232C4.67314 4.3829 4.73277 4.34806 4.77681 4.23927C5.27739 3.00514 5.78371 1.77387 6.28702 0.540886C6.34173 0.408107 6.40628 0.283895 6.51242 0.189951C6.90741 -0.164411 7.49907 -0.00850327 7.71599 0.537174C8.20836 1.77473 8.72179 3.00286 9.22237 4.2367C9.26586 4.3435 9.32221 4.38433 9.4319 4.39261C9.88543 4.42688 10.3387 4.46971 10.7917 4.51225C11.5758 4.58592 12.3594 4.66074 13.1425 4.73669C13.314 4.75354 13.4857 4.76782 13.6406 4.86405C13.8364 4.9854 13.9275 5.18043 14 5.39116Z"
                                             fill="#FCC013" />
                                     </svg>
                                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"
                                         fill="none">
                                         <path
                                             d="M14 5.39116V5.70526C13.9143 5.90196 13.7892 6.07722 13.6332 6.21924C12.687 7.07588 11.7485 7.94194 10.8032 8.80001C10.7159 8.87939 10.6937 8.94735 10.7189 9.06471C11.0086 10.3759 11.2933 11.6883 11.5789 13.0004C11.6132 13.139 11.6138 13.2843 11.5808 13.4233C11.4492 13.9298 10.9112 14.1514 10.4678 13.8761C9.3554 13.1846 8.2441 12.4897 7.1339 11.7917C7.03433 11.7291 6.9643 11.7311 6.86583 11.7917C5.75982 12.4865 4.65208 13.1783 3.5426 13.867C3.25238 14.0475 2.96079 14.0509 2.68807 13.8365C2.41945 13.6252 2.34806 13.3339 2.42082 12.9981C2.70776 11.6792 2.99416 10.3571 3.28493 9.03729C3.30736 8.93593 3.28493 8.88281 3.21655 8.82056C2.43751 8.1107 1.65382 7.40569 0.885446 6.6844C0.566226 6.38458 0.170415 6.15328 0 5.70526V5.36261L0.0202418 5.33405H0V5.27694C0.00481165 5.28329 0.0100202 5.2893 0.0155917 5.29493C0.0265333 5.28722 0.0410307 5.27951 0.0454074 5.26809C0.187921 4.87918 0.489361 4.76125 0.854809 4.73469C1.30861 4.70157 1.76159 4.65645 2.21457 4.61391C2.99826 4.54024 3.78168 4.46257 4.56564 4.39232C4.67314 4.3829 4.73277 4.34806 4.77681 4.23927C5.27739 3.00514 5.78371 1.77387 6.28702 0.540886C6.34173 0.408107 6.40628 0.283895 6.51242 0.189951C6.90741 -0.164411 7.49907 -0.00850327 7.71599 0.537174C8.20836 1.77473 8.72179 3.00286 9.22237 4.2367C9.26586 4.3435 9.32221 4.38433 9.4319 4.39261C9.88543 4.42688 10.3387 4.46971 10.7917 4.51225C11.5758 4.58592 12.3594 4.66074 13.1425 4.73669C13.314 4.75354 13.4857 4.76782 13.6406 4.86405C13.8364 4.9854 13.9275 5.18043 14 5.39116Z"
                                             fill="#FCC013" />
                                     </svg>
                                 </div>
                                 <div class="ratting-count">
                                     <p class="pera">Reviews</p>
                                 </div>
                             </div>
                         </div>
                         <div class="divider"></div>
                     </div>
                     <div class="second-section">
                         <div class="product-desc">
                             <p class="desc"><?php echo $row['product_desc']; ?></p>
                             <div class="color-palatte">
                                 <h4 class="title">Color:</h4>
                                 <div class="color-section">
                                     <?php
                                                // Lấy màu sắc từ bảng tbl_product_color
                                                $sql_color = "SELECT color FROM tbl_product_color WHERE id_product=$id_product";
                                                $result_color = $conn->query($sql_color);
                                                if ($result_color->num_rows > 0) {
                                                    while ($color_row = $result_color->fetch_assoc()) {
                                                        $color = $color_row["color"];
                                                        // Hiển thị checkbox màu tương ứng
                                                        echo '<div class="color-option">';
                                                        echo '<input class="check-color" type="checkbox" id="checkbox_' . $color . '">';
                                                        echo '<label for="checkbox_' . $color . '">';
                                                        echo '<div class="color-display" style="background-color: ' . $color . ';"></div>'; // Thêm màu nền cho label
                                                        echo '</label>';
                                                        echo '</div>';
                                                    }
                                                } else {
                                                    echo "No color options available.";
                                                }
                                                ?>
                                 </div>
                             </div>
                         </div>
                         <div class="divider"></div>
                     </div>
                     <div class="third-section">
                         <div class="row g-4">
                             <div class="col-md-3">
                                 <h4 class="label">Quantity</h4>
                             </div>
                             <div class="col-md-9">
                                 <div class="quantity-section">
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
                                     <div style="margin-top: 6px;" class="button-section"
                                         data-product-cart-id="<?php echo $row['id_product']; ?>">
                                         <a href="javascript:void(0)" class="cart-btn">Add to Cart</a>
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-3">
                                 <h4 class="label">Size</h4>
                             </div>
                             <div class="col-md-9">
                                 <div class="size-dropdown">
                                     <select name="size" class="select2">
                                         <option value="1">30 Fit by 12 Fit</option>
                                         <option value="2">20 Fit by 10 Fit</option>
                                         <option value="3">10 Fit by 08 Fit</option>
                                     </select>
                                 </div>
                             </div>
                             <div class="col-md-3">
                                 <h4 class="label">SKU</h4>
                             </div>
                             <div class="col-md-9">
                                 <p class="info">KE-91039</p>
                             </div>
                             <div class="col-md-3">
                                 <h4 class="label">Tags</h4>
                             </div>
                             <div class="col-md-9">
                                 <p class="info mb-19">Chairs, Sofa, Single Sofa</p>
                                 <p class="info highlighter d-flex align-items-center"><svg class="mr-10"
                                         xmlns="http://www.w3.org/2000/svg" width="14" height="15" viewBox="0 0 14 15"
                                         fill="none">
                                         <path
                                             d="M0.0114032 0C0.306313 0 0.601223 0 0.896132 0C0.900064 0.141012 0.910681 0.282415 0.905569 0.423426C0.900458 0.55897 0.94843 0.569907 1.06167 0.521471C1.39119 0.380068 1.73171 0.270305 2.0797 0.182417C2.46623 0.0847634 2.86023 0.0402333 3.25541 0C3.46185 0 3.66828 0 3.87472 0C4.17631 0.0359366 4.47909 0.0613265 4.77793 0.121872C5.56121 0.280852 6.28118 0.593344 6.97835 0.974975C8.5048 1.81011 10.0902 1.96479 11.7331 1.33981C12.2218 1.15388 12.6701 0.890211 13.1215 0.632796C13.2788 0.543345 13.293 0.551158 13.293 0.725372C13.2933 3.61006 13.2926 6.49475 13.2949 9.37944C13.2949 9.48569 13.2587 9.54858 13.1659 9.60092C12.7633 9.82748 12.3508 10.0314 11.9151 10.1884C11.0056 10.5161 10.0706 10.6525 9.10642 10.5482C8.14973 10.4447 7.26225 10.1306 6.42864 9.65951C5.52818 9.15054 4.56677 8.85289 3.52397 8.86032C2.66009 8.86657 1.84574 9.08687 1.06915 9.45835C0.942925 9.5185 0.903997 9.59428 0.90439 9.72943C0.908715 11.4134 0.907142 13.0973 0.906749 14.7813C0.906749 14.8543 0.899671 14.927 0.895739 15C0.600829 15 0.30592 15 0.01101 15C0.00707783 14.932 0 14.8641 0 14.7961C0 9.93177 0 5.06784 0.000393213 0.203901C0.000393213 0.135934 0.00747105 0.067967 0.0114032 0Z"
                                             fill="#FD0202" />
                                     </svg> Report This Item</p>
                             </div>
                             <div class="col-md-3">
                                 <h4 class="label">Share</h4>
                             </div>
                             <div class="col-md-9">
                                 <div class="all-social-icon">
                                     <a href="javascript:void(0)" class="social-icon">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="10" height="16"
                                             viewBox="0 0 10 16" fill="none">
                                             <path
                                                 d="M3 15.9761V8.98656H0V5.99104H3V3.99403C3 1.29806 4.7 0 7.1 0C8.3 0 9.2 0.0998507 9.5 0.0998507V2.89567H7.8C6.5 2.89567 6.2 3.49477 6.2 4.39343V5.99104H10L9 8.98656H6.3V15.9761H3Z"
                                                 fill="#3E75B2" />
                                         </svg>
                                     </a>
                                     <a href="javascript:void(0)" class="social-icon">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             viewBox="0 0 16 16" fill="none">
                                             <path
                                                 d="M8 0C3.6 0 0 3.59463 0 7.98806C0 11.383 2.1 14.2787 5.1 15.377C5 14.7779 5 13.7794 5.1 13.0804C5.2 12.4813 6 9.08641 6 9.08641C6 9.08641 5.8 8.68701 5.8 7.98806C5.8 6.8897 6.5 5.99104 7.3 5.99104C8 5.99104 8.3 6.4903 8.3 7.0894C8.3 7.78835 7.9 8.78686 7.6 9.78537C7.4 10.5842 8 11.1833 8.8 11.1833C10.2 11.1833 11.3 9.68552 11.3 7.4888C11.3 5.59164 9.9 4.19373 8 4.19373C5.7 4.19373 4.4 5.89119 4.4 7.6885C4.4 8.38746 4.7 9.08641 5 9.48582C5 9.68552 5 9.78537 5 9.88522C4.9 10.1848 4.8 10.684 4.8 10.7839C4.8 10.8837 4.7 10.9836 4.5 10.8837C3.5 10.3845 2.9 8.98656 2.9 7.78835C2.9 5.29209 4.7 2.99552 8.2 2.99552C11 2.99552 13.1 4.99254 13.1 7.58865C13.1 10.3845 11.4 12.5812 8.9 12.5812C8.1 12.5812 7.3 12.1818 7.1 11.6825C7.1 11.6825 6.7 13.1803 6.6 13.5797C6.4 14.2787 5.9 15.1773 5.6 15.6766C6.4 15.8763 7.2 15.9761 8 15.9761C12.4 15.9761 16 12.3815 16 7.98806C16 3.59463 12.4 0 8 0Z"
                                                 fill="#E12828" />
                                         </svg>
                                     </a>
                                     <a href="javascript:void(0)" class="social-icon">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14"
                                             viewBox="0 0 18 14" fill="none">
                                             <path
                                                 d="M17.0722 1.59813C16.432 1.88224 15.7562 2.05981 15.0448 2.16635C15.7562 1.74018 16.3253 1.06542 16.5742 0.248597C15.8985 0.639251 15.1515 0.923362 14.3335 1.10093C13.6933 0.426167 12.7686 0 11.7727 0C9.85206 0 8.28711 1.56261 8.28711 3.48036C8.28711 3.76447 8.32268 4.01307 8.39382 4.26167C5.51289 4.11961 2.9165 2.73457 1.17371 0.603737C0.889175 1.13645 0.71134 1.70467 0.71134 2.34392C0.71134 3.55139 1.31598 4.61681 2.27629 5.25606C1.70722 5.22055 1.17371 5.07849 0.675773 4.82989V4.86541C0.675773 6.57007 1.88505 7.99063 3.48557 8.31026C3.20103 8.38128 2.88093 8.4168 2.56082 8.4168C2.34742 8.4168 2.09845 8.38128 1.88505 8.34577C2.34742 9.73081 3.62784 10.7607 5.15722 10.7607C3.94794 11.6841 2.45412 12.2523 0.818041 12.2523C0.533505 12.2523 0.248969 12.2523 0 12.2168C1.56495 13.2112 3.37887 13.7794 5.37062 13.7794C11.8082 13.7794 15.3294 8.45231 15.3294 3.8355C15.3294 3.69345 15.3294 3.51588 15.3294 3.37382C16.0052 2.91214 16.6098 2.3084 17.0722 1.59813Z"
                                                 fill="#3FD1FF" />
                                         </svg>
                                     </a>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!-- End-of product area-->

 <!-- More details area S t a r t -->
 <div class="more-details-area">
     <div class="container">
         <div class="more-details-section">
             <div class="row g-4">
                 <div class="col-xl-5">

                     <div class="all-outline-btn">
                         <ul class="nav all-outline-btn" id="pills-tab" role="tablist">
                             <li class="nav-item" role="presentation">
                                 <button class="nav-link outline-pill-btn active" id="pills-home-tab"
                                     data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab"
                                     aria-controls="pills-home" aria-selected="true">

                                     Description
                                     <svg xmlns="http://www.w3.org/2000/svg" width="78" height="19" viewBox="0 0 78 19"
                                         fill="none">
                                         <path
                                             d="M66.918 10.9147C66.8987 10.9909 66.8754 11.0659 66.8482 11.1394C66.3343 12.5191 65.8568 13.9149 65.3832 15.3094C65.2835 15.6007 65.0431 15.8908 65.3278 16.3278C68.9295 13.4161 73.0932 11.4878 77.3487 9.65131C72.9717 7.73141 68.8104 5.59576 65.0804 2.61703C64.8556 3.06744 65.0978 3.36045 65.2072 3.6577C65.7259 5.06223 66.2433 6.47061 66.7965 7.85894C67.1854 8.84516 67.2283 9.92384 66.918 10.9147Z"
                                             fill="currentColor" />
                                         <rect y="8.90649" width="68" height="1" rx="0.5" fill="currentColor" />
                                     </svg>

                                 </button>
                             </li>
                             <li class="nav-item" role="presentation">
                                 <button class="nav-link outline-pill-btn " id="pills-contact-tab" data-bs-toggle="pill"
                                     data-bs-target="#pills-contact" type="button" role="tab"
                                     aria-controls="pills-contact" aria-selected="false">

                                     Reviews
                                     <svg xmlns="http://www.w3.org/2000/svg" width="78" height="19" viewBox="0 0 78 19"
                                         fill="none">
                                         <path
                                             d="M66.918 10.9147C66.8987 10.9909 66.8754 11.0659 66.8482 11.1394C66.3343 12.5191 65.8568 13.9149 65.3832 15.3094C65.2835 15.6007 65.0431 15.8908 65.3278 16.3278C68.9295 13.4161 73.0932 11.4878 77.3487 9.65131C72.9717 7.73141 68.8104 5.59576 65.0804 2.61703C64.8556 3.06744 65.0978 3.36045 65.2072 3.6577C65.7259 5.06223 66.2433 6.47061 66.7965 7.85894C67.1854 8.84516 67.2283 9.92384 66.918 10.9147Z"
                                             fill="currentColor" />
                                         <rect y="8.90649" width="68" height="1" rx="0.5" fill="currentColor" />
                                     </svg>

                                 </button>
                             </li>
                         </ul>
                     </div>
                 </div>
                 <div class="col-xl-7">

                     <div class="tab-content" id="pills-tabContent">
                         <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                             aria-labelledby="pills-home-tab">

                             <!-- Tab Content -->
                             <div class="addition-desc">
                                 <p class="pera">
                                     <?php echo $row['product_desc']; ?>
                                 </p>
                             </div>
                             <!-- End Tab contents -->

                         </div>
                         <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                             aria-labelledby="pills-contact-tab">.

                             <!-- Tab Content -->
                             <div class="review-list">
                                 <?php
                                            // Đảm bảo rằng $row['id_product'] có giá trị hợp lệ
                                            if (isset($row['id_product'])) {
                                                $feedbacks = getFeedbacks($row['id_product']); // Gọi hàm để lấy phản hồi
                                                foreach ($feedbacks as $feedback) {
                                            ?>
                                 <div class="review-card">
                                     <div class="wrap-user">
                                         <div class="user-img">
                                             <img src="assets/images/product/user-1.png" alt="img">
                                         </div>
                                         <div class="wrap-info">
                                             <div class="user-info">
                                                 <div class="name-ratting">
                                                     <div class="name-wrapper">
                                                         <h4 class="name">
                                                             <?php echo htmlspecialchars($feedback['email_customer']); ?>
                                                         </h4>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="user-comment">
                                                 <p class="pera"><?php echo htmlspecialchars($feedback['feedback']); ?>
                                                 </p>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <?php
                                                }
                                            } else {
                                                echo "Không tìm thấy sản phẩm.";
                                            }
                                            ?>
                             </div>


                         </div>
                         <!-- End Tab contents -->

                     </div>
                 </div>

             </div>
         </div>
     </div>

 </div>
 </div>
 <!-- End-of more details area-->
 <!-- Related Product S t a r t -->
 <section class="related-product feature-area section-padding2">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <div class="section-title">
                     <h4 class="title">Related Products</h4>
                 </div>
                 <div class="swiper featureSwiper-active">
                     <div class="swiper-wrapper">
                         <?php
                                    if ($result1->num_rows > 0) {
                                        // Lặp qua các sản phẩm và hiển thị chúng
                                        while ($row1 = $result1->fetch_assoc()) {
                                    ?>
                         <div class="swiper-slide">
                             <div class="product-card feature-card h-calc" style="background-color:#d9d5d5;">
                                 <div class="top-card">
                                     <div class="price-section">
                                         <h4 class="price discounted"><?php echo $row1['product_price'] ?></h4>
                                         <h4 class="price text-color-primary"><?php echo $row1['product_price_sales'] ?>
                                         </h4>
                                     </div>
                                     <button class="wishlist-icon" data-product-id="<?php echo $row1['id_product']; ?>">
                                         <img src="assets/images/icon/wish-icon-2.png" alt="img">
                                     </button>
                                 </div>
                                 <div class="product-img-card feature-img-card">
                                     <a href="index.php?quanly=Shop_details&id=<?php echo $row1['id_product']; ?>"
                                         class="zoomImg">
                                         <img style="width:166px; height:166px"
                                             src="admin/modules/quanlysanpham/images/<?php echo $row1['product_img']; ?>"
                                             alt="img">
                                     </a>
                                     <div class="discount-badge">
                                         <span
                                             class="percentage"><?php echo 100 - ($row1['product_price_sales'] * 100 / $row1['product_price']) ?>%</span>
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
                                 <a href="index.php?quanly=Shop_details&id=<?php echo $row1['id_product']; ?>">
                                     <h4 style="font-size: 10px;" class="product-title line-clamp-1">
                                         <p><strong><?php echo $row1['product_name']; ?></strong></p>
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
                                     <a href="index.php?quanly=Shop_details&id=<?php echo $row1['id_product']; ?>">
                                         <h4 class="product-title line-clamp-1">
                                             <p><strong><?php echo $row1['product_name']; ?></strong></p>
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
                                         data-product-cart-id="<?php echo $row1['id_product']; ?>">
                                         <a href="javascript:void(0)" class="cart-btn">Add to Cart</a>
                                         <div class="fill-pill-btn qty-btn">
                                             <div class="qty-container featury-qty-container">
                                                 <div class="qty-btn-minus qty-btn mr-1">
                                                     <i class="ri-subtract-fill"></i>
                                                 </div>
                                                 <input type="text" name="qty" value="1"
                                                     class="input-qty input-rounded">
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
                     <div class="swiper-button-next swiper-common-btn"><i class="ri-arrow-right-s-line"></i></div>
                     <div class="swiper-button-prev swiper-common-btn"><i class="ri-arrow-left-s-line"></i></div>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <?php
        }
    } else {
        echo "Không tìm thấy sản phẩm!";
    }
    ?>


 <script>
$(document).ready(function() {
    $('.xzoom').xzoom({
        Xoffset: 15, // X offset of zoom box from the original image (default: 0)
        Yoffset: 15 // Y offset of zoom box from the original image (default: 0)

    });
});
 </script>
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
    var quantity = $(this).closest('.quantity-section').find('.input-qty').val();
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
                // Update cart count display without reloading the page
                $('.cart-count').text(response.cartCount);
                console.log('Sản phẩm được thêm thành công');
            } else {
                // Handle error
                alert('Đã xảy ra lỗi khi cập nhật giỏ hàng: ' + response.message);
            }
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