<?php
include("config/config.php");

// Kiểm tra xem 'id' có tồn tại trong $_GET không
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $query = "SELECT sc.*, c.category_name, c.id_category 
              FROM tbl_subcategory sc
              INNER JOIN tbl_category c ON sc.id_category = c.id_category
              WHERE sc.id_subcategory = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $subcategory = $result->fetch_assoc();

    // Truy vấn danh sách các danh mục
    $query_categories = "SELECT * FROM tbl_category";
    $result_categories = $conn->query($query_categories);

    $stmt->close();
    $conn->close();
} else {
    echo "ID not provided";
    exit();
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Subcategory</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Edit Subcategory</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <form id="editSubcategoryForm" method="post">
        <input type="hidden" name="id_subcategory" value="<?php echo $subcategory['id_subcategory']; ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Subcategory</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputCategoryName">Category Name</label>
                            <select name="id_category" id="inputCategoryName" class="form-control custom-select">
                                <?php while ($row_category = $result_categories->fetch_assoc()) {
                                    $selected = ($subcategory['id_category'] == $row_category['id_category']) ? 'selected' : '';
                                    echo "<option value='" . $row_category['id_category'] . "' " . $selected . ">" . $row_category['category_name'] . "</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputName">Subcategory Name</label>
                            <input type="text" name="subcategory_name" id="inputName" class="form-control" value="<?php echo $subcategory['subcategory_name']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputDate">Subcategory Date</label>
                            <input type="date" name="subcategory_date" id="inputDate" class="form-control" value="<?php echo $subcategory['subcategory_date']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <select name="subcategory_status" id="inputStatus" class="form-control custom-select">
                                <option value="1" <?php echo $subcategory['subcategory_status'] == 1 ? 'selected' : ''; ?>>Active
                                </option>
                                <option value="0" <?php echo $subcategory['subcategory_status'] == 0 ? 'selected' : ''; ?>>Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="#" class="btn btn-secondary">Cancel</a>
                <input type="submit" value="Update Subcategory" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<script>
    $(document).ready(function() {
        $('#editSubcategoryForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: 'controller/SubcategoryController.php?action=update',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert('Subcategory updated successfully!');
                        // Chuyển hướng đến trang chứa ID của subcategory vừa mới chỉnh
                        window.location.href = 'index.php?action=danhmuccon&query=edit&id=' +
                            result.id_subcategory;
                    } else {
                        alert('Error updating subcategory: ' + result.message);
                    }
                },
                error: function() {
                    alert('Failed to update subcategory.');
                }
            });
        });
    });
</script>