<?php 
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ./../user/admin-login.php");
    exit;
}

include("./../config/conn.php");
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Admin Dashboard</title>
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
                            <h5 class="text-primary">
                                <i class="fas fa-store me-2"></i>DairyMart Admin
                            </h5>
                        </a>
                        <div class="small text-muted">Dashboard Control Panel</div>
                    </div>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="admin-dashboard.php">
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
                            <a class="nav-link" href="admin-reports.php">
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
                            <a href="./../user/products.php" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt me-2"></i>Log Out
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="dropdown me-2">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-calendar me-1"></i> This Week
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#">Today</a></li>
                                <li><a class="dropdown-item active" href="#">This Week</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Quarter</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Custom Range</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                    </div>
                </div>
                
                <!-- Alert Container -->
                <div id="alertContainer"></div>
                
                <!-- Stats Cards Row -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-primary text-white h-100">
                            <div class="card-body d-flex flex-column align-items-start">
                                <div class="d-flex justify-content-between w-100">
                                    <div class="stat-icon">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <div class="fs-4">+12%</div>
                                </div>
                                <h4 class="mt-3">₱54,350</h4>
                                <p class="mb-0">Total Sales</p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <small class="text-white">Compared to ₱48,500 last period</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-success text-white h-100">
                            <div class="card-body d-flex flex-column align-items-start">
                                <div class="d-flex justify-content-between w-100">
                                    <div class="stat-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="fs-4">+24%</div>
                                </div>
                                <h4 class="mt-3">1,286</h4>
                                <p class="mb-0">New Customers</p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <small class="text-white">Compared to 1,035 last period</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-warning text-dark h-100">
                            <div class="card-body d-flex flex-column align-items-start">
                                <div class="d-flex justify-content-between w-100">
                                    <div class="stat-icon">
                                        <i class="fas fa-truck-fast"></i>
                                    </div>
                                    <div class="fs-4">+8%</div>
                                </div>
                                <h4 class="mt-3">385</h4>
                                <p class="mb-0">Pending Orders</p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <small class="text-dark">Compared to 356 last period</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-info text-white h-100">
                            <div class="card-body d-flex flex-column align-items-start">
                                <div class="d-flex justify-content-between w-100">
                                    <div class="stat-icon">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                    <div class="fs-4">+5%</div>
                                </div>
                                <h4 class="mt-3">₱18,620</h4>
                                <p class="mb-0">Avg. Order Value</p>
                            </div>
                            <div class="card-footer bg-transparent border-top-0">
                                <small class="text-white">Compared to ₱17,725 last period</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Charts Row -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Sales Overview</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="salesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        This Year
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="salesDropdown">
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item active" href="#">This Year</a></li>
                                        <li><a class="dropdown-item" href="#">Last Year</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Product Categories</h5>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="categoryDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Second Row of Charts -->
                <div class="row g-4 mb-4">
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Top Products</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="productsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        By Units
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="productsDropdown">
                                        <li><a class="dropdown-item active" href="#">By Units</a></li>
                                        <li><a class="dropdown-item" href="#">By Revenue</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="productsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Customer Distribution</h5>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="customerChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Order Status</h5>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="orderStatusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Orders -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Orders</h5>
                        <a href="admin-orders.php" class="btn btn-sm btn-primary">
                            View All
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Products</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#ORD-2305</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">JS</div>
                                                <div>
                                                    <div class="fw-bold">Jane Smith</div>
                                                    <div class="small text-muted">Customer since 2022</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Organic Whole Milk (2), Heavy Cream (1)</td>
                                        <td>Mar 28, 2025</td>
                                        <td>₱14.27</td>
                                        <td>
                                            <span class="badge bg-success">Delivered</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">View Details</a></li>
                                                    <li><a class="dropdown-item" href="#">Mark as Returned</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#">Cancel Order</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-2304</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">AJ</div>
                                                <div>
                                                    <div class="fw-bold">Adam Johnson</div>
                                                    <div class="small text-muted">Customer since 2023</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Greek Yogurt Variety Pack (1), Low-Fat Milk (2)</td>
                                        <td>Mar 27, 2025</td>
                                        <td>₱14.97</td>
                                        <td>
                                            <span class="badge bg-warning text-dark">Processing</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">View Details</a></li>
                                                    <li><a class="dropdown-item" href="#">Mark as Shipped</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#">Cancel Order</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-2303</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">MM</div>
                                                <div>
                                                    <div class="fw-bold">Maria Miller</div>
                                                    <div class="small text-muted">Customer since 2021</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Aged Cheddar (1), Smoked Gouda (1), Almond Milk (2)</td>
                                        <td>Mar 27, 2025</td>
                                        <td>₱26.46</td>
                                        <td>
                                            <span class="badge bg-info">Shipped</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">View Details</a></li>
                                                    <li><a class="dropdown-item" href="#">Update Tracking</a></li>
                                                    <li><a class="dropdown-item" href="#">Mark as Delivered</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-2302</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">RB</div>
                                                <div>
                                                    <div class="fw-bold">Robert Brown</div>
                                                    <div class="small text-muted">Customer since 2024</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Italian Mascarpone (1), Irish Grass-Fed Butter (2)</td>
                                        <td>Mar 26, 2025</td>
                                        <td>₱19.47</td>
                                        <td>
                                            <span class="badge bg-success">Delivered</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">View Details</a></li>
                                                    <li><a class="dropdown-item" href="#">Mark as Returned</a></li>
                                                    <li><a class="dropdown-item text-danger" href="#">Cancel Order</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#ORD-2301</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle me-2">KD</div>
                                                <div>
                                                    <div class="fw-bold">Kevin Davis</div>
                                                    <div class="small text-muted">Customer since 2023</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Lactose-Free Milk (3), Mixed Berry Smoothie (6)</td>
                                        <td>Mar 25, 2025</td>
                                        <td>₱40.41</td>
                                        <td>
                                            <span class="badge bg-danger">Cancelled</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#">View Details</a></li>
                                                    <li><a class="dropdown-item" href="#">Process Refund</a></li>
                                                    <li><a class="dropdown-item" href="#">Restore Order</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4 mb-4">
                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Inventory Updates</h5>
                                <a href="admin-inventory.php" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Organic Whole Milk</h6>
                                            <small class="text-muted">3 hours ago</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-danger me-2">Low Stock</span>
                                            <span>Just 12 units remaining</span>
                                        </div>
                                    </div>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Greek Yogurt Variety Pack</h6>
                                            <small class="text-muted">5 hours ago</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2">Restocked</span>
                                            <span>Added 120 units to inventory</span>
                                        </div>
                                    </div>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Italian Mascarpone</h6>
                                            <small class="text-muted">1 day ago</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-warning text-dark me-2">New Item</span>
                                            <span>Added to inventory with 50 units</span>
                                        </div>
                                    </div>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Lactose-Free Milk</h6>
                                            <small class="text-muted">2 days ago</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2">Restocked</span>
                                            <span>Added 75 units to inventory</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Customer Activity</h5>
                                <a href="admin-users.php" class="btn btn-sm btn-primary">View All</a>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Jane Smith</h6>
                                            <small class="text-muted">2 hours ago</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2">Purchase</span>
                                            <span>₱14.27 - Organic Whole Milk, Heavy Cream</span>
                                        </div>
                                    </div>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Kevin Davis</h6>
                                            <small class="text-muted">4 hours ago</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-danger me-2">Cancellation</span>
                                            <span>Order #ORD-2301 cancelled by customer</span>
                                        </div>
                                    </div>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Samantha Peters</h6>
                                            <small class="text-muted">12 hours ago</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2">New User</span>
                                            <span>Completed registration and first purchase</span>
                                        </div>
                                    </div>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">Robert Brown</h6>
                                            <small class="text-muted">1 day ago</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2">Purchase</span>
                                            <span>₱19.47 - Italian Mascarpone, Irish Grass-Fed Butter</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <footer class="pt-5 d-flex justify-content-between">
                    <span>Copyright © 2025 <a href="index.php">DairyMart Admin</a></span>
                    <ul class="nav m-0">
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#">Privacy Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#">Terms of Use</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-secondary" href="#">Contact</a>
                        </li>
                    </ul>
                </footer>
            </main>
        </div>
    </div>
    
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Export Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Select the data you would like to export:</p>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="exportSales" checked>
                        <label class="form-check-label" for="exportSales">
                            Sales Data
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="exportInventory" checked>
                        <label class="form-check-label" for="exportInventory">
                            Inventory Data
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="exportCustomers">
                        <label class="form-check-label" for="exportCustomers">
                            Customer Data
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="exportOrders">
                        <label class="form-check-label" for="exportOrders">
                            Orders Data
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="exportFormat" class="form-label">Export Format</label>
                        <select class="form-select" id="exportFormat">
                            <option value="csv" selected>CSV</option>
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                            <option value="json">JSON</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dateRange" class="form-label">Date Range</label>
                        <select class="form-select" id="dateRange">
                            <option value="thisWeek" selected>This Week</option>
                            <option value="thisMonth">This Month</option>
                            <option value="lastMonth">Last Month</option>
                            <option value="thisYear">This Year</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary export-data-btn" data-type="dashboard">
                        <i class="fas fa-download me-1"></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>