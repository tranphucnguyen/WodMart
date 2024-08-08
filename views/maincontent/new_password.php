 <!-- Breadcrumbs S t a r t -->
 <section class="breadcrumb-section breadcrumb-bg">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <div class="breadcrumb-text">
                     <h1 class="title wow fadeInUp" data-wow-delay="0.1s">New Password</h1>
                     <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                         <ul class="breadcrumb listing">
                             <li class="breadcrumb-item single-list"><a href="index-2.html" class="single">Home</a></li>
                             <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                     class="single active">New Password</a></li>
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
                     <form action="controllers/ResetPassword.php" method="POST">
                         <!-- Password -->
                         <div class="position-relative contact-form mb-24">
                             <label class="contact-label">New Password</label>
                             <input type="password" class="form-control contact-input password-input"
                                 name="new_password" placeholder="Enter Your Password" required>
                             <i class="toggle-password ri-eye-line"></i>
                         </div>
                         <!-- Confirm Password -->
                         <div class="position-relative contact-form mb-24">
                             <label class="contact-label">Confirm Password</label>
                             <input type="password" class="form-control contact-input password-input"
                                 name="confirm_password" placeholder="Enter Your Confirm Password" required>
                             <i class="toggle-password ri-eye-line"></i>
                         </div>
                         <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                         <button type="submit" class="btn-primary-fill justify-content-center w-100">
                             <span class="d-flex justify-content-center gap-6">
                                 <span>Continue</span>
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