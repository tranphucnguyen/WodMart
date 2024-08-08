<!DOCTYPE html>
<html lang="en">

<?php
include("modules/head.php");
?>
<?php
session_start();
if (!isset($_SESSION['dangnhap'])) {
    header("location:login.php");
}
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <?php
        include("modules/navbar.php");
        include("modules/sidebar.php");
        include("modules/content.php");
        ?>

        <!-- /.navbar -->




    </div>
    <!-- ./wrapper -->
    <?php
    include("modules/script.php");
    ?>

</body>

</html>