<section class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="breadcrumb-text">
            <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Forgot Password</h1>
            <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                <ul class="breadcrumb listing">
                    <li class="breadcrumb-item single-list"><a href="index.php?quanly" class="single">Home</a></li>
                    <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                            class="single active">Forgot Password</a></li>
                </ul>
            </nav>
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
                    <form action="controllers/ForgotPasswordController.php" method="POST">
                        <div class="contact-form mb-24">
                            <label class="contact-label">Email </label>
                            <input class="form-control contact-input" name="email" type="email"
                                placeholder="Enter Your Email" required>
                        </div>
                        <button type="submit" class="btn btn-primary-fill justify-content-center w-100">
                            <span>Reset Password</span>
                        </button>
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