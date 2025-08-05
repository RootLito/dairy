<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Income & Expenses</title>
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
                            <a class="nav-link" href="admin-reports.php">
                                <i class="fas fa-chart-line me-2"></i>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="admin-income.php">
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
                    <h1 class="h2">Income & Expenses</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="dropdown me-2">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="timePeriodDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-calendar me-1"></i> 2025 Q1
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="timePeriodDropdown">
                                <li><a class="dropdown-item" href="#">Current Month</a></li>
                                <li><a class="dropdown-item active" href="#">2025 Q1</a></li>
                                <li><a class="dropdown-item" href="#">2024 Q4</a></li>
                                <li><a class="dropdown-item" href="#">2024 Q3</a></li>
                                <li><a class="dropdown-item" href="#">2024 Q2</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Year to Date</a></li>
                                <li><a class="dropdown-item" href="#">Last 12 Months</a></li>
                                <li><a class="dropdown-item" href="#">Custom Range</a></li>
                            </ul>
                        </div>
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary export-data-btn" data-type="financials-csv">
                                <i class="fas fa-file-csv me-1"></i> CSV
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary export-data-btn" data-type="financials-pdf">
                                <i class="fas fa-file-pdf me-1"></i> PDF
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Alert Container -->
                <div id="alertContainer"></div>
                
                <!-- Financial Summary Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary h-100">
                            <div class="card-body">
                                <h6 class="card-title">Total Revenue</h6>
                                <h3 class="mb-1">₱548,350</h3>
                                <p class="mb-0 small">+12% vs. previous period</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-danger h-100">
                            <div class="card-body">
                                <h6 class="card-title">Total Expenses</h6>
                                <h3 class="mb-1">₱348,520</h3>
                                <p class="mb-0 small">+8% vs. previous period</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success h-100">
                            <div class="card-body">
                                <h6 class="card-title">Net Profit</h6>
                                <h3 class="mb-1">₱199,830</h3>
                                <p class="mb-0 small">+18% vs. previous period</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info h-100">
                            <div class="card-body">
                                <h6 class="card-title">Profit Margin</h6>
                                <h3 class="mb-1">36.4%</h3>
                                <p class="mb-0 small">+2.3% vs. previous period</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Income Statement -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Income Statement</h5>
                        <span class="badge bg-primary">Q1 2025</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col" class="text-end">January</th>
                                        <th scope="col" class="text-end">February</th>
                                        <th scope="col" class="text-end">March</th>
                                        <th scope="col" class="text-end">Total</th>
                                        <th scope="col" class="text-end">% of Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Revenue Section -->
                                    <tr class="table-primary">
                                        <th scope="row" colspan="6">Revenue</th>
                                    </tr>
                                    <tr>
                                        <td>Milk Products</td>
                                        <td class="text-end">₱58,450</td>
                                        <td class="text-end">₱62,320</td>
                                        <td class="text-end">₱64,780</td>
                                        <td class="text-end">₱185,550</td>
                                        <td class="text-end">33.8%</td>
                                    </tr>
                                    <tr>
                                        <td>Cheese Products</td>
                                        <td class="text-end">₱42,650</td>
                                        <td class="text-end">₱45,280</td>
                                        <td class="text-end">₱48,420</td>
                                        <td class="text-end">₱136,350</td>
                                        <td class="text-end">24.9%</td>
                                    </tr>
                                    <tr>
                                        <td>Yogurt Products</td>
                                        <td class="text-end">₱35,780</td>
                                        <td class="text-end">₱38,450</td>
                                        <td class="text-end">₱39,820</td>
                                        <td class="text-end">₱114,050</td>
                                        <td class="text-end">20.8%</td>
                                    </tr>
                                    <tr>
                                        <td>Butter Products</td>
                                        <td class="text-end">₱18,250</td>
                                        <td class="text-end">₱19,350</td>
                                        <td class="text-end">₱21,450</td>
                                        <td class="text-end">₱59,050</td>
                                        <td class="text-end">10.8%</td>
                                    </tr>
                                    <tr>
                                        <td>Ice Cream Products</td>
                                        <td class="text-end">₱16,540</td>
                                        <td class="text-end">₱17,850</td>
                                        <td class="text-end">₱18,960</td>
                                        <td class="text-end">₱53,350</td>
                                        <td class="text-end">9.7%</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Total Revenue</td>
                                        <td class="text-end">₱171,670</td>
                                        <td class="text-end">₱183,250</td>
                                        <td class="text-end">₱193,430</td>
                                        <td class="text-end">₱548,350</td>
                                        <td class="text-end">100.0%</td>
                                    </tr>
                                    
                                    <!-- Cost of Goods Sold Section -->
                                    <tr class="table-danger">
                                        <th scope="row" colspan="6">Cost of Goods Sold</th>
                                    </tr>
                                    <tr>
                                        <td>Product Costs</td>
                                        <td class="text-end">₱68,650</td>
                                        <td class="text-end">₱73,180</td>
                                        <td class="text-end">₱77,350</td>
                                        <td class="text-end">₱219,180</td>
                                        <td class="text-end">40.0%</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping & Handling</td>
                                        <td class="text-end">₱8,580</td>
                                        <td class="text-end">₱9,150</td>
                                        <td class="text-end">₱9,670</td>
                                        <td class="text-end">₱27,400</td>
                                        <td class="text-end">5.0%</td>
                                    </tr>
                                    <tr>
                                        <td>Warehouse Costs</td>
                                        <td class="text-end">₱5,150</td>
                                        <td class="text-end">₱5,490</td>
                                        <td class="text-end">₱5,800</td>
                                        <td class="text-end">₱16,440</td>
                                        <td class="text-end">3.0%</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Total COGS</td>
                                        <td class="text-end">₱82,380</td>
                                        <td class="text-end">₱87,820</td>
                                        <td class="text-end">₱92,820</td>
                                        <td class="text-end">₱263,020</td>
                                        <td class="text-end">48.0%</td>
                                    </tr>
                                    
                                    <!-- Gross Profit -->
                                    <tr class="table-success fw-bold">
                                        <td>Gross Profit</td>
                                        <td class="text-end">₱89,290</td>
                                        <td class="text-end">₱95,430</td>
                                        <td class="text-end">₱100,610</td>
                                        <td class="text-end">₱285,330</td>
                                        <td class="text-end">52.0%</td>
                                    </tr>
                                    
                                    <!-- Operating Expenses Section -->
                                    <tr class="table-warning">
                                        <th scope="row" colspan="6">Operating Expenses</th>
                                    </tr>
                                    <tr>
                                        <td>Salaries & Wages</td>
                                        <td class="text-end">₱28,500</td>
                                        <td class="text-end">₱28,500</td>
                                        <td class="text-end">₱28,500</td>
                                        <td class="text-end">₱85,500</td>
                                        <td class="text-end">15.6%</td>
                                    </tr>
                                    <tr>
                                        <td>Marketing & Advertising</td>
                                        <td class="text-end">₱8,600</td>
                                        <td class="text-end">₱9,200</td>
                                        <td class="text-end">₱9,700</td>
                                        <td class="text-end">₱27,500</td>
                                        <td class="text-end">5.0%</td>
                                    </tr>
                                    <tr>
                                        <td>Rent & Utilities</td>
                                        <td class="text-end">₱7,500</td>
                                        <td class="text-end">₱7,500</td>
                                        <td class="text-end">₱7,500</td>
                                        <td class="text-end">₱22,500</td>
                                        <td class="text-end">4.1%</td>
                                    </tr>
                                    <tr>
                                        <td>Equipment & Maintenance</td>
                                        <td class="text-end">₱2,800</td>
                                        <td class="text-end">₱3,200</td>
                                        <td class="text-end">₱2,600</td>
                                        <td class="text-end">₱8,600</td>
                                        <td class="text-end">1.6%</td>
                                    </tr>
                                    <tr>
                                        <td>Insurance</td>
                                        <td class="text-end">₱2,200</td>
                                        <td class="text-end">₱2,200</td>
                                        <td class="text-end">₱2,200</td>
                                        <td class="text-end">₱6,600</td>
                                        <td class="text-end">1.2%</td>
                                    </tr>
                                    <tr>
                                        <td>Other Expenses</td>
                                        <td class="text-end">₱4,250</td>
                                        <td class="text-end">₱3,850</td>
                                        <td class="text-end">₱4,700</td>
                                        <td class="text-end">₱12,800</td>
                                        <td class="text-end">2.3%</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Total Operating Expenses</td>
                                        <td class="text-end">₱53,850</td>
                                        <td class="text-end">₱54,450</td>
                                        <td class="text-end">₱55,200</td>
                                        <td class="text-end">₱163,500</td>
                                        <td class="text-end">29.8%</td>
                                    </tr>
                                    
                                    <!-- Operating Income -->
                                    <tr class="table-info fw-bold">
                                        <td>Operating Income</td>
                                        <td class="text-end">₱35,440</td>
                                        <td class="text-end">₱40,980</td>
                                        <td class="text-end">₱45,410</td>
                                        <td class="text-end">₱121,830</td>
                                        <td class="text-end">22.2%</td>
                                    </tr>
                                    
                                    <!-- Other Income/Expenses -->
                                    <tr>
                                        <td>Taxes</td>
                                        <td class="text-end">₱7,800</td>
                                        <td class="text-end">₱9,000</td>
                                        <td class="text-end">₱10,000</td>
                                        <td class="text-end">₱26,800</td>
                                        <td class="text-end">4.9%</td>
                                    </tr>
                                    <tr>
                                        <td>Interest</td>
                                        <td class="text-end">(₱1,600)</td>
                                        <td class="text-end">(₱1,600)</td>
                                        <td class="text-end">(₱1,600)</td>
                                        <td class="text-end">(₱4,800)</td>
                                        <td class="text-end">-0.9%</td>
                                    </tr>
                                    
                                    <!-- Net Income -->
                                    <tr class="bg-success text-white fw-bold">
                                        <td>Net Income</td>
                                        <td class="text-end">₱29,240</td>
                                        <td class="text-end">₱33,580</td>
                                        <td class="text-end">₱37,010</td>
                                        <td class="text-end">₱99,830</td>
                                        <td class="text-end">18.2%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Income & Expense Graphs -->
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Revenue vs Expenses</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="incomeChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Expense Distribution</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="expensesChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Revenue by Product Category -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Revenue by Product Category</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px;">
                            <canvas id="revenueCategoryChart"></canvas>
                        </div>
                    </div>
                </div>
                
                <!-- Transaction Details -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Transactions</h5>
                        <button class="btn btn-sm btn-outline-primary">View All</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Type</th>
                                        <th scope="col" class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Mar 29, 2025</td>
                                        <td>Daily Sales Revenue</td>
                                        <td>Sales</td>
                                        <td><span class="badge bg-success">Income</span></td>
                                        <td class="text-end text-success">+₱7,845.50</td>
                                    </tr>
                                    <tr>
                                        <td>Mar 28, 2025</td>
                                        <td>Supplier Payment - Organic Farms Co.</td>
                                        <td>Inventory</td>
                                        <td><span class="badge bg-danger">Expense</span></td>
                                        <td class="text-end text-danger">-₱12,450.00</td>
                                    </tr>
                                    <tr>
                                        <td>Mar 28, 2025</td>
                                        <td>Daily Sales Revenue</td>
                                        <td>Sales</td>
                                        <td><span class="badge bg-success">Income</span></td>
                                        <td class="text-end text-success">+₱6,785.25</td>
                                    </tr>
                                    <tr>
                                        <td>Mar 27, 2025</td>
                                        <td>Marketing Campaign Payment</td>
                                        <td>Marketing</td>
                                        <td><span class="badge bg-danger">Expense</span></td>
                                        <td class="text-end text-danger">-₱3,500.00</td>
                                    </tr>
                                    <tr>
                                        <td>Mar 27, 2025</td>
                                        <td>Daily Sales Revenue</td>
                                        <td>Sales</td>
                                        <td><span class="badge bg-success">Income</span></td>
                                        <td class="text-end text-success">+₱8,124.75</td>
                                    </tr>
                                    <tr>
                                        <td>Mar 26, 2025</td>
                                        <td>Equipment Maintenance</td>
                                        <td>Operations</td>
                                        <td><span class="badge bg-danger">Expense</span></td>
                                        <td class="text-end text-danger">-₱850.00</td>
                                    </tr>
                                    <tr>
                                        <td>Mar 26, 2025</td>
                                        <td>Daily Sales Revenue</td>
                                        <td>Sales</td>
                                        <td><span class="badge bg-success">Income</span></td>
                                        <td class="text-end text-success">+₱6,957.50</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="static/js/admin.js"></script>
    <script src="static/js/charts.js"></script>
</body>
</html>