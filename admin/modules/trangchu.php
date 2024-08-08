<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3 id="total_orders">0</h3>
                        <p>Đơn hàng</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3 id="total_revenue">0 VND</h3>
                        <p>Tổng Doanh Thu</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 id="total_customers">0</h3>
                        <p>Khách hàng đăng kí</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3 id="total_products">0</h3>
                        <p>Sản phẩm</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div>
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Sales
                    </h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                            </li>

                        </ul>
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content p-0">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="revenue-chart"
                            style="position: relative; height: 300px;">
                            <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                        </div>

                    </div>
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </section>
    </div>
</section>
<!-- /.content -->
<script>
// dashboard.js
$(document).ready(function() {
    $.ajax({
        url: 'controller/TrangchuController.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#total_orders').text(data.total_orders);
            $('#total_revenue').text(new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(data.total_revenue));
            $('#total_customers').text(data.total_customers);
            $('#total_products').text(parseInt(data.total_products));

            // Chuẩn bị dữ liệu cho biểu đồ Sales
            var salesLabels = data.sales_data.map(function(item) {
                return item.order_date;
            });
            var salesData = data.sales_data.map(function(item) {
                return item.order_count;
            });

            // Vẽ biểu đồ Sales
            var ctx = document.getElementById('revenue-chart-canvas').getContext('2d');
            var revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'Số lượng đơn hàng',
                        data: salesData,
                        borderColor: 'rgba(60,141,188,0.8)',
                        backgroundColor: 'rgba(60,141,188,0.4)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day',
                                tooltipFormat: 'DD MMM YYYY'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    if (Number.isInteger(value)) {
                                        return value;
                                    }
                                },
                                stepSize: 1 // Hiển thị các giá trị nguyên
                            }
                        }
                    }
                }
            });
        },
        error: function(error) {
            console.log('Error:', error);
        }
    });
});
</script>