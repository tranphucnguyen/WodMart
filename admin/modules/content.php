 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
     <!-- Content Header (Page header) -->
     <!-- /.content-header -->

     <!-- Main content -->
     <section class="content">
         <div class="container-fluid">
             <?php
                if (isset($_GET['action']) && $_GET['query']) {
                    $action = $_GET['action'];
                    $query = $_GET['query'];
                } else {
                    $action = '';
                    $query = '';
                }
                if ($action == 'danhmucbaibao' && $query == 'them') {
                    include("danhmucbaibao/add_category.php");
                } elseif ($action == 'danhmucbaibao' && $query == 'lietke') {
                    include("danhmucbaibao/list_category.php");
                } elseif ($action == 'danhmucbaibao' && $query == 'edit') {
                    include("danhmucbaibao/edit_category.php");
                } elseif ($action == 'quanlyslider' && $query == 'them') {
                    include("quanlyslider/add_slide.php");
                } elseif ($action == 'quanlyslider' && $query == 'lietke') {
                    include("quanlyslider/list_slide.php");
                } elseif ($action == 'quanlyslider' && $query == 'edit') {
                    include("quanlyslider/edit_slide.php");
                } elseif ($action == 'danhmuccon' && $query == 'them') {
                    include("danhmuccon/add_subcategory.php");
                } elseif ($action == 'danhmuccon' && $query == 'lietke') {
                    include("danhmuccon/list_subcategory.php");
                } elseif ($action == 'danhmuccon' && $query == 'edit') {
                    include("danhmuccon/edit_subcategory.php");
                } elseif ($action == 'quanlysanpham' && $query == 'them') {
                    include("quanlysanpham/add_product.php");
                } elseif ($action == 'quanlysanpham' && $query == 'lietke') {
                    include("quanlysanpham/list_product.php");
                } elseif ($action == 'quanlysanpham' && $query == 'edit') {
                    include("quanlysanpham/edit_product.php");
                } elseif ($action == 'quanlykhachhang' && $query == 'lietke') {
                    include("quanlykhachhang/list_feedback.php");
                } elseif ($action == 'quanlykhachhang' && $query == 'feedback') {
                    include("quanlykhachhang/feedback.php");
                } elseif ($action == 'quanlykhachhang' && $query == 'list_customer') {
                    include("quanlykhachhang/list_customer.php");
                } elseif ($action == 'quanlydonhang' && $query == 'lietke') {
                    include("quanlydonhang/list_order.php");
                } else {
                    include("trangchu.php");
                }
                ?>
         </div><!-- /.container-fluid -->
     </section>
     <!-- /.content -->
 </div>