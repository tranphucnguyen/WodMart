<?php
include('config/config.php');

// Khởi tạo mảng để lưu danh sách đơn hàng
$orders = array();

// Truy vấn danh sách đơn hàng từ cơ sở dữ liệu
$sql = "SELECT * FROM tbl_order ORDER BY order_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Lấy id_order của đơn hàng hiện tại
        $order_id = $row['id_order'];

        // Truy vấn để lấy thông tin tỉnh/thành phố, quận/huyện, và phường/xã từ các bảng liên quan
        $detail_sql = "SELECT op.name_provinces, od.name_districts, ot.name_town
                       FROM tbl_order o
                       LEFT JOIN tbl_provinces op ON o.id_provinces = op.id_provinces
                       LEFT JOIN tbl_districts od ON o.id_districts = od.id_districts
                       LEFT JOIN tbl_town ot ON o.id_town = ot.id_town
                       WHERE o.id_order = '$order_id'";
        $detail_result = $conn->query($detail_sql);

        if ($detail_result->num_rows > 0) {
            $detail_row = $detail_result->fetch_assoc();
            $row['name_provinces'] = $detail_row['name_provinces'];
            $row['name_districts'] = $detail_row['name_districts'];
            $row['name_town'] = $detail_row['name_town'];
        } else {
            $row['name_provinces'] = "Không có thông tin";
            $row['name_districts'] = "Không có thông tin";
            $row['name_town'] = "Không có thông tin";
        }

        // Truy vấn để lấy chi tiết đơn hàng từ bảng tbl_order_detail
        $order_detail_sql = "SELECT * FROM tbl_order_detail WHERE id_order = '$order_id'";
        $order_detail_result = $conn->query($order_detail_sql);
        $order_details = array();

        if ($order_detail_result->num_rows > 0) {
            while ($detail_row = $order_detail_result->fetch_assoc()) {
                $order_details[] = $detail_row;
            }
        }

        $row['order_details'] = $order_details;
        $orders[] = $row;
    }
}

