<?php
include("config/config.php"); // Kết nối đến cơ sở dữ liệu
function getFeedbackById($id_feedback)
{
    global $conn; // Sử dụng biến $conn toàn cục

    $stmt = $conn->prepare("SELECT * FROM tbl_feedback WHERE id_feedback = ?");
    $stmt->bind_param("i", $id_feedback);
    $stmt->execute();
    $result = $stmt->get_result();

    $feedback = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    return $feedback;
}
// Khởi tạo biến $feedback với giá trị mặc định là null
$feedback = null;

// Nếu có id_feedback trong URL, lấy thông tin feedback
$id_feedback = isset($_GET['id_feedback']) ? $_GET['id_feedback'] : null;
if ($id_feedback) {
    $feedback = getFeedbackById($id_feedback);
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Compose</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Compose</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Compose New Message</h3>
                    </div>
                    <!-- /.card-header -->
                    <form action="controller/FeedbackController.php" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <input type="hidden" name="id_feedback" value="<?php echo $id_feedback; ?>">
                            <div class="form-group">
                                <input class="form-control" name="to_email" placeholder="To:" value="<?php echo $feedback ? $feedback['email_customer'] : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="subject" placeholder="Subject:" required>
                            </div>
                            <div class="form-group">
                                <textarea id="compose-textarea" name="content_feedback" class="form-control" style="height: 300px" required></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary"><i class="far fa-envelope"></i>
                                    Send</button>
                            </div>
                            <button type="reset" class="btn btn-default"><i class="fas fa-times"></i> Discard</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>