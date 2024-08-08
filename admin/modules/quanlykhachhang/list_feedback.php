<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Inbox</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Inbox</li>
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
                    <h3 class="card-title">Inbox</h3>

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
                            <tbody id="feedbackTableBody">
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
<script>
    let currentPage = 1;
    const itemsPerPage = 5;

    // Function to fetch and display feedback list
    function fetchFeedbackList(page = 1) {
        fetch(`controller/FeedbackController.php?page=${page}&itemsPerPage=${itemsPerPage}`)
            .then(response => response.json())
            .then(data => {
                const {
                    feedbackList,
                    totalItems
                } = data;
                const feedbackTableBody = document.getElementById('feedbackTableBody');
                feedbackTableBody.innerHTML = ''; // Clear existing rows

                feedbackList.forEach((feedback, index) => {
                    const row = `<tr>
                                <td>${(page - 1) * itemsPerPage + index + 1}</td>
                                <td>${feedback.name_customer}</td>
                                <td>${feedback.email_customer}</td>
                                <td>${feedback.phone_customer}</td>
                                <td>${feedback.comment}</td>
                                <td><a href="index.php?action=quanlykhachhang&query=feedback&id_feedback=${feedback.id_feedback}"><i class="fa-solid fa-inbox"></i></a></td>
                            </tr>`;
                    feedbackTableBody.innerHTML += row;
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
            .catch(error => console.error('Error fetching feedback list:', error));
    }

    // Event listeners for pagination buttons
    document.getElementById('prevPage').addEventListener('click', () => {
        if (currentPage > 1) {
            currentPage--;
            fetchFeedbackList(currentPage);
        }
    });

    document.getElementById('nextPage').addEventListener('click', () => {
        currentPage++;
        fetchFeedbackList(currentPage);
    });

    // Call fetchFeedbackList when page is loaded
    document.addEventListener('DOMContentLoaded', () => fetchFeedbackList(currentPage));
</script>