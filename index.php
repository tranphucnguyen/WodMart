<!DOCTYPE html>
<html lang="en" dir="ltr">

<!-- Mirrored from wodmart.vercel.app/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Jun 2024 13:26:24 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <?php
    include("views/pages/head.php");
    ?>
</head>

<body>

    <div class="loading-page" id="preloader-active">
        <div class="counter">
            <img src="assets/images/logo/logo.png" alt="img">
            <span class="number">0%</span>
            <span class="line"></span>
            <span class="line"></span>
        </div>
    </div>
    <?php
    session_start();

    include("admin/config/config.php");
    include("views/pages/header.php");
    include("views/pages/content.php");
    include("views/pages/footer.php");
    include("views/pages/script.php");
    ?>





</body>

<!-- Mirrored from wodmart.vercel.app/ by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 07 Jun 2024 13:26:41 GMT -->

</html>