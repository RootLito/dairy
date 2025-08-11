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
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Advanced Analytics</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="exportAnalyticsReport()">
                            <i class="fas fa-download me-1"></i> Export Analytics
                        </button>
                    </div>
                </div>
                <div id="alertContainer"></div>
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Tab Navigation -->
                        <ul class="nav nav-pills justify-content-center" id="analyticsNav" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="frequency-tab" data-bs-toggle="pill" href="#frequencyAnalysis" role="tab" aria-controls="frequencyAnalysis" aria-selected="true">
                                    <i class="fas fa-chart-bar me-2"></i>Product Frequency
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="topselling-tab" data-bs-toggle="pill" href="#topSellingAnalysis" role="tab" aria-controls="topSellingAnalysis" aria-selected="false">
                                    <i class="fas fa-trophy me-2"></i>Top Selling
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="trends-tab" data-bs-toggle="pill" href="#trendsAnalysis" role="tab" aria-controls="trendsAnalysis" aria-selected="false">
                                    <i class="fas fa-chart-line me-2"></i>Sales Trends
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="analyticsTabContent">
                    <!-- Product Frequency Tab -->
                    <div class="tab-pane fade show active" id="frequencyAnalysis" role="tabpanel" aria-labelledby="frequency-tab">
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
                    </div>

                    <!-- Top Selling Tab -->
                    <div class="tab-pane fade" id="topSellingAnalysis" role="tabpanel" aria-labelledby="topselling-tab">
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Top Products</h5>
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
                    </div>

                    <div class="tab-pane fade" id="trendsAnalysis" role="tabpanel" aria-labelledby="trends-tab">
                        <div class="row g-4 mb-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Monthly Sales Trends</h5>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-secondary active" onclick="toggleTrendsView('revenue')">Revenue</button>
                                            <button class="btn btn-outline-secondary" onclick="toggleTrendsView('quantity')">Quantity</button>
                                            <button class="btn btn-outline-secondary" onclick="toggleTrendsView('orders')">Orders</button>
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
                                        </tbody>
                                    </table>
                                </div>
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