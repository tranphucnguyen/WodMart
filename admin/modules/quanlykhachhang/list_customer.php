<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Customer</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Customer</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="row">

        <!-- /.col -->
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Customer</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search Mail">
                            <div class="input-group-append">
                                <div class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-tools -->
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên khách hàng</th>
                                    <th>Email khách hàng</th>
                                    <th>Mật khẩu</th>
                                    <th>Trạng thái</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="customerTableBody">
                            </tbody>
                        </table>
                        <!-- /.table -->
                    </div>
                    <!-- /.mail-box-messages -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer p-0">
                    <div class="mailbox-controls">
                        <div class="float-right">
                            <span id="paginationInfo">1-5 of 0 entries</span>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm" id="prevPage">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button type="button" class="btn btn-default btn-sm" id="nextPage">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                        <!-- /.float-right -->
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->

    </div>
    <!-- /.row -->
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCustomerForm">
                    <div class="form-group">
                        <label for="edit-username" class="col-form-label">Tên khách hàng:</label>
                        <input type="text" class="form-control" id="edit-username">
                    </div>
                    <div class="form-group">
                        <label for="edit-email" class="col-form-label">Email khách hàng:</label>
                        <input type="email" class="form-control" id="edit-email">
                    </div>
                    <div class="form-group">
                        <label for="edit-password" class="col-form-label">Mật khẩu:</label>
                        <input type="text" class="form-control" id="edit-password">
                    </div>
                    <div class="form-group">
                        <label for="edit-account-status" class="col-form-label">Trạng thái:</label>
                        <div id="edit-account-status">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="account_status"
                                    id="edit-account_status_active" value="1">
                                <label class="form-check-label" for="edit-account_status_active">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="account_status"
                                    id="edit-account_status_inactive" value="0">
                                <label class="form-check-label" for="edit-account_status_inactive">Inactive</label>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="edit-customer-id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Sửa</button>
            </div>
        </div>
    </div>
</div>
<script>
let currentPage = 1;
const itemsPerPage = 5;

// Function to fetch and display customer list
function fetchCustomerList(page = 1) {
    fetch(`controller/CustomerController.php?page=${page}&itemsPerPage=${itemsPerPage}`)
        .then(response => response.json())
        .then(data => {
            const {
                customerList,
                totalItems
            } = data;
            const customerTableBody = document.getElementById('customerTableBody');
            customerTableBody.innerHTML = ''; // Clear existing rows

            customerList.forEach((customer, index) => {
                const row = `<tr>
                                <td>${(page - 1) * itemsPerPage + index + 1}</td>
                                <td>${customer.username_customer}</td>
                                <td>${customer.email_customer}</td>
                                <td>${customer.password_customer}</td>
                                <td>${customer.account_status === 1 ? "Active" : "Inactive"}</td>
                                <td></td>
                                <td>
                                    <button style="width:29.85px; height:30.6px; " type="button" class="btn btn-primary update-btn" data-toggle="modal" data-target="#exampleModal" data-id="${customer.id_account_customer}" data-whatever="@mdo"><i class="fa-solid fa-wrench"></i></button>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${customer.id_account_customer}"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>`;
                customerTableBody.innerHTML += row;
            });

            // Thêm sự kiện click cho nút Delete
            $('.delete-btn').click(function() {
                var customerId = $(this).data('id');
                deleteCustomer(customerId);
            });
            // Update pagination info
            const paginationInfo = document.getElementById('paginationInfo');
            paginationInfo.textContent =
                `Showing ${(page - 1) * itemsPerPage + 1}-${page * itemsPerPage > totalItems ? totalItems : page * itemsPerPage} of ${totalItems} entries`;

            // Disable previous button if on first page
            document.getElementById('prevPage').disabled = page === 1;

            // Disable next button if on last page
            document.getElementById('nextPage').disabled = page * itemsPerPage >= totalItems;
        })
        .catch(error => console.error('Error fetching customer list:', error));
}

function deleteCustomer(customerId) {
    $.ajax({
        url: 'controller/CustomerController.php?action=delete_customer',
        method: 'POST',
        data: {
            id: customerId
        },
        success: function(response) {
            var result = JSON.parse(response);
            if (result.success) {
                console.log('Customer deleted successfully!');
                // Load lại danh sách khách hàng sau khi xóa thành công
                fetchCustomerList(currentPage);
            } else {
                console.error('Failed to delete Customer: ' + result.message);
            }
        },
        error: function() {
            console.error('Failed to delete customer.');
        }
    });
}

// Event listeners for pagination buttons
document.getElementById('prevPage').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        fetchCustomerList(currentPage);
    }
});

document.getElementById('nextPage').addEventListener('click', () => {
    currentPage++;
    fetchCustomerList(currentPage);
});

// Call fetchCustomerList when page is loaded
document.addEventListener('DOMContentLoaded', () => fetchCustomerList(currentPage));
</script>
<script>
$(document).on('click', '.update-btn', function() {
    var customerId = $(this).data('id');

    // Gửi yêu cầu AJAX để lấy thông tin khách hàng
    $.ajax({
        url: 'controller/CustomerController.php?action=get_customer&id=' + customerId,
        method: 'GET',
        success: function(response) {
            var customer = JSON.parse(response);

            // Điền thông tin khách hàng vào form chỉnh sửa
            $('#edit-username').val(customer.username_customer);
            $('#edit-email').val(customer.email_customer);
            $('#edit-password').val(customer.password_customer);
            $('input[name="account_status"][value="' + customer.account_status + '"]').prop(
                'checked', true);
            $('#edit-customer-id').val(customer.id_account_customer);

            // Hiển thị modal chỉnh sửa
            $('#exampleModal').modal('show');
        },
        error: function() {
            console.error('Failed to fetch customer details.');
        }
    });
});
</script>
<script>
$(document).ready(function() {
    // Xử lý sự kiện click của nút "Sửa" trong modal
    $('#exampleModal').on('click', '.btn-primary', function() {
        // Lấy các giá trị từ các trường input
        var customerId = $('#edit-customer-id').val();
        var username = $('#edit-username').val();
        var email = $('#edit-email').val();
        var password = $('#edit-password').val();
        var accountStatus = $('#edit-account-status input:checked').val();

        // Gửi yêu cầu sửa thông tin khách hàng đến backend
        $.ajax({
            url: 'controller/CustomerController.php?action=update_customer',
            method: 'POST',
            data: {
                id: customerId,
                username: username,
                email: email,
                password: password,
                account_status: accountStatus
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    console.log('Customer updated successfully!');
                    // Đóng modal sau khi sửa thành công
                    $('#exampleModal').modal('hide');
                    // Cập nhật lại danh sách khách hàng (nếu cần)
                    fetchCustomerList(
                    currentPage); // Đảm bảo fetchCustomerList() đã được định nghĩa
                } else {
                    console.error('Failed to update Customer: ' + result.message);
                    // Hiển thị thông báo lỗi (nếu cần)
                }
            },
            error: function() {
                console.error('Failed to update customer.');
                // Hiển thị thông báo lỗi (nếu cần)
            }
        });
    });
});
</script>