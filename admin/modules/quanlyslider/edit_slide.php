<?php
include("config/config.php");
$id = $_GET['id'];
$query = "SELECT * FROM tbl_slide WHERE id_slide=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$slide = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Slide</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Edit Slide</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <form id="slideForm" action="controller/SlideController.php?action=update" method="post"
        enctype="multipart/form-data">
        <input type="hidden" name="id_slide" value="<?php echo $slide['id_slide']; ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Slide</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="slide_name">Tiêu đề Slide</label>
                            <textarea name="slide_name" id="slide_name" class="form-control"
                                required><?php echo htmlspecialchars($slide['slide_name']); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="slide_img">Ảnh Slide</label>
                            <input type="file" name="slide_img" class="form-control" id="slide_img">
                            <img src="modules/quanlyslider/images/<?php echo htmlspecialchars($slide['slide_img']); ?>"
                                alt="Current Slide Image" style="max-width: 100px; max-height: 100px;">
                        </div>
                        <div class="form-group">
                            <label for="slide_status">Trạng thái</label>
                            <select name="slide_status" id="inputStatus" class="form-control custom-select">
                                <option value="1" <?php echo $slide['slide_status'] == 1 ? 'selected' : ''; ?>>Active
                                </option>
                                <option value="0" <?php echo $slide['slide_status'] == 0 ? 'selected' : ''; ?>>Inactive
                                </option>
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
                <a href="#" class="btn btn-secondary">Hủy</a>
                <input type="submit" name="edit_slide" value="Edit Slide" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>