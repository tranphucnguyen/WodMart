<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Subcategory Add</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Subcategory Add</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <form id="subcategoryForm" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Danh mục con</h3>

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
                                <!-- Categories will be loaded here by JavaScript -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subcategoryName">Subcategory Name</label>
                            <input type="text" name="subcategory_name" id="subcategoryName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="subcategoryDate">Subcategory Date</label>
                            <input type="date" name="subcategory_date" id="subcategoryDate" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="subcategoryStatus">Status</label>
                            <select name="subcategory_status" id="subcategoryStatus" class="form-control custom-select">
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
                <input type="submit" value="Create new Subcategory" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>
<script>
$(document).ready(function() {
    // Load categories for the select box
    $.ajax({
        url: 'controller/CategoryController.php?action=list',
        method: 'GET',
        success: function(response) {
            var categories = JSON.parse(response);
            var categorySelect = $('#categorySelect');
            categorySelect.empty();
            categories.forEach(function(category) {
                categorySelect.append(new Option(category.category_name, category
                    .id_category));
            });
        },
        error: function() {
            console.error('Failed to fetch categories.');
        }
    });

    // Handle form submission
    $('#subcategoryForm').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'controller/SubcategoryController.php?action=add',
            data: formData,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    alert('Subcategory added successfully!');
                    window.location.href = 'index.php?action=danhmuccon&query=them';
                } else {
                    alert('Error adding subcategory: ' + result.message);
                }
            },
            error: function() {
                alert('Error adding subcategory.');
            }
        });
    });
});
</script>