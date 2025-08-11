<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ./../user/admin-login.php");
    exit;
}

include("./../config/conn.php");


$total_sales_query = "SELECT SUM(total) AS total_sales FROM orders WHERE status = 'confirmed'";
$total_sales_result = mysqli_query($conn, $total_sales_query);
$total_sales = mysqli_fetch_assoc($total_sales_result)['total_sales'];

$total_products_query = "SELECT COUNT(DISTINCT product_id) AS total_products FROM orders";
$total_products_result = mysqli_query($conn, $total_products_query);
$total_products = mysqli_fetch_assoc($total_products_result)['total_products'];

$total_orders_query = "SELECT COUNT(order_id) AS total_orders FROM orders";
$total_orders_result = mysqli_query($conn, $total_orders_query);
$total_orders = mysqli_fetch_assoc($total_orders_result)['total_orders'];

$completed_orders_query = "SELECT COUNT(order_id) AS completed_orders FROM orders WHERE status = 'completed'";
$completed_orders_result = mysqli_query($conn, $completed_orders_query);
$completed_orders = mysqli_fetch_assoc($completed_orders_result)['completed_orders'];

$sales_query = "SELECT DATE(date) AS sale_date, SUM(total) AS daily_sales 
                FROM orders 
                WHERE status = 'confirmed' 
                GROUP BY sale_date 
                ORDER BY sale_date DESC LIMIT 30";
$sales_result = mysqli_query($conn, $sales_query);
$sales_data = [];
while ($row = mysqli_fetch_assoc($sales_result)) {
    $sales_data[] = $row;
}

$categories_query = "SELECT category, COUNT(products.product_id) AS product_count 
                     FROM orders 
                     JOIN products ON orders.product_id = products.product_id
                     GROUP BY category";
$categories_result = mysqli_query($conn, $categories_query);
$categories_data = [];

while ($row = mysqli_fetch_assoc($categories_result)) {
    $categories_data[] = $row;
}


$top_products_query = "SELECT product_id, SUM(total) AS total_sales
                       FROM orders
                       WHERE status = 'confirmed'
                       GROUP BY product_id
                       ORDER BY total_sales DESC
                       LIMIT 5";
$top_products_result = mysqli_query($conn, $top_products_query);
$top_products_data = [];
while ($row = mysqli_fetch_assoc($top_products_result)) {
    $top_products_data[] = $row;
}

$order_status_query = "SELECT status, COUNT(order_id) AS status_count 
                       FROM orders 
                       GROUP BY status";
$order_status_result = mysqli_query($conn, $order_status_query);
$order_status_data = [];
while ($row = mysqli_fetch_assoc($order_status_result)) {
    $order_status_data[] = $row;
}

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
            <?php include('./sidebar.php') ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                <div id="alertContainer"></div>
                <div class="row g-4 mb-4">

                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-primary text-white h-100">
                            <div class="card-body d-flex flex-column align-items-start">
                                <div class="stat-icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <h4 class="mt-3">₱<?php echo number_format($total_sales, 2); ?></h4>
                                <p class="mb-0">Total Sales</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-info text-white h-100">
                            <div class="card-body d-flex flex-column align-items-start">
                                <div class="stat-icon">
                                    <i class="fas fa-boxes"></i>
                                </div>
                                <h4 class="mt-3"><?php echo $total_products; ?></h4>
                                <p class="mb-0">Total Products</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-success text-white h-100">
                            <div class="card-body d-flex flex-column align-items-start">
                                <div class="stat-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <h4 class="mt-3"><?php echo $total_orders; ?></h4>
                                <p class="mb-0">Total Orders</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-warning text-light h-100">
                            <div class="card-body d-flex flex-column align-items-start">
                                <div class="stat-icon">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <h4 class="mt-3"><?php echo $completed_orders; ?></h4>
                                <p class="mb-0">Completed Orders</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Sales Overview</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Low Stock Alerts</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Greek Yogurt - Plain - 32oz</span>
                                        <span class="badge bg-warning rounded-pill">8 left</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Cottage Cheese - 16oz</span>
                                        <span class="badge bg-warning rounded-pill">5 left</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Vanilla Bean Ice Cream - 1.5qt</span>
                                        <span class="badge bg-danger rounded-pill">0 left</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Chocolate Milk - 1qt</span>
                                        <span class="badge bg-warning rounded-pill">4 left</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Strawberry Yogurt - 6oz</span>
                                        <span class="badge bg-warning rounded-pill">7 left</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var salesData = <?php echo json_encode($sales_data); ?>;
        var salesDates = salesData.map(item => item.sale_date);
        var salesValues = salesData.map(item => item.daily_sales);

        var salesChart = new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: salesDates,
                datasets: [{
                    label: 'Sales (₱)',
                    data: salesValues,
                    borderColor: '#007bff',
                    fill: false
                }]
            }
        });

        var categoriesData = <?php echo json_encode($categories_data); ?>;
        var categoryLabels = categoriesData.map(item => 'Category ' + item.category_id);

        var categoryDistributionChart = new Chart(document.getElementById('categoryDistributionChart'), {
            type: 'pie',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryCounts,
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8'],
                }]
            }
        });

        var topProductsData = <?php echo json_encode($top_products_data); ?>;
        var productLabels = topProductsData.map(item => 'Product ' + item.product_id);
        var productSales = topProductsData.map(item => item.total_sales);

        var productsChart = new Chart(document.getElementById('productsChart'), {
            type: 'bar',
            data: {
                labels: productLabels,
                datasets: [{
                    label: 'Total Sales (₱)',
                    data: productSales,
                    backgroundColor: '#007bff',
                }]
            }
        });

        var orderStatusData = <?php echo json_encode($order_status_data); ?>;
        var statusLabels = orderStatusData.map(item => item.status);
        var statusCounts = orderStatusData.map(item => item.status_count);

        var orderStatusChart = new Chart(document.getElementById('orderStatusChart'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusCounts,
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545'],
                }]
            }
        });
    </script>
</body>

</html>