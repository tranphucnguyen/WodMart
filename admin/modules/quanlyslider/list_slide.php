<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Slide</h3>

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
                        <th>Slide_name</th>
                        <th>Slide_image</th>
                        <th>Slide_status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="slideList">
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
    var slidesPerPage = 5;

    function loadSlides(page) {
        $.ajax({
            url: 'controller/SlideController.php?action=list',
            method: 'GET',
            success: function(response) {
                var slides = JSON.parse(response);
                var slideList = $('#slideList');
                slideList.empty();

                var totalSlides = slides.length;
                var totalPages = Math.ceil(totalSlides / slidesPerPage);
                var startIndex = (page - 1) * slidesPerPage;
                var endIndex = Math.min(startIndex + slidesPerPage, totalSlides);

                for (var i = startIndex; i < endIndex; i++) {
                    var slide = slides[i];
                    var statusText = slide.slide_status == 1 ? 'Active' : 'Inactive';
                    var row = `<tr>
                                <td>${i + 1}</td>
                                <td>${slide.slide_name}</td>
                                <td><img src="modules/quanlyslider/images/${slide.slide_img}" alt="Slide Image" style="max-width: 100px; max-height: 100px;"></td>
                                <td>${statusText}</td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-success btn-sm" href="index.php?action=quanlyslider&query=edit&id=${slide.id_slide}"><i class="fas fa-pencil-alt"></i> Edit </a>
                                    <button class="btn btn-danger btn-sm delete-btn" data-id="${slide.id_slide}"><i class="fas fa-trash"></i> Delete </button>
                                </td>
                            </tr>`;
                    slideList.append(row);
                }

                // Thêm sự kiện click cho nút Delete
                $('.delete-btn').click(function() {
                    var slideId = $(this).data('id');
                    if (confirm('Are you sure you want to delete this slide?')) {
                        deleteSlide(slideId);
                    }
                });

                // Cập nhật trạng thái của các nút phân trang
                $('.prev-btn').prop('disabled', currentPage === 1);
                $('.next-btn').prop('disabled', currentPage === totalPages);

                // Hiển thị thông tin số trang
                $('.page-info').text('Page ' + currentPage + ' of ' + totalPages);
            },
            error: function() {
                console.error('Failed to fetch slides.');
            }
        });
    }

    function deleteSlide(slideId) {
        $.ajax({
            url: 'controller/SlideController.php?action=delete',
            method: 'POST',
            data: {
                id: slideId
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    console.log('Slide deleted successfully!');
                    loadSlides(currentPage);
                } else {
                    console.error('Failed to delete slide: ' + result.message);
                }
            },
            error: function() {
                console.error('Failed to delete slide.');
            }
        });
    }

    // Sự kiện click cho nút Previous
    $('.prev-btn').click(function() {
        if (currentPage > 1) {
            currentPage--;
            loadSlides(currentPage);
        }
    });

    // Sự kiện click cho nút Next
    $('.next-btn').click(function() {
        currentPage++;
        loadSlides(currentPage);
    });

    loadSlides(currentPage); // Đảm bảo tên hàm chính xác
});
</script>