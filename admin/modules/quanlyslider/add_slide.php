<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Thêm Slide</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                    <li class="breadcrumb-item active">Thêm Slide</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <form id="slideForm" action="controller/SlideController.php" method="post" enctype="multipart/form-data">
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
                            <textarea name="slide_name" id="slide_name" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="slide_img">Ảnh Slide</label>
                            <input type="file" name="slide_img" class="form-control" id="slide_img" required>
                        </div>
                        <div class="form-group">
                            <label for="slide_status">Trạng thái</label>
                            <select name="slide_status" id="slide_status" class="form-control custom-select" required>
                                <option value="">Chọn trạng thái</option>
                                <option value="1">Kích hoạt</option>
                                <option value="0">Không kích hoạt</option>
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
                <input type="submit" name="add_slide" value="Tạo mới Slide" class="btn btn-success float-right">
            </div>
        </div>
    </form>
</section>