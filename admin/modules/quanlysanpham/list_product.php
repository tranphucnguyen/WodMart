<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Product</h3>

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
                        <th>Subcategory name</th>
                        <th>Product name</th>
                        <th>Product description</th>
                        <th>Product price</th>
                        <th>Product price sales</th>
                        <th>Quantity</th>
                        <th>Product image</th>
                        <th>Product image description</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="productList">
                </tbody>
            </table>
            <div class="pagination">
                <button class="btn btn-primary prev-btn"><i class="fa-solid fa-arrow-left"></i></button>
                <span class="page-info"></span>
                <button class="btn btn-primary next-btn"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</section>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        bottom: 10px;
        /* You can adjust this value based on your layout */
        left: 50%;
        background: white;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);

    }

    .page-info {
        margin: 0 10px;
    }
</style>

<script>
    $(document).ready(function() {
        var currentPage = 1;
        var productsPerPage = 4;

        function loadProducts(page) {
            $.ajax({
                url: 'controller/ProductController.php?action=list_products',
                method: 'GET',
                success: function(response) {
                    var products = JSON.parse(response);
                    var productList = $('#productList');
                    productList.empty();

                    var totalProducts = products.length;
                    var totalPages = Math.ceil(totalProducts / productsPerPage);
                    var startIndex = (page - 1) * productsPerPage;
                    var endIndex = Math.min(startIndex + productsPerPage, totalProducts);

                    for (var i = startIndex; i < endIndex; i++) {
                        var product = products[i];
                        var row = `<tr>
                                <td>${i + 1}</td>
                                <td style="font-size:10px">${product.category_name}</td>
                                <td style="font-size:10px">${product.subcategory_name}</td>
                                <td style="font-size:10px">${product.product_name}</td>
                                <td style="font-size:10px">${product.product_desc}</td>
                                <td style="font-size:10px">${product.product_price}</td>
                                <td style="font-size:10px">${product.product_price_sales}</td>
                                <td style="font-size:10px">${product.product_quantity}</td>
                                <td><img src="modules/quanlysanpham/images/${product.product_img}" alt="${product.product_name}" style="width: 20px;"></td>
                                <td>${product.product_img_desc.split(',').map(img => `<img src="modules/quanlysanpham/images/${img.trim()}" alt="${product.product_name}" style="width: 20px;">`).join(' ')}</td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-success btn-sm" href="index.php?action=quanlysanpham&query=edit&id=${product.id_product}"><i class="fas fa-pencil-alt"></i> Edit </a>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${product.id_product}"><i class="fas fa-trash"></i> Delete </button>
                                </td>
                            </tr>`;
                        productList.append(row);
                    }

                    // Thêm sự kiện click cho nút Delete
                    $('.delete-btn').click(function() {
                        var productId = $(this).data('id');
                        deleteProduct(productId);
                    });

                    // Cập nhật trạng thái của các nút phân trang
                    $('.prev-btn').prop('disabled', currentPage === 1);
                    $('.next-btn').prop('disabled', currentPage === totalPages);

                    // Hiển thị thông tin số trang
                    $('.page-info').text('Page ' + currentPage + ' of ' + totalPages);
                },
                error: function() {
                    console.error('Failed to fetch products.');
                }
            });
        }

        function deleteProduct(productId) {
            $.ajax({
                url: 'controller/ProductController.php?action=delete_product',
                method: 'POST',
                data: {
                    id: productId
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        console.log('Product deleted successfully!');
                        loadProducts(currentPage);
                    } else {
                        console.error('Failed to delete product: ' + result.message);
                    }
                },
                error: function() {
                    console.error('Failed to delete product.');
                }
            });
        }

        // Sự kiện click cho nút Previous
        $('.prev-btn').click(function() {
            if (currentPage > 1) {
                currentPage--;
                loadProducts(currentPage);
            }
        });

        // Sự kiện click cho nút Next
        $('.next-btn').click(function() {
            currentPage++;
            loadProducts(currentPage);
        });

        loadProducts(currentPage);
    });
</script>