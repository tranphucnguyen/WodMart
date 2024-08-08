<!-- Breadcrumbs S t a r t -->
<section class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Verification</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index.php?quanly" class="single">Home</a>
                            </li>
                            <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                    class="single active">Verification</a></li>
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
                    <form action="controllers/Verification.php" method="POST">
                        <div class="contact-form">
                            <label class="contact-label">Verification Code</label>
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="contact-form mb-24">
                                    <input class="form-control contact-input text-center" name="verification_code[]"
                                        type="text" maxlength="1" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="contact-form mb-24">
                                    <input class="form-control contact-input text-center" name="verification_code[]"
                                        type="text" maxlength="1" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="contact-form mb-24">
                                    <input class="form-control contact-input text-center" name="verification_code[]"
                                        type="text" maxlength="1" required>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="contact-form mb-24">
                                    <input class="form-control contact-input text-center" name="verification_code[]"
                                        type="text" maxlength="1" required>
                                </div>
                            </div>

                        </div>
                        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                        <button type="submit" class="btn-primary-fill justify-content-center w-100">
                            <span class="d-flex justify-content-center gap-6">
                                <i class="ri-lock-line"></i>
                                <span>Verify</span>
                            </span>
                        </button>
                        <?php if (isset($error_message)) {
                            echo '<div class="alert alert-danger mt-3">' . $error_message . '</div>';
                        } ?>
                    </form>

                    <div class="login-footer">
                        <div class="create-account">
                            <p class="mb-0">
                                Go back to
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