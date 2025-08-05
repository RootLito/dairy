<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Reports</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="px-3 mb-4">
                        <a href="index.php" class="text-decoration-none">
                            <h5 class="text-primary">
                                <i class="fas fa-store me-2"></i>DairyMart Admin
                            </h5>
                        </a>
                        <div class="small text-muted">Dashboard Control Panel</div>
                    </div>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="admin-dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-inventory.php">
                                <i class="fas fa-boxes me-2"></i>
                                Inventory
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-orders.php">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="admin-reports.php">
                                <i class="fas fa-chart-line me-2"></i>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-income.php">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                Income & Expenses
                            </a>
                        </li>
                    </ul>
                    
                    <hr>
                    <div class="px-3 mt-4">
                        <div class="d-flex align-items-center pb-3">
                            <div class="avatar-circle me-3">
                                <span>AD</span>
                            </div>
                            <div>
                                <h6 class="mb-0">Admin User</h6>
                                <div class="small text-muted">System Administrator</div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <a href="login.php" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt me-2"></i>Log Out
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <!-- Header with Notification -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Reports</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#reportScheduleModal">
                            <i class="fas fa-calendar-alt me-1"></i> Schedule Report
                        </button>
                        <div class="dropdown me-2">
                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="exportReportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-download me-1"></i> Export
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportReportDropdown">
                                <li><a class="dropdown-item export-data-btn" data-type="report-pdf" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                                <li><a class="dropdown-item export-data-btn" data-type="report-excel" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                                <li><a class="dropdown-item export-data-btn" data-type="report-csv" href="#"><i class="fas fa-file-csv me-2"></i>CSV</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Email Report</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Alert Container -->
                <div id="alertContainer"></div>
                
                <!-- Report Selection Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Generate Reports</h5>
                    </div>
                    <div class="card-body">
                        <form id="reportFilterForm">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="reportType" required>
                                            <option value="">Select Report Type</option>
                                            <option value="sales">Sales Report</option>
                                            <option value="inventory">Inventory Report</option>
                                            <option value="customers">Customer Report</option>
                                            <option value="products">Product Performance</option>
                                            <option value="categories">Category Performance</option>
                                        </select>
                                        <label for="reportType">Report Type</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="reportDateRange">
                                            <option value="today">Today</option>
                                            <option value="yesterday">Yesterday</option>
                                            <option value="week">This Week</option>
                                            <option value="month" selected>This Month</option>
                                            <option value="quarter">This Quarter</option>
                                            <option value="year">This Year</option>
                                            <option value="custom">Custom Range</option>
                                        </select>
                                        <label for="reportDateRange">Time Period</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-select" id="reportGroupBy">
                                            <option value="day">Group by Day</option>
                                            <option value="week">Group by Week</option>
                                            <option value="month" selected>Group by Month</option>
                                            <option value="quarter">Group by Quarter</option>
                                            <option value="year">Group by Year</option>
                                        </select>
                                        <label for="reportGroupBy">Group Data By</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row g-3 mt-2" id="customDateContainer" style="display: none;">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="startDate">
                                        <label for="startDate">Start Date</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="endDate">
                                        <label for="endDate">End Date</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-center">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-chart-line me-2"></i> Generate Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Report Container -->
                <div id="reportContainer">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Sales Report: March 2025</h5>
                            <span class="badge bg-primary">Generated: March 29, 2025</span>
                        </div>
                        <div class="card-body">
                            <!-- Key Metrics -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-3">
                                    <div class="card text-white bg-primary h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">Total Sales</h6>
                                            <h3 class="mb-1">₱48,950</h3>
                                            <p class="mb-0 small">+12% vs. previous period</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-white bg-success h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">Total Orders</h6>
                                            <h3 class="mb-1">856</h3>
                                            <p class="mb-0 small">+8% vs. previous period</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-dark bg-warning h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">Avg. Order Value</h6>
                                            <h3 class="mb-1">₱57.18</h3>
                                            <p class="mb-0 small">+3% vs. previous period</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card text-white bg-info h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">Return Rate</h6>
                                            <h3 class="mb-1">3.2%</h3>
                                            <p class="mb-0 small">-0.5% vs. previous period</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sales Overview Chart -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Sales Overview</h5>
                                </div>
                                <div class="card-body">
                                    <div style="height: 350px;">
                                        <canvas id="salesReportChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Split View - Top Products and Categories -->
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0">Top Products</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Product</th>
                                                            <th scope="col">Units</th>
                                                            <th scope="col">Revenue</th>
                                                            <th scope="col">Growth</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Organic Whole Milk - 1 Gallon</td>
                                                            <td>458</td>
                                                            <td>₱2,743.42</td>
                                                            <td><span class="text-success">+15%</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Premium Aged Cheddar - 8oz</td>
                                                            <td>392</td>
                                                            <td>₱2,543.08</td>
                                                            <td><span class="text-success">+10%</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Greek Yogurt - Plain - 32oz</td>
                                                            <td>375</td>
                                                            <td>₱1,608.75</td>
                                                            <td><span class="text-success">+8%</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Grass-Fed Unsalted Butter - 16oz</td>
                                                            <td>356</td>
                                                            <td>₱1,954.44</td>
                                                            <td><span class="text-danger">-2%</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Vanilla Bean Ice Cream - 1.5qt</td>
                                                            <td>289</td>
                                                            <td>₱2,309.11</td>
                                                            <td><span class="text-success">+24%</span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0">Sales by Category</h5>
                                        </div>
                                        <div class="card-body">
                                            <div style="height: 250px;">
                                                <canvas id="categoryReportChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sales by Region -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Sales by Region</h5>
                                </div>
                                <div class="card-body">
                                    <div style="height: 300px;">
                                        <canvas id="regionReportChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Sales Table -->
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Detailed Sales</h5>
                                    <div class="input-group input-group-sm" style="width: 240px;">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search sales...">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Date</th>
                                                    <th scope="col">Order ID</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Items</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Mar 29, 2025</td>
                                                    <td>#ORD-5783</td>
                                                    <td>John Doe</td>
                                                    <td>4</td>
                                                    <td>₱67.85</td>
                                                    <td><span class="badge bg-success">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mar 28, 2025</td>
                                                    <td>#ORD-5782</td>
                                                    <td>Jane Smith</td>
                                                    <td>8</td>
                                                    <td>₱124.50</td>
                                                    <td><span class="badge bg-success">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mar 28, 2025</td>
                                                    <td>#ORD-5781</td>
                                                    <td>Robert Brown</td>
                                                    <td>2</td>
                                                    <td>₱28.99</td>
                                                    <td><span class="badge bg-info">Shipped</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mar 27, 2025</td>
                                                    <td>#ORD-5780</td>
                                                    <td>Emma Johnson</td>
                                                    <td>5</td>
                                                    <td>₱82.25</td>
                                                    <td><span class="badge bg-warning">Processing</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mar 27, 2025</td>
                                                    <td>#ORD-5779</td>
                                                    <td>Michael Wilson</td>
                                                    <td>12</td>
                                                    <td>₱156.75</td>
                                                    <td><span class="badge bg-success">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mar 26, 2025</td>
                                                    <td>#ORD-5778</td>
                                                    <td>Sarah Davis</td>
                                                    <td>3</td>
                                                    <td>₱46.50</td>
                                                    <td><span class="badge bg-success">Completed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Mar 26, 2025</td>
                                                    <td>#ORD-5777</td>
                                                    <td>David Miller</td>
                                                    <td>6</td>
                                                    <td>₱93.20</td>
                                                    <td><span class="badge bg-info">Shipped</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <nav aria-label="Sales pagination">
                                        <ul class="pagination justify-content-center mb-0">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                            </li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Schedule Report Modal -->
    <div class="modal fade" id="reportScheduleModal" tabindex="-1" aria-labelledby="reportScheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportScheduleModalLabel">Schedule Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="scheduleReportForm">
                        <div class="mb-3">
                            <label for="scheduleReportType" class="form-label">Report Type</label>
                            <select class="form-select" id="scheduleReportType" required>
                                <option value="">Select Report Type</option>
                                <option value="sales">Sales Report</option>
                                <option value="inventory">Inventory Report</option>
                                <option value="customers">Customer Report</option>
                                <option value="products">Product Performance</option>
                                <option value="categories">Category Performance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="scheduleFrequency" class="form-label">Frequency</label>
                            <select class="form-select" id="scheduleFrequency" required>
                                <option value="daily">Daily</option>
                                <option value="weekly" selected>Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                            </select>
                        </div>
                        <div class="mb-3" id="weeklyOptions">
                            <label class="form-label">Day of Week</label>
                            <div class="btn-group d-flex" role="group">
                                <input type="radio" class="btn-check" name="dayOfWeek" id="monday" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="monday">M</label>
                                
                                <input type="radio" class="btn-check" name="dayOfWeek" id="tuesday" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="tuesday">T</label>
                                
                                <input type="radio" class="btn-check" name="dayOfWeek" id="wednesday" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="wednesday">W</label>
                                
                                <input type="radio" class="btn-check" name="dayOfWeek" id="thursday" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="thursday">T</label>
                                
                                <input type="radio" class="btn-check" name="dayOfWeek" id="friday" autocomplete="off" checked>
                                <label class="btn btn-outline-secondary" for="friday">F</label>
                                
                                <input type="radio" class="btn-check" name="dayOfWeek" id="saturday" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="saturday">S</label>
                                
                                <input type="radio" class="btn-check" name="dayOfWeek" id="sunday" autocomplete="off">
                                <label class="btn btn-outline-secondary" for="sunday">S</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="scheduleTime" class="form-label">Time</label>
                            <input type="time" class="form-control" id="scheduleTime" value="08:00" required>
                        </div>
                        <div class="mb-3">
                            <label for="scheduleFormat" class="form-label">Format</label>
                            <select class="form-select" id="scheduleFormat" required>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="scheduleDelivery" class="form-label">Delivery Method</label>
                            <select class="form-select" id="scheduleDelivery" required>
                                <option value="email">Email</option>
                                <option value="dashboard">Dashboard</option>
                                <option value="both" selected>Both</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="scheduleEmail" class="form-label">Email Recipients</label>
                            <input type="text" class="form-control" id="scheduleEmail" placeholder="Enter email addresses, separated by commas">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Schedule Report</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="static/js/admin.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle custom date range visibility
            const reportDateRange = document.getElementById('reportDateRange');
            const customDateContainer = document.getElementById('customDateContainer');
            
            if (reportDateRange) {
                reportDateRange.addEventListener('change', function() {
                    if (this.value === 'custom') {
                        customDateContainer.style.display = 'flex';
                    } else {
                        customDateContainer.style.display = 'none';
                    }
                });
            }
            
            // Sales Report Chart
            if (document.getElementById('salesReportChart')) {
                const ctx = document.getElementById('salesReportChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Mar 1', 'Mar 5', 'Mar 10', 'Mar 15', 'Mar 20', 'Mar 25', 'Mar 29'],
                        datasets: [{
                            label: 'Sales',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            borderColor: 'rgba(13, 110, 253, 1)',
                            data: [1500, 2200, 3000, 2800, 3500, 4100, 3800],
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
            
            // Category Report Chart
            if (document.getElementById('categoryReportChart')) {
                const ctx = document.getElementById('categoryReportChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Milk', 'Cheese', 'Yogurt', 'Butter', 'Ice Cream'],
                        datasets: [{
                            label: 'Sales by Category',
                            backgroundColor: [
                                'rgba(13, 110, 253, 0.8)',
                                'rgba(220, 53, 69, 0.8)',
                                'rgba(25, 135, 84, 0.8)',
                                'rgba(255, 193, 7, 0.8)',
                                'rgba(13, 202, 240, 0.8)'
                            ],
                            data: [35, 25, 20, 10, 10]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            }
            
            // Region Report Chart
            if (document.getElementById('regionReportChart')) {
                const ctx = document.getElementById('regionReportChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Northeast', 'Midwest', 'South', 'West', 'International'],
                        datasets: [{
                            label: 'Sales Volume',
                            backgroundColor: 'rgba(13, 110, 253, 0.8)',
                            data: [15200, 12500, 9800, 8200, 3250]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>