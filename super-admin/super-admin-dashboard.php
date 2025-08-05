<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Super Admin Dashboard</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="px-3 mb-4">
                        <a href="index.php" class="text-decoration-none">
                            <h5 class="text-danger">
                                <i class="fas fa-crown me-2"></i>DairyMart Super Admin
                            </h5>
                        </a>
                        <div class="small text-muted">System Control Center</div>
                    </div>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="super-admin-dashboard.php">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="super-admin-users.php">
                                <i class="fas fa-users-cog me-2"></i>
                                Role Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="super-admin-activities.php">
                                <i class="fas fa-eye me-2"></i>
                                Activity Monitor
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="super-admin-analytics.php">
                                <i class="fas fa-chart-bar me-2"></i>
                                Advanced Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-dashboard.php">
                                <i class="fas fa-user-shield me-2"></i>
                                Admin Dashboard
                            </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="px-3 mt-4">
                        <div class="d-flex align-items-center pb-3">
                            <div class="avatar-circle me-3" style="background-color: #dc3545;">
                                <span>SA</span>
                            </div>
                            <div>
                                <h6 class="mb-0">Super Admin</h6>
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
                <!-- Header -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Super Admin Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="dropdown me-2">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-calendar me-1"></i> Today
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item active" href="#">Today</a></li>
                                <li><a class="dropdown-item" href="#">This Week</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="exportSystemReport()">
                            <i class="fas fa-download me-1"></i> Export System Report
                        </button>
                    </div>
                </div>

                <!-- Alert Container -->
                <div id="alertContainer"></div>

                <!-- System Overview Stats -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-danger text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mb-0" id="totalUsers">0</h4>
                                        <p class="mb-0">Total Users</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-white">Active sessions: <span id="activeSessions">0</span></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-warning text-dark h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mb-0" id="totalAdmins">0</h4>
                                        <p class="mb-0">Admin Users</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-dark">Online: <span id="onlineAdmins">0</span></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-info text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mb-0" id="todayActivities">0</h4>
                                        <p class="mb-0">Today's Activities</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-activity"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-white">Last hour: <span id="lastHourActivities">0</span></small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="mb-0" id="systemHealth">100%</h4>
                                        <p class="mb-0">System Health</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-heartbeat"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-white">Uptime: <span id="systemUptime">24h 35m</span></small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Analytics Dashboard -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">User Activity Trend</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        Last 7 Days
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item active" href="#">Last 7 Days</a></li>
                                        <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                        <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="userActivityChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">User Roles Distribution</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="roleDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent System Activities -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent System Activities</h5>
                        <a href="super-admin-activities.php" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Time</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Details</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="recentActivitiesTable">
                                    <!-- Activities will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <i class="fas fa-users-cog fa-3x text-primary mb-3"></i>
                                <h5 class="card-title">Manage User Roles</h5>
                                <p class="card-text">Assign and modify user roles and permissions across the system.</p>
                                <a href="super-admin-users.php" class="btn btn-primary">Manage Roles</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-info">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line fa-3x text-info mb-3"></i>
                                <h5 class="card-title">Advanced Analytics</h5>
                                <p class="card-text">View detailed analytics including product frequency and sales trends.</p>
                                <a href="super-admin-analytics.php" class="btn btn-info">View Analytics</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-warning">
                            <div class="card-body text-center">
                                <i class="fas fa-eye fa-3x text-warning mb-3"></i>
                                <h5 class="card-title">Activity Monitor</h5>
                                <p class="card-text">Monitor real-time user activities and system access logs.</p>
                                <a href="super-admin-activities.php" class="btn btn-warning">Monitor Activities</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <!-- <script src="static/js/super-admin.js"></script>
    <script>
        // Initialize dashboard on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeSuperAdminDashboard();
        });
    </script> -->
</body>
</html>
