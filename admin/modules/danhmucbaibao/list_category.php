<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Category</h3>

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
                        <th>Category name</th>
                        <th>Category status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="categoryList">
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
        var categoriesPerPage = 10;

        // Gọi AJAX để lấy danh sách danh mục
        function loadCategories(page) {
            $.ajax({
                url: 'controller/CategoryController.php?action=list',
                method: 'GET',
                success: function(response) {
                    var categories = JSON.parse(response);
                    var categoryList = $('#categoryList');
                    categoryList.empty();
                    var totalCategories = categories.length;
                    var totalPages = Math.ceil(totalCategories / categoriesPerPage);
                    var startIndex = (page - 1) * categoriesPerPage;
                    var endIndex = Math.min(startIndex + categoriesPerPage, totalCategories);

                    for (var i = startIndex; i < endIndex; i++) {
                        var category = categories[i];
                        var statusText = category.category_status == 1 ? 'Active' : 'Inactive';
                        var row = `<tr>
                                    <td>${i + 1}</td>
                                    <td>${category.category_name}</td>
                                    <td>${statusText}</td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-success btn-sm" href="index.php?action=danhmucbaibao&query=edit&id=${category.id_category}"><i class="fas fa-pencil-alt"></i> Edit </a>
                                        <button class="btn btn-danger btn-sm delete-btn" data-id="${category.id_category}"><i class="fas fa-trash"></i> Delete </button>
                                    </td>
                                </tr>`;
                        categoryList.append(row);
                    }

                    // Thêm sự kiện click cho nút Delete
                    $('.delete-btn').click(function() {
                        var categoryId = $(this).data('id');
                        deleteCategory(categoryId);
                    });

                    // Cập nhật trạng thái của các nút phân trang
                    $('.prev-btn').prop('disabled', currentPage === 1);
                    $('.next-btn').prop('disabled', currentPage === totalPages);

                    // Hiển thị thông tin số trang
                    $('.page-info').text('Page ' + currentPage + ' of ' + totalPages);
                },
                error: function() {
                    console.error('Failed to fetch categories.');
                }
            });
        }

        function deleteCategory(categoryId) {
            $.ajax({
                url: 'controller/CategoryController.php?action=delete',
                method: 'POST',
                data: {
                    id: categoryId
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        console.log('Category deleted successfully!');
                        loadCategories(currentPage);
                    } else {
                        console.error('Failed to delete category: ' + result.message);
                    }
                },
                error: function() {
                    console.error('Failed to delete category.');
                }
            });
        }

        // Sự kiện click cho nút Previous
        $('.prev-btn').click(function() {
            if (currentPage > 1) {
                currentPage--;
                loadCategories(currentPage);
            }
        });

        // Sự kiện click cho nút Next
        $('.next-btn').click(function() {
            currentPage++;
            loadCategories(currentPage);
        });

        loadCategories(currentPage);
    });
</script>