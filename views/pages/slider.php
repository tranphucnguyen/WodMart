<?php
// Kết nối CSDL
include("admin/config/config.php");

// Truy vấn để lấy các slide có slide_status == 1
$sql = "SELECT * FROM tbl_slide WHERE slide_status = 1";
$result = mysqli_query($conn, $sql);


?>
<style>
b,
strong {
    font-weight: bolder;
    font-size: 60px;
    color: black;
}
</style>
<!-- Hero area S t a r t-->
<section class="hero-area-bg hero-padding1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="swiper heroSwiperOne-active">
                    <div class="swiper-wrapper" id="dynamicSlides">
                        <!-- Các slider sẽ được thêm vào đây bằng AJAX -->
                    </div>
                    <div class="swiper-button-next"><i class="ri-arrow-right-s-line"></i></div>
                    <div class="swiper-button-prev"><i class="ri-arrow-left-s-line"></i></div>
                </div>
            </div>
        </div>
    </div>
    <!-- shape 01 -->
    <div class="shape-one heartbeat2">
        <img src="assets/images/hero/hero-shape.png" alt="img">
    </div>
    <!-- shape 02 -->
    <div class="shape-two routedOne">
        <img src="assets/images/hero/hero-shape.png" alt="img">
    </div>
</section>
<!-- End-of Hero-->
<!-- Brand S t a r t -->
<section class="brand-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h4 class="title">Brands</h4>
                </div>
                <div class="swiper brandSwiper-active">

                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="assets/images/brand/1.svg" alt="img">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/2.svg" alt="img">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/3.svg" alt="img">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/4.svg" alt="img">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/5.svg" alt="img">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/6.svg" alt="img">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/7.svg" alt="img">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/8.svg" alt="img">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/1.svg" alt="img">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/2.svg" alt="img">
                        </div>
                        <div class="swiper-slide">
                            <img src="assets/images/brand/3.svg" alt="img">
                        </div>
                    </div>
                    <div class="swiper-button-next swiper-common-btn"><i class="ri-arrow-right-s-line"></i>
                    </div>
                    <div class="swiper-button-prev swiper-common-btn"><i class="ri-arrow-left-s-line"></i></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of Brand -->
<script>
// Lấy dữ liệu slide từ CSDL bằng AJAX
$.ajax({
    url: 'controllers/Get_slide.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        // Duyệt qua danh sách các slide và thêm chúng vào phần tử HTML
        var slides = response.slides;
        slides.forEach(function(slide) {
            if (slide.slide_status == 1) {
                var slideHTML = `
                        <div class="swiper-slide">
                            <div class="hero-caption-one position-relative mx-auto wow fadeInUp" data-wow-delay="0.0s">
                                <h4 class="title span">${slide.slide_name}</h4>
                            </div>
                            <div class="text-center d-block wow fadeInUp" data-wow-delay="0.1s">
                                <a href="shop.html" class="outline-pill-btn ">
                                    Explore Products
                                    <svg xmlns="http://www.w3.org/2000/svg" width="78" height="19" viewBox="0 0 78 19" fill="none">
                                        <path d="M66.918 10.9147C66.8987 10.9909 66.8754 11.0659 66.8482 11.1394C66.3343 12.5191 65.8568 13.9149 65.3832 15.3094C65.2835 15.6007 65.0431 15.8908 65.3278 16.3278C68.9295 13.4161 73.0932 11.4878 77.3487 9.65131C72.9717 7.73141 68.8104 5.59576 65.0804 2.61703C64.8556 3.06744 65.0978 3.36045 65.2072 3.6577C65.7259 5.06223 66.2433 6.47061 66.7965 7.85894C67.1854 8.84516 67.2283 9.92384 66.918 10.9147Z" fill="currentColor" />
                                        <rect y="8.90649" width="68" height="1" rx="0.5" fill="currentColor" />
                                    </svg>
                                </a>
                            </div>
                            <div class="hero-image mx-auto wow fadeInUp" data-wow-delay="0.2s">
                                <img src="admin/modules/quanlyslider/images/${slide.slide_img}" alt="img">
                            </div>
                        </div>
                    `;
                $('#dynamicSlides').append(slideHTML);
            }
        });
    }
});
</script>