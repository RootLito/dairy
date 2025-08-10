<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Advanced Analytics</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <h1 class="h2">Advanced Analytics</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="dropdown me-2">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-calendar me-1"></i> Last 30 Days
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="setDateRange('7')">Last 7 Days</a></li>
                                <li><a class="dropdown-item active" href="#" onclick="setDateRange('30')">Last 30
                                        Days</a></li>
                                <li><a class="dropdown-item" href="#" onclick="setDateRange('90')">Last 90 Days</a></li>
                                <li><a class="dropdown-item" href="#" onclick="setDateRange('365')">Last Year</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="exportAnalyticsReport()">
                            <i class="fas fa-download me-1"></i> Export Analytics
                        </button>
                    </div>
                </div>

                <!-- Alert Container -->
                <div id="alertContainer"></div>

                <!-- Analytics Navigation -->
                <div class="card mb-4">
                    <div class="card-body">
                        <ul class="nav nav-pills justify-content-center" id="analyticsNav">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="showAnalyticsTab('frequency')">
                                    <i class="fas fa-chart-bar me-2"></i>Product Frequency
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="showAnalyticsTab('topselling')">
                                    <i class="fas fa-trophy me-2"></i>Top Selling
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" onclick="showAnalyticsTab('trends')">
                                    <i class="fas fa-chart-line me-2"></i>Sales Trends
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Product Frequency Analysis -->
                <div id="frequencyAnalysis" class="analytics-tab">
                    <div class="row g-4 mb-4">
                        <div class="col-md-8">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">Product Catalog Addition Frequency</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="productFrequencyChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">Category Distribution</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="categoryFrequencyChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Product Addition Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Product Category</th>
                                            <th>Products Added</th>
                                            <th>This Month</th>
                                            <th>Last Month</th>
                                            <th>Change</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productFrequencyTable">
                                        <!-- Data will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Selling Products -->
                <div id="topSellingAnalysis" class="analytics-tab d-none">
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Top Products by Quantity</h5>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary active"
                                            onclick="toggleTopProductsView('quantity')">Quantity</button>
                                        <button class="btn btn-outline-secondary"
                                            onclick="toggleTopProductsView('revenue')">Revenue</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="topProductsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0">Revenue by Product</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="revenueByProductChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Top Selling Products Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Product</th>
                                            <th>Category</th>
                                            <th>Units Sold</th>
                                            <th>Revenue</th>
                                            <th>Avg. Price</th>
                                            <th>Growth</th>
                                        </tr>
                                    </thead>
                                    <tbody id="topSellingTable">
                                        <!-- Data will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales Trends -->
                <div id="trendsAnalysis" class="analytics-tab d-none">
                    <div class="row g-4 mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Monthly Sales Trends</h5>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary active"
                                            onclick="toggleTrendsView('revenue')">Revenue</button>
                                        <button class="btn btn-outline-secondary"
                                            onclick="toggleTrendsView('quantity')">Quantity</button>
                                        <button class="btn btn-outline-secondary"
                                            onclick="toggleTrendsView('orders')">Orders</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container" style="height: 400px;">
                                        <canvas id="salesTrendsChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Seasonal Analysis</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="seasonalChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Growth Rate</h5>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container">
                                        <canvas id="growthRateChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Monthly Performance Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Revenue</th>
                                            <th>Orders</th>
                                            <th>Avg. Order Value</th>
                                            <th>Growth Rate</th>
                                            <th>Top Category</th>
                                        </tr>
                                    </thead>
                                    <tbody id="monthlyPerformanceTable">
                                        <!-- Data will be populated by JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>