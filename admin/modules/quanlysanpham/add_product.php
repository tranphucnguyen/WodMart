<?php
// Kết nối đến cơ sở dữ liệu
include("config/config.php");

// Truy vấn danh sách category từ bảng tbl_category
$query_category = "SELECT * FROM tbl_category";
$result_category = $conn->query($query_category);

// Truy vấn danh sách subcategory từ bảng tbl_subcategory
$query_subcategory = "SELECT * FROM tbl_subcategory";
$result_subcategory = $conn->query($query_subcategory);
?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm Sản Phẩm</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Thêm Sản Phẩm</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <form id="slideForm" action="controller/ProductController.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Product</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="categorySelect">Category Name</label>
                            <select name="id_category" id="categorySelect" class="form-control custom-select">
                                <?php
                                // Hiển thị danh sách category
                                while ($row_category = $result_category->fetch_assoc()) {
                                    echo "<option value='" . $row_category['id_category'] . "'>" . $row_category['category_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subcategorySelect">Subcategory Name</label>
                            <select name="id_subcategory" id="subcategorySelect" class="form-control custom-select">
                                <?php
                                // Hiển thị danh sách subcategory
                                while ($row_subcategory = $result_subcategory->fetch_assoc()) {
                                    echo "<option value='" . $row_subcategory['id_subcategory'] . "'>" . $row_subcategory['subcategory_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="produc_name">Product name</label>
                            <textarea name="product_name" id="product_name" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_desc">Product description</label>
                            <textarea name="product_desc" id="product_desc" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_price">Product price</label>
                            <input type="number" name="product_price" id="inputPrice" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="product_price_sales">Product price sales</label>
                            <input type="number" name="product_price_sales" id="inputPriceSales" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="product_img">Product image</label>
                            <input type="file" name="product_img" class="form-control" id="product_img" required>
                        </div>
                        <div class="form-group">
                            <label for="product_img_desc">Product image descriptions</label>
                            <input type="file" name="product_img_desc[]" class="form-control" id="product_img_desc"
                                multiple>
                        </div>
                        <div class="form-group">
                            <label for="product_quantity">Số lượng sản phẩm</label>
                            <input type="number" name="product_quantity" id="product_quantity" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="product_status">Trạng thái</label>
                            <select name="product_status" id="product_status" class="form-control custom-select"
                                required>
                                <option value="">Chọn trạng thái</option>
                                <option value="1">Kích hoạt</option>
                                <option value="0">Không kích hoạt</option>
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Product Information</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Color</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="color_red" name="product_color[]"
                                    value="red">
                                <label class="form-check-label" for="color_red">
                                    <span class="color-dot color-red"></span> Red
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="color_green" name="product_color[]"
                                    value="green">
                                <label class="form-check-label" for="color_green">
                                    <span class="color-dot color-green"></span> Green
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="color_blue" name="product_color[]"
                                    value="blue">
                                <label class="form-check-label" for="color_black">
                                    <span class="color-dot color-blue"></span> Blue
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="color_yellow" name="product_color[]"
                                    value="yellow">
                                <label class="form-check-label" for="color_yellow">
                                    <span class="color-dot color-yellow"></span> Yellow
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="color_yellow" name="product_color[]"
                                    value="black">
                                <label class="form-check-label" for="color_yellow">
                                    <span class="color-dot color-black"></span> Black
                                </label>
                            </div>
                            <!-- Thêm các checkbox cho các màu sắc khác -->
                        </div>

                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">Hủy</a>
                <input type="submit" name="add_product" value="Add Product" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Lắng nghe sự kiện khi người dùng chọn category
    document.getElementById("categorySelect").addEventListener("change", function() {
        var categoryId = this.value; // Lấy id của category đã chọn

        // Gửi yêu cầu AJAX để lấy danh sách subcategory tương ứng với category đã chọn
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "controller/ProductController.php?action=list_subcategories&category_id=" +
            categoryId, true);

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var subcategories = JSON.parse(xhr
                    .responseText); // Parse danh sách subcategory từ JSON
                var subcategorySelect = document.getElementById("subcategorySelect");
                subcategorySelect.innerHTML = ""; // Xóa các tùy chọn cũ

                // Thêm các tùy chọn mới cho select box subcategory
                subcategories.forEach(function(subcategory) {
                    var option = document.createElement("option");
                    option.value = subcategory
                        .id_subcategory; // Sử dụng id_subcategory thay vì id
                    option.textContent = subcategory
                        .subcategory_name; // Sử dụng subcategory_name thay vì name
                    subcategorySelect.appendChild(option);
                });
            }
        };
        xhr.send();
    });
});
</script>