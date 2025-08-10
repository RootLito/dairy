<?php
session_start();

if (!isset($_SESSION['super_admin_id'])) {
    header("Location: ./../super-admin/super-admin-login.php");
    exit;
}

include("./../config/conn.php");


$userQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$userCount = mysqli_fetch_assoc($userQuery)['total'];

$adminQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM admin");
$adminCount = mysqli_fetch_assoc($adminQuery)['total'];

$productQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$productCount = mysqli_fetch_assoc($productQuery)['total'];

$orderQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders");
$orderCount = mysqli_fetch_assoc($orderQuery)['total'];




$sql = "
    SELECT p.product_name, COUNT(o.product_id) AS total_sold
    FROM orders o
    INNER JOIN products p ON o.product_id = p.product_id
    GROUP BY o.product_id
    ORDER BY total_sold DESC
    LIMIT 5
";

$result = mysqli_query($conn, $sql);

$productNames = [];
$productCounts = [];

while ($row = mysqli_fetch_assoc($result)) {
    $productNames[] = $row['product_name'];
    $productCounts[] = (int) $row['total_sold'];
}

// echo '<pre>';
// print_r($productNames);
// print_r($productCounts);
// echo '</pre>';
?>



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
            <?php include('./sidebar.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Super Admin Dashboard</h1>
                </div>
                <div id="alertContainer"></div>
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-danger text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <div>
                                        <h4 class="mb-0"><?php echo $userCount; ?></h4>
                                        <p class="mb-0">Total Users</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-warning text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <div>
                                        <h4 class="mb-0"><?php echo $adminCount; ?></h4>
                                        <p class="mb-0">Admin Users</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-user-shield fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-info text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <div>
                                        <h4 class="mb-0"><?php echo $productCount; ?></h4>
                                        <p class="mb-0">Total Products</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-box fa-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card dashboard-stat-card bg-success text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center py-2">
                                    <div>
                                        <h4 class="mb-0"><?php echo $orderCount; ?></h4>
                                        <p class="mb-0">Total Orders</p>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="fas fa-shopping-cart fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row g-4 mb-4">
                    <div class="col-lg-8">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Top Selling Products</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="height:300px;">
                                    <canvas id="userActivityChart"></canvas>
                                </div>

                                <div class="mt-3  d-flex justify-content-center align-items-center">
                                    <ul class="list-unstyled d-flex flex-wrap gap-3">
                                        <?php
                                        $legendColors = ['#A5D8FF', '#FFE066', '#FFABAB', '#C3F584', '#DCC6E0'];
                                        for ($i = 0; $i < count($productNames); $i++):
                                            ?>
                                            <li class="d-flex align-items-center">
                                                <span
                                                    style="display:inline-block;width:16px;height:16px;background-color:<?php echo $legendColors[$i]; ?>;border-radius:3px;margin-right:8px;"></span>
                                                <span
                                                    class="text-white"><?php echo htmlspecialchars($productNames[$i]); ?></span>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
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
                                <div class="chart-container"  style="height:300px;">
                                    <canvas id="roleChart" width="300" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


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
                                <p class="card-text">View detailed analytics including product frequency and sales
                                    trends.</p>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('roleChart').getContext('2d');

        const roleChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Users', 'Admins'],
                datasets: [{
                    data: [<?php echo $userCount; ?>, <?php echo $adminCount; ?>],
                    backgroundColor: ['#0d6efd', '#ffc107'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#fff',
                            font: {
                                size: 14
                            }
                        }
                    },
                    title: {
                        display: false,
                    }
                }
            }
        });
    </script>
    <script>

        const productCtx = document.getElementById('userActivityChart').getContext('2d');

        const userActivityChart = new Chart(productCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($productNames); ?>,
                datasets: [{
                    label: 'Units Sold',
                    data: <?php echo json_encode($productCounts); ?>,
                    backgroundColor: [
                        '#A5D8FF',
                        '#FFE066',
                        '#FFABAB',
                        '#C3F584',
                        '#DCC6E0'
                    ],
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>

</html>