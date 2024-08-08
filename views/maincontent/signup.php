<!-- Breadcrumbs S t a r t -->
<section class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Register</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index.php?quanly" class="single">Home</a>
                            </li>
                            <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                    class="single active">Register</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End-of Breadcrumbs-->

<!-- Login area S t a r t  -->
<div class="login-area section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10">
                <div class="login-card">
                    <!-- Form -->
                    <!-- Form -->
                    <form action="controllers/LoginSignupController.php" method="POST">
                        <div class="contact-form mb-24">
                            <label class="contact-label">Tên</label>
                            <input name="username_customer" class="form-control contact-input" type="text"
                                placeholder="Nhập Tên Của Bạn" required>
                        </div>
                        <div class="contact-form mb-24">
                            <label class="contact-label">Email</label>
                            <input name="email_customer" class="form-control contact-input" type="email"
                                placeholder="Email" required>
                        </div>
                        <div class="position-relative contact-form mb-24">
                            <label class="contact-label">Nhập Mật Khẩu</label>
                            <input name="password_customer" type="password"
                                class="form-control contact-input password-input" id="txtPasswordLogin"
                                placeholder="Nhập Mật Khẩu" required>
                            <i class="toggle-password ri-eye-line"></i>
                        </div>
                        <div class="position-relative contact-form mb-24">
                            <label class="contact-label">Xác Nhận Mật Khẩu</label>
                            <input name="confirm_password_customer" type="password"
                                class="form-control contact-input password-input" id="txtPasswordLogin2"
                                placeholder="Xác Nhận Mật Khẩu" required>
                            <i class="toggle-password ri-eye-line"></i>
                        </div>
                        <button type="submit" name="Register" class="btn-primary-fill justify-content-center w-100">
                            <span class="d-flex justify-content-center gap-6">
                                <span>Đăng Ký</span>
                            </span>
                        </button>
                    </form>



                    <div class="login-footer">
                        <div class="create-account">
                            <p>
                                Already have an account?
                                <a href="index.php?quanly=Login">
                                    <span class="text-primary">Login</span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ End-of Login -->