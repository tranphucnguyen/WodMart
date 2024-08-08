<?php
include("config/config.php");

$id = $_GET['id'];
$query = "SELECT * FROM tbl_category WHERE id_category = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Category Edit</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Category Edit</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <form id="editCategoryForm" method="post">
        <input type="hidden" name="id_category" value="<?php echo $category['id_category']; ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Danh mục bài báo</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputName">Category Name</label>
                            <input type="text" name="category_name" id="inputName" class="form-control" value="<?php echo $category['category_name']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <select name="category_status" id="inputStatus" class="form-control custom-select">
                                <option value="1" <?php echo $category['category_status'] == 1 ? 'selected' : ''; ?>>
                                    Active</option>
                                <option value="0" <?php echo $category['category_status'] == 0 ? 'selected' : ''; ?>>
                                    Inactive</option>
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
                <input type="submit" value="Update Category" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<script>
    $(document).ready(function() {
        $('#editCategoryForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: 'controller/CategoryController.php?action=update',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert('Category updated successfully!');
                        window.location.href = 'index.php?action=danhmucbaibao&query=them';
                    } else {
                        alert('Error updating category: ' + result.message);
                    }
                },
                error: function() {
                    alert('Failed to update category.');
                }
            });
        });
    });
</script>