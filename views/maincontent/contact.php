 <!-- Breadcrumbs S t a r t -->
 <section class="breadcrumb-section breadcrumb-bg">
     <div class="container">
         <div class="row">
             <div class="col-lg-12">
                 <div class="breadcrumb-text">
                     <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Contact Us</h1>
                     <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                         <ul class="breadcrumb listing">
                             <li class="breadcrumb-item single-list"><a href="index.php?quanly" class="single">Home</a>
                             </li>
                             <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)" class="single active">Contact Us</a></li>
                         </ul>
                     </nav>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <!-- End-of Breadcrumbs-->
 <!-- product area S t a r t -->
 <div class="product-area section-padding">
     <div class="container">
         <div class="row g-4">
             <div class="col-xxl-6 col-xl-4">
                 <iframe class="map-frame" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.0564973356586!2d105.7817877747144!3d21.030425287722423!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab4c9b15ba45%3A0x55b97db7b4bff02f!2sCMC%20Tower!5e0!3m2!1svi!2s!4v1718000686878!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
             </div>
             <div class="col-xxl-6 col-xl-8">
                 <div class="get-touch-box">
                     <div class="row g-4">
                         <div class="col-xl-6">
                             <div class="contact-card">
                                 <div class="circle-icon">
                                     <img src="assets/images/icon/call.png" alt="img">
                                 </div>
                                 <a href="javascript:void(0)">
                                     <p class="pera text-color-tertiary">024 7102 9999 |
                                         024 7101 9999</p>
                                 </a>
                             </div>
                         </div>
                         <div class="col-xl-6">
                             <div class="contact-card">
                                 <div class="circle-icon">
                                     <img src="assets/images/icon/mail.png" alt="img">
                                 </div>
                                 <a href="javascript:void(0)">
                                     <p class="pera text-color-tertiary">BIT220123@st.cmc-u.edu.vn
                                         tuyensinh@cmc-u.edu.vn</p>
                                 </a>
                             </div>
                         </div>
                         <div class="col-xl-6">
                             <div class="contact-card">
                                 <div class="circle-icon">
                                     <img src="assets/images/icon/map.png" alt="img">
                                 </div>
                                 <a href="javascript:void(0)">
                                     <p class="pera text-color-tertiary">6th Floor CMC Tower, P. Duy Tân, Dịch Vọng Hậu,
                                         Cầu Giấy, Hà Nội</p>
                                 </a>
                             </div>
                         </div>
                         <div class="col-xl-6">
                             <div class="contact-card">
                                 <div class="circle-icon">
                                     <img src="assets/images/icon/time.png" alt="img">
                                 </div>
                                 <a href="javascript:void(0)">
                                     <p class="pera text-color-tertiary">Mon - Sat : 9am - 11pm
                                         Sunday: 11am - 5pm</p>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <section class="comment-area">
                         <div class="comment-box">
                             <h4 class="title">Get In Touch With Us</h4>
                             <p class="pera">Duis gravida augue velit eu dignissim felis posuere quis. Integ ante urna
                                 gravid nec est tincidunt orci at turpis gravida. Phasellus acdr egestas odio.</p>
                             <form class="custom-form" method="POST" action="controllers/save_feedback.php">
                                 <div class="row g-4">
                                     <div class="col-xl-4 col-sm-6">
                                         <input class="form-control custom-form-control" type="text" name="name" placeholder="Name*">
                                     </div>
                                     <div class="col-xl-4 col-sm-6">
                                         <input class="form-control custom-form-control" type="text" name="email" placeholder="Email*">
                                     </div>
                                     <div class="col-xl-4 col-sm-6">
                                         <input class="form-control custom-form-control" type="int" name="phone" id="phone" placeholder="Phone Number*" pattern="[0][0-9]{9}" title="Phone number must start with 0 and contain exactly 10 digits (including the starting 0)" required>
                                         <small id="phoneError" class="text-danger"></small>
                                     </div>

                                     <div class="col-12">
                                         <textarea class="form-control custom-form-control custom-form-textarea" name="comment" placeholder="Comment" id="floatingTextarea2"></textarea>
                                     </div>
                                     <div class="col-12 mt-36">
                                         <button type="submit" class="submit-btn d-inline-block">Send Message</button>
                                     </div>
                                 </div>
                             </form>
                         </div>
                     </section>

                 </div>
             </div>
         </div>
     </div>
 </div>
 <script>
     document.getElementById('phone').addEventListener('input', function() {
         let phoneInput = this.value.trim();
         let phoneError = document.getElementById('phoneError');

         if (!phoneInput.match(/^0[0-9]{9}$/)) {
             phoneError.textContent =
                 'Phone number must start with 0 and contain exactly 10 digits (including the starting 0)';
             this.setCustomValidity('Invalid phone number');
         } else {
             phoneError.textContent = '';
             this.setCustomValidity('');
         }
     });
 </script>