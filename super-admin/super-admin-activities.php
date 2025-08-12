<?php
session_start();
include("./../config/conn.php");


if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ./../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Activity Monitor</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('./sidebar.php') ?>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <!-- Header -->
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Activity Monitor</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="exportActivityReport()">
                            <i class="fas fa-download me-1"></i> Export Report
                        </button>
                    </div>
                </div>

                <!-- Alert Container -->
                <div id="alertContainer"></div>

                <!-- Activity Filters -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Activity Filters</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 w-100">
                            <div class="col-md-4">
                                <label for="dateRange" class="form-label">Date Range</label>
                                <select class="form-select" id="dateRange">
                                    <option value="today">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="activityType" class="form-label">Activity Type</label>
                                <select class="form-select" id="activityType">
                                    <option value="all">All Activities</option>
                                    <option value="login">Login/Logout</option>
                                    <option value="product">Product Management</option>
                                    <option value="order">Order Management</option>
                                    <option value="user">User Management</option>
                                    <option value="user">Admin Management</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="button" class="btn btn-primary me-2" onclick="applyFilters()">
                                    <i class="fas fa-filter me-1"></i> Apply Filters
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                    <i class="fas fa-times me-1"></i> Clear
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Activity Log -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Activity Log</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="150px">Timestamp</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Details</th>
                                        <th>IP Address</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="activityTable">
                                    <!-- Activities will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <nav>
                            <ul class="pagination justify-content-center mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="#" onclick="previousPage()">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <span class="page-link" id="currentPage">1</span>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" onclick="nextPage()">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Activity Details Modal -->
    <div class="modal fade" id="activityDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Activity Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th width="120px">Timestamp:</th>
                                    <td id="detailTimestamp"></td>
                                </tr>
                                <tr>
                                    <th>User:</th>
                                    <td id="detailUser"></td>
                                </tr>
                                <tr>
                                    <th>Action:</th>
                                    <td id="detailAction"></td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td id="detailStatus"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Technical Details</h6>
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th width="120px">IP Address:</th>
                                    <td id="detailIP"></td>
                                </tr>
                                <tr>
                                    <th>User Agent:</th>
                                    <td id="detailUserAgent"></td>
                                </tr>
                                <tr>
                                    <th>Session ID:</th>
                                    <td id="detailSessionId"></td>
                                </tr>
                                <tr>
                                    <th>Request ID:</th>
                                    <td id="detailRequestId"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h6>Additional Details</h6>
                            <pre id="detailData" class="bg-dark text-light p-3 rounded"></pre>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <!-- <script src="static/js/activity-monitor.js"></script>
    <script>
        // Initialize activity monitor on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeActivityMonitor();
        });
    </script> -->
</body>

</html>