?>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Order</h3>
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
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Email customer</th>
                        <th>Phone customer</th>
                        <th>Payment method</th>
                        <th>Order Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="orderList">
                    <?php
                    foreach ($orders as $index => $order) {
                        echo "<tr>";
                        echo "<td>" . ($index + 1) . "</td>";
                        echo "<td>" . strip_tags($order['first_name']) . "</td>";
                        echo "<td>" . strip_tags($order['last_name']) . "</td>";
                        echo "<td>" . strip_tags($order['email_customer']) . "</td>";
                        echo "<td>" . strip_tags($order['phone_customer']) . "</td>";
                        echo "<td>" . strip_tags($order['payment_method']) . "</td>";
                        if ($order['order_status'] == 0) {
                            echo "<td>Chưa giao</td>";
                        } elseif ($order['order_status'] == 1) {
                            echo "<td>Đang giao</td>";
                        } else {
                            echo "<td>Lỗi</td>";
                        }
                        echo "<td><button type='button' class='btn btn-primary view-order' data-toggle='modal' data-target='#exampleModalCenter' data-order='" . json_encode($order) . "'>Xem</button></td>";
                        echo "<td><button type='button' class='btn btn-danger delete-order' data-order-id='" . $order['id_order'] . "'>Xóa</button></td>";
                        echo "</tr>";
                    }
                    ?>
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

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Chi tiết đơn hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="orderDetails"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary ship-order"
                    data-order-id="<?php echo $order['id_order']; ?>">Giao hàng</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="feedbackModalTitle">Đánh giá đơn hàng</h1>
            </div>

            <div class="modal-body">
                <div id="feedbackDetails">
                    <!-- Thông tin đánh giá sản phẩm sẽ được thêm vào đây -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-feedback" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    bottom: 10px;
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
    var orderPerPage = 5;
    var totalPages = Math.ceil(<?php echo count($orders); ?> / orderPerPage);

    // Sự kiện click cho nút Previous
    $('.prev-btn').click(function() {
        if (currentPage > 1) {
            currentPage--;
            loadOrders(currentPage);
        }
    });

    // Sự kiện click cho nút Next
    $('.next-btn').click(function() {
        if (currentPage < totalPages) {
            currentPage++;
            loadOrders(currentPage);
        }
    });

    // Event delegation for delete buttons
    $(document).on('click', '.delete-order', function() {
        var orderId = $(this).data('order-id');
        var row = $(this).closest('tr');
        deleteOrder(orderId, row);
    });

    // Cập nhật thông tin phân trang
    function updatePaginationInfo() {
        $('.page-info').text(`Trang ${currentPage} trên ${totalPages}`);
    }

    // Hàm xóa đơn hàng
    function deleteOrder(orderId, row) {
        $.ajax({
            url: 'controller/OrderController.php',
            type: 'POST',
            data: {
                orderId: orderId
            },
            success: function(response) {
                if (response.success) {
                    alert('Xóa đơn hàng thành công');
                    row.remove(); // Remove the deleted order's row from the table
                    loadOrders(currentPage); // Reload orders to update pagination info
                    location.reload();
                } else {
                    alert('Xóa đơn hàng thất bại');
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi xóa đơn hàng');
            }
        });
    }

    // Load orders based on the current page
    function loadOrders(page) {
        var start = (page - 1) * orderPerPage;
        var end = start + orderPerPage;

        $('#orderList').empty();
        var displayedOrders = <?php echo json_encode($orders); ?>.slice(start, end);

        displayedOrders.forEach(function(order, index) {
            var orderHtml = `
                    <tr>
                        <td>${start + index + 1}</td>
                        <td>${order.first_name}</td>
                        <td>${order.last_name}</td>
                        <td>${order.email_customer}</td>
                        <td>${order.phone_customer}</td>
                        <td>${order.payment_method}</td>
                        <td>${order.order_status == 0 ? 'Chưa giao' : order.order_status == 1 ? 'Đang giao' : order.order_status == 2 ? 'Đã nhận' : 'Lỗi'}</td>
                        <td><button type='button' class='btn btn-primary view-order' data-toggle='modal' data-target='#exampleModalCenter' data-order='${JSON.stringify(order)}'>Xem</button></td>
                        ${order.order_status == 2 ? "<td><button type='button' class='btn btn-primary feedback-order' data-order-id='" + order.id_order + "'>Xem đánh giá</button></td>" : ""}
                        <td><button type='button' class='btn btn-danger delete-order' data-order-id='${order.id_order}'>Xóa</button></td>
                    </tr>
                `;
            $('#orderList').append(orderHtml);
        });

        updatePaginationInfo();
    }

    loadOrders(currentPage);

    // Xem chi tiết đơn hàng
    $(document).on('click', '.view-order', function() {
        var order = $(this).data('order');
        var orderDetailsHtml = `
                <p>Họ: ${order.first_name}</p>
                <p>Tên: ${order.last_name}</p>
                <p>Email: ${order.email_customer}</p>
                <p>Số điện thoại: ${order.phone_customer}</p>
                <p>Địa chỉ: ${order.address_customer}</p>
                <p>Thành phố: ${order.name_provinces}</p>
                <p>Quận huyện: ${order.name_districts}</p>
                <p>Phường xã: ${order.name_town}</p>
                <p>Ngày đặt hàng: ${order.order_date}</p>
                <p>Phương thức thanh toán: ${order.payment_method}</p>
            `;

        order.order_details.forEach(function(detail) {
            var product_name_clean = detail.product_name.replace(/<\/?[^>]+(>|$)/g, "");
            orderDetailsHtml += `
                    <p>Sản phẩm: ${product_name_clean}</p>
                    <p>Số lượng: ${detail.quantity}</p>
                    <p>Giá: ${detail.total_price}</p>
                `;
        });

        $('#orderDetails').html(orderDetailsHtml);
        $('.ship-order').data('order-id', order.id_order);
    });

    $(document).on('click', '.ship-order', function() {
        var orderId = $(this).data('order-id');

        $.ajax({
            url: 'controller/UpdateOrderStatus.php',
            type: 'POST',
            data: {
                orderId: orderId // đổi 'order_id' thành 'orderId'
            },
            success: function(response) {
                var res = JSON.parse(response);
                if (res.success) {
                    alert("Order status updated and order is being shipped.");
                    // window.location.reload();
                } else {
                    alert("Failed to update order status.");
                }
            },
            error: function() {
                alert("An error occurred while updating the order status.");
            }
        });
    });

});
</script>
<script>
$(document).ready(function() {
    // Khi button đánh giá được nhấn
    $(document).on('click', '.feedback-order', function() {
        var orderId = $(this).data('order-id'); // Lấy id_order từ data attribute của button

        // Gửi yêu cầu AJAX để lấy đánh giá từ server
        $.ajax({
            url: 'controller/Get_feedback.php',
            type: 'GET',
            data: {
                id_order: orderId
            },
            success: function(response) {
                if (response.success) {
                    var feedbackHtml = '';

                    // Duyệt qua từng sản phẩm và thêm thông tin đánh giá vào modal
                    response.feedback.forEach(function(item, index) {
                        var showButtonDisabled = item.feedback_status == 1 ?
                            'disabled-button' : '';
                        var hideButtonDisabled = item.feedback_status == 0 ?
                            'disabled-button' : '';

                        feedbackHtml += `
                            <div class="mb-3">
                                <h6 class="text-primary">Đánh giá sản phẩm ${item.product_name}</h6>
                                <p>${item.feedback}</p>
                                <button type="button" class="btn btn-primary show-feedback ${showButtonDisabled}" data-product-id="${item.id_product}" data-feedback-id="${item.id_feedback_order}">Hiển thị đánh giá</button>
                                <button type="button" class="btn btn-secondary hide-feedback ${hideButtonDisabled}" data-product-id="${item.id_product}" data-feedback-id="${item.id_feedback_order}">Ẩn đánh giá</button>
                            </div>
                        `;
                    });

                    // Hiển thị danh sách đánh giá trong modal
                    $('#feedbackDetails').html(feedbackHtml);
                    $('#feedbackModal').modal('show'); // Hiển thị modal feedback
                } else {
                    alert("Không có đánh giá cho đơn hàng này.");
                }
            },
            error: function() {
                alert("Đã xảy ra lỗi khi lấy đánh giá.");
            }
        });
    });

    // Xử lý sự kiện khi nhấn vào nút "Hiển thị đánh giá"
    $(document).on('click', '.show-feedback', function() {
        var productId = $(this).data('product-id');
        var feedbackId = $(this).data('feedback-id');

        var showButton = $(this);
        var hideButton = $(this).siblings('.hide-feedback');

        $.ajax({
            url: 'controller/Update_feedback_status.php', // Đường dẫn tới script cập nhật feedback_status
            type: 'POST',
            data: {
                id_product: productId,
                id_feedback_order: feedbackId,
                feedback_status: 1 // Cập nhật feedback_status thành 1 khi hiển thị đánh giá
            },
            success: function(response) {
                if (response.success) {
                    showButton.addClass('disabled-button');
                    hideButton.removeClass('disabled-button');
                } else {
                    console.log("Không thể cập nhật feedback_status.");
                }
            },
            error: function() {
                console.log("Đã xảy ra lỗi khi cập nhật feedback_status.");
            }
        });
    });

    // Xử lý sự kiện khi nhấn vào nút "Ẩn đánh giá"
    $(document).on('click', '.hide-feedback', function() {
        var productId = $(this).data('product-id');
        var feedbackId = $(this).data('feedback-id');

        var hideButton = $(this);
        var showButton = $(this).siblings('.show-feedback');

        $.ajax({
            url: 'controller/Update_feedback_status.php', // Đường dẫn tới script cập nhật feedback_status
            type: 'POST',
            data: {
                id_product: productId,
                id_feedback_order: feedbackId,
                feedback_status: 0 // Cập nhật feedback_status thành 0 khi ẩn đánh giá
            },
            success: function(response) {
                if (response.success) {
                    hideButton.addClass('disabled-button');
                    showButton.removeClass('disabled-button');
                } else {
                    console.log("Không thể cập nhật feedback_status.");
                }
            },
            error: function() {
                console.log("Đã xảy ra lỗi khi cập nhật feedback_status.");
            }
        });
    });
});
</script>
<style>
.disabled-button {
    pointer-events: none;
    /* Không thể tương tác */
    opacity: 0.5;
    /* Làm cho nút chìm xuống */
}
</style>