<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Category Add</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Category Add</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <form action="controller/CategoryController.php" method="post">
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
                            <input type="text" name="category_name" id="inputName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputStatus">Status</label>
                            <select name="category_status" id="inputStatus" class="form-control custom-select">
                                <option value="">Select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>

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
                <input type="submit" name="add_category" value="Create new Category"
                    class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<script>
$(document).ready(function() {
    $('#categoryForm').on('submit', function(e) {
        e.preventDefault(); // Ngăn chặn form gửi theo cách thông thường

        var formData = $(this).serialize(); // Thu thập dữ liệu từ form

        $.ajax({
            type: 'POST',
            url: 'controller/CategoryController.php',
            data: formData,
            success: function(response) {
                console.log('Response:', response);
                alert('Category added successfully!');
            },
            error: function() {
                alert('Error adding category.');
            }
        });
    });
});
</script>