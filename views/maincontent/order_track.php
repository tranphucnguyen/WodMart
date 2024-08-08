<?php
$isLoggedIn = isset($_SESSION['email_customer']);
if (!$isLoggedIn) {
} else {
    $email_customer = $_SESSION['email_customer'];
}

// Lấy email của khách hàng từ session
// Truy vấn cơ sở dữ liệu để lấy danh sách các đơn hàng của khách hàng
$query = "SELECT tbl_order.ma_dh, tbl_order.first_name, tbl_order.last_name, tbl_order.total ,tbl_order.order_status, tbl_order.id_order
          FROM tbl_order 
          WHERE tbl_order.email_customer = ?    
          ORDER BY tbl_order.id_order DESC";


$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email_customer);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$conn->close();


?>

<!-- Order Tracking Section -->
<section class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h1 class="title wow fadeInUp" data-wow-delay="0.1s">Order Tracking</h1>
                    <nav aria-label="breadcrumb" class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.0s">
                        <ul class="breadcrumb listing">
                            <li class="breadcrumb-item single-list"><a href="index-2.html" class="single">Home</a></li>
                            <li class="breadcrumb-item single-list" aria-current="page"><a href="javascript:void(0)"
                                    class="single active">Order Tracking</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End-of Breadcrumbs-->

<!-- Order Track Area Start -->
<section class="order-track-area section-padding2">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="tracking-content text-center">
                    <h4 class="title">Order Tracking</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Số TT</th>
                                <th scope="col">Mã đơn hàng</th>
                                <th scope="col">Giá đơn hàng</th>
                                <th scope="col">Tên khách hàng</th>
                                <th scope="col">Tình trạng</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<th scope='row'>" . $count++ . "</th>";
                                echo "<td>" . htmlspecialchars($row['ma_dh']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['total']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</td>";
                                if ($row['order_status'] == 0) {
                                    echo "<td>Đã xác nhận</td>";
                                } else if ($row['order_status'] == 1) {
                                    echo "<td>Đang giao hàng</td>";
                                    echo "<td><button type='button' class='btn btn-primary success-order' data-order-id='" . $row['id_order'] . "'>Đã nhận</button></td>";
                                } else if ($row['order_status'] == 2) {
                                    echo "<td>Đã giao hàng</td>";
                                    echo "<td><button type='button' class='btn btn-primary feedback-order' data-toggle='modal' data-target='#feedbackModal' data-order-id='" . $row['id_order'] . "'>Đánh giá</button></td>";
                                }
                                echo "<td><button type='button' class='btn btn-primary view-order' data-toggle='modal' data-target='#exampleModalCenter' data-order-id='" . $row['id_order'] . "'>Xem</button></td>";
                                if ($row['order_status'] == 0) {
                                    echo "<td><button type='button' class='btn btn-danger delete-order' data-order-id='" . $row['id_order'] . "'>Hủy</button></td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailModalTitle">Chi tiết đơn hàng</h5>
            </div>
            <div class="modal-body" id="orderDetailModalBody">
                <!-- Nội dung chi tiết đơn hàng sẽ được cập nhật bằng AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="orderColose" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal feedback -->
<!-- Modal feedback -->
<div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="feedbackModalTitle">Đánh giá đơn hàng</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="controllers/Feedback_order.php">
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit" value="<?php echo $id_order; ?>">Gửi
                        đánh giá</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- jQuery -->

<script>
$(document).ready(function() {
    $('.view-order').on('click', function() {
        var orderId = $(this).data('order-id');
        // Gán orderId vào nút Giao hàng
        $('.ship-order').attr('data-order-id', orderId);
        $.ajax({
            url: 'controllers/Order_details.php',
            type: 'GET',
            data: {
                id_order: orderId
            },
            success: function(response) {
                $('#orderDetailModalBody').html(
                    response); // Cập nhật nội dung chi tiết đơn hàng vào modal
                $('#orderDetailModal').modal('show'); // Hiển thị modal

            },
            error: function() {
                alert('Lỗi khi lấy chi tiết đơn hàng.');
            }
        });
    });
    $('#orderColose').on('click', function() {
        $('#orderDetailModal').modal('hide');
    });
    $('.delete-order').on('click', function() {
        var orderId = $(this).data('order-id');
        var rowToDelete = $(this).closest('tr'); // Lấy phần tử <tr> chứa nút xóa

        $.ajax({
            url: 'controllers/Delete_order.php',
            type: 'POST',
            data: {
                id_order: orderId
            },
            success: function(response) {
                if (response == 'success') {
                    alert('Đã hủy đơn hàng thành công.');
                    rowToDelete
                        .remove(); // Xóa hàng đơn hàng khỏi bảng ngay sau khi xóa thành công
                } else {
                    alert('Lỗi khi hủy đơn hàng.');
                }
            },
            error: function() {
                alert('Lỗi khi hủy đơn hàng.');
            }
        });
    });
    $('.success-order').on('click', function() {
        var orderId = $(this).data('order-id');
        var rowToUpdate = $(this).closest('tr'); // Lấy phần tử <tr> chứa nút xóa

        $.ajax({
            url: 'controllers/Update_order.php',
            type: 'POST',
            data: {
                id_order: orderId,
                order_status: 1
            },
            success: function(response) {
                if (response == 'success') {
                    alert('Đã xác nhận đơn hàng thành công.');
                    location.reload();
                } else {
                    alert('Lỗi khi xác nhận đơn hàng.');
                }
            },
            error: function() {
                alert('Lỗi khi xác nhận đơn hàng.');
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    // Khi button đánh giá được nhấn
    $('.feedback-order').on('click', function() {
        var orderId = $(this).data('order-id'); // Lấy id_order từ data attribute của button
        // Gửi yêu cầu AJAX để lấy danh sách sản phẩm
        $.ajax({
            url: 'controllers/fetch_order_details.php',
            type: 'POST',
            data: {
                id_order: orderId
            },
            success: function(response) {
                $('#feedbackModal .modal-body').html(response);
                // Cập nhật giá trị của nút submit trong modal với id_order
                $('#feedbackModal button[type="submit"]').val(orderId);
                // Mở modal feedback
                $('#feedbackModal').modal('show');
            },
            error: function() {
                alert('Lỗi khi lấy danh sách sản phẩm.');
            }
        });
    });
});
</script>