<?php
// Kết nối đến cơ sở dữ liệu
include("config/config.php");

// Lấy thông tin sản phẩm cần chỉnh sửa từ cơ sở dữ liệu
$id_product = isset($_GET['id']) ? intval($_GET['id']) : 0;
$query_product = "SELECT * FROM tbl_product WHERE id_product = ?";
$stmt_product = $conn->prepare($query_product);
$stmt_product->bind_param("i", $id_product);
$stmt_product->execute();
$result_product = $stmt_product->get_result();
$product = $result_product->fetch_assoc();

// Truy vấn danh sách category từ bảng tbl_category
$query_category = "SELECT * FROM tbl_category";
$result_category = $conn->query($query_category);

// Truy vấn danh sách subcategory từ bảng tbl_subcategory
$query_subcategory = "SELECT * FROM tbl_subcategory";
$result_subcategory = $conn->query($query_subcategory);

$product_colors = isset($product['product_color']) ? explode(',', $product['product_color']) : [];

?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Chỉnh sửa Sản Phẩm</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Chỉnh sửa Sản Phẩm</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <form id="editProductForm" action="controller/ProductController.php" method="post" enctype="multipart/form-data">
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
                        <input type="hidden" name="id_product" value="<?php echo $product['id_product']; ?>">
                        <input type="hidden" name="old_product_img" value="<?php echo $product['product_img']; ?>">
                        <div class="form-group">
                            <label for="categorySelect">Category Name</label>
                            <select name="id_category" id="categorySelect" class="form-control custom-select">
                                <?php
                                // Hiển thị danh sách category
                                while ($row_category = $result_category->fetch_assoc()) {
                                    $selected = $row_category['id_category'] == $product['id_category'] ? 'selected' : '';
                                    echo "<option value='" . $row_category['id_category'] . "' $selected>" . $row_category['category_name'] . "</option>";
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
                                    $selected = $row_subcategory['id_subcategory'] == $product['id_subcategory'] ? 'selected' : '';
                                    echo "<option value='" . $row_subcategory['id_subcategory'] . "' $selected>" . $row_subcategory['subcategory_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="product_name">Product name</label>
                            <textarea name="product_name" id="product_name" class="form-control"
                                required><?php echo $product['product_name']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_desc">Product description</label>
                            <textarea name="product_desc" id="product_desc" class="form-control"
                                required><?php echo $product['product_desc']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="product_price">Product price</label>
                            <input type="number" name="product_price" id="inputPrice" class="form-control"
                                value="<?php echo $product['product_price']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="product_price_sales">Product price sales</label>
                            <input type="number" name="product_price_sales" id="inputPriceSales" class="form-control"
                                value="<?php echo $product['product_price_sales']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="product_quantity">Số lượng sản phẩm</label>
                            <input type="number" name="product_quantity" id="product_quantity" class="form-control"
                                value="<?php echo $product['product_quantity']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="product_img">Product image</label>
                            <input type="file" name="product_img" class="form-control" id="product_img" value="">
                            <!-- Hiển thị ảnh cũ và liên kết ảnh cũ -->
                            <label for="current_product_img">
                                Current image: <span
                                    id="current_product_img"><?php echo $product['product_img']; ?></span>
                            </label>
                            <br>
                            <!-- Thêm một thẻ img để hiển thị ảnh cũ -->
                            <img id="current_product_img_preview"
                                src="modules/quanlysanpham/images/<?php echo $product['product_img']; ?>"
                                alt="Product Image" style="width: 100px;">
                            <input type="hidden" name="old_product_img" value="<?php echo $product['product_img']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="product_img_desc">Product image descriptions</label>
                            <input type="file" name="product_img_desc[]" class="form-control" id="product_img_desc"
                                multiple>
                            <?php
                            $img_desc = explode(',', $product['product_img_desc']);
                            foreach ($img_desc as $img) {
                                echo "<img src='modules/quanlysanpham/images/{$img}' alt='Product Image Desc' style='width: 50px; margin: 5px;'>";
                            }
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="product_status">Trạng thái</label>
                            <select name="product_status" id="product_status" class="form-control custom-select"
                                required>
                                <option value="1" <?php echo $product['product_status'] == '1' ? 'selected' : ''; ?>>
                                    Kích hoạt</option>
                                <option value="0" <?php echo $product['product_status'] == '0' ? 'selected' : ''; ?>>
                                    Không kích hoạt</option>
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
                            <?php
                            $colors = ['red', 'green', 'blue', 'yellow', 'black'];
                            foreach ($colors as $color) {
                                $checked = in_array($color, $product_colors) ? 'checked' : '';
                                echo "
                    <div class='form-check form-check-inline'>
                        <input class='form-check-input' type='checkbox' id='color_{$color}' name='product_color[]' value='{$color}' {$checked}>
                        <label class='form-check-label' for='color_{$color}'>
                            <span class='color-dot color-{$color}'></span> " . ucfirst($color) . "
                        </label>
                    </div>";
                            }
                            ?>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="index.php?action=quanlysanpham&query=lietke" class="btn btn-secondary">Hủy</a>
                <input type="submit" name="edit_product" value="Chỉnh sửa sản phẩm" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Xử lý sự kiện khi người dùng chọn category
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
                    option.value = subcategory.id_subcategory;
                    option.textContent = subcategory.subcategory_name;
                    subcategorySelect.appendChild(option);
                });
            }
        };
        xhr.send();
    });

    // Xử lý ảnh sản phẩm
    var fileInput = document.getElementById('product_img');
    var currentImgLabel = document.getElementById('current_product_img');
    var imgPreview = document.getElementById('current_product_img_preview');

    // Hiển thị tên ảnh cũ và ảnh cũ ban đầu
    var oldProductImg = document.querySelector('input[name="old_product_img"]').value;
    currentImgLabel.textContent = oldProductImg;
    imgPreview.src = 'modules/quanlysanpham/images/' + oldProductImg;

    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            // Nếu người dùng chọn tệp mới, cập nhật tên tệp hiển thị và ảnh mới
            currentImgLabel.textContent = fileInput.files[0].name;
            imgPreview.src = URL.createObjectURL(fileInput.files[0]);
        } else {
            // Nếu không có tệp mới, giữ nguyên tên tệp cũ và ảnh cũ
            currentImgLabel.textContent = oldProductImg;
            imgPreview.src = 'modules/quanlysanpham/images/' + oldProductImg;
        }
    });
});
</script>