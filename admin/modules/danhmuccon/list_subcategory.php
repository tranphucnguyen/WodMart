<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Subcategory List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Subcategory List</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Subcategories</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Category Name</th>
                        <th>Subcategory Name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="subcategoryList">
                    <!-- Subcategories will be loaded here by JavaScript -->
                </tbody>
                <div class="pagination">
                    <button class="btn btn-primary prev-btn"><i class="fa-solid fa-arrow-left"></i></button>
                    <span class="page-info"></span>
                    <button class="btn btn-primary next-btn"><i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
<style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        bottom: 20px;
        /* You can adjust this value based on your layout */
        left: 50%;
        /* transform: translateX(-50%); */
        background: white;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);

        /* Adjust this value as needed */
    }


    .page-info {
        margin: 0 10px;
    }
</style>
<script>
    $(document).ready(function() {
        var currentPage = 1;
        var subcategoriesPerPage = 10;

        function loadSubcategories(page) {
            $.ajax({
                url: 'controller/SubcategoryController.php?action=list',
                method: 'GET',
                success: function(response) {
                    var subcategories = JSON.parse(response);
                    var subcategoryList = $('#subcategoryList');
                    subcategoryList.empty();

                    var totalSubcategories = subcategories.length;
                    var totalPages = Math.ceil(totalSubcategories / subcategoriesPerPage);
                    var startIndex = (page - 1) * subcategoriesPerPage;
                    var endIndex = Math.min(startIndex + subcategoriesPerPage, totalSubcategories);

                    for (var i = startIndex; i < endIndex; i++) {
                        var subcategory = subcategories[i];
                        var statusText = subcategory.subcategory_status == 1 ? 'Active' : 'Inactive';
                        var row = `<tr>
                                <td>${i + 1}</td>
                                <td>${subcategory.category_name}</td>
                                <td>${subcategory.subcategory_name}</td>
                                <td>${subcategory.subcategory_date}</td>
                                <td>${statusText}</td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" href="index.php?action=danhmuccon&query=edit&id=${subcategory.id_subcategory}">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-subcategory" data-id="${subcategory.id_subcategory}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>`;
                        subcategoryList.append(row);
                    }

                    // Thêm sự kiện click cho nút Delete
                    $('.delete-subcategory').click(function() {
                        var id = $(this).data('id');
                        if (confirm('Are you sure you want to delete this subcategory?')) {
                            $.ajax({
                                url: 'controller/SubcategoryController.php?action=delete',
                                method: 'POST',
                                data: {
                                    id: id
                                },
                                success: function(response) {
                                    var result = JSON.parse(response);
                                    if (result.success) {
                                        alert('Subcategory deleted successfully!');
                                        loadSubcategories(currentPage);
                                    } else {
                                        alert('Error deleting subcategory: ' +
                                            result.message);
                                    }
                                },
                                error: function() {
                                    alert('Failed to delete subcategory.');
                                }
                            });
                        }
                    });

                    // Cập nhật trạng thái của các nút phân trang
                    $('.prev-btn').prop('disabled', currentPage === 1);
                    $('.next-btn').prop('disabled', currentPage === totalPages);

                    // Hiển thị thông tin số trang
                    $('.page-info').text('Page ' + currentPage + ' of ' + totalPages);
                },
                error: function() {
                    console.error('Failed to fetch subcategories.');
                }
            });
        }

        // Sự kiện click cho nút Previous
        $('.prev-btn').click(function() {
            if (currentPage > 1) {
                currentPage--;
                loadSubcategories(currentPage);
            }
        });

        // Sự kiện click cho nút Next
        $('.next-btn').click(function() {
            currentPage++;
            loadSubcategories(currentPage);
        });

        loadSubcategories(currentPage);
    });
</script>