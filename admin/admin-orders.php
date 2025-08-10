<?php
session_start();
include("./../config/conn.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: ./../user/admin-login.php");
    exit;
}

$admin_id = $_SESSION['admin_id'];

$sql = "SELECT o.order_id, o.user_id, o.date, o.items, o.total, o.status,
               u.first_name, u.last_name
        FROM orders o
        LEFT JOIN users u ON o.user_id = u.user_id
        WHERE o.admin_id = ?
        ORDER BY o.date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Order Management</title>
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
                <!-- Header with Notification -->
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Order Management</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal"
                            data-bs-target="#createOrderModal">
                            <i class="fas fa-plus me-1"></i> Create Order
                        </button>
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary export-data-btn"
                                data-type="orders-csv">
                                <i class="fas fa-file-csv me-1"></i> CSV
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary export-data-btn"
                                data-type="orders-pdf">
                                <i class="fas fa-file-pdf me-1"></i> PDF
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Alert Container -->
                <div id="alertContainer"></div>

                <!-- Order Stats Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon-sm bg-primary me-3">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <h6 class="mb-0">Total Orders</h6>
                                </div>
                                <h3 class="mb-1">8,542</h3>
                                <div class="small text-success">
                                    <i class="fas fa-arrow-up me-1"></i>12% increase
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon-sm bg-warning me-3">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <h6 class="mb-0">Pending Orders</h6>
                                </div>
                                <h3 class="mb-1">245</h3>
                                <div class="small text-success">
                                    <i class="fas fa-arrow-down me-1"></i>3% decrease
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon-sm bg-success me-3">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <h6 class="mb-0">Completed Orders</h6>
                                </div>
                                <h3 class="mb-1">7,845</h3>
                                <div class="small text-success">
                                    <i class="fas fa-arrow-up me-1"></i>15% increase
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="stat-icon-sm bg-danger me-3">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                    <h6 class="mb-0">Cancelled Orders</h6>
                                </div>
                                <h3 class="mb-1">452</h3>
                                <div class="small text-success">
                                    <i class="fas fa-arrow-down me-1"></i>8% decrease
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Filter Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Filter Orders</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="orderSearch" placeholder="Search">
                                        <label for="orderSearch">Search Order ID or Customer</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="orderStatus">
                                            <option value="">All Statuses</option>
                                            <option value="pending">Pending</option>
                                            <option value="processing">Processing</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="refunded">Refunded</option>
                                        </select>
                                        <label for="orderStatus">Order Status</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <select class="form-select" id="orderDateRange">
                                            <option value="all">All Time</option>
                                            <option value="today">Today</option>
                                            <option value="yesterday">Yesterday</option>
                                            <option value="week" selected>This Week</option>
                                            <option value="month">This Month</option>
                                            <option value="custom">Custom Range</option>
                                        </select>
                                        <label for="orderDateRange">Date Range</label>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <select class="form-select" id="orderSortBy">
                                            <option value="date_desc" selected>Newest First</option>
                                            <option value="date_asc">Oldest First</option>
                                            <option value="total_desc">Highest Amount</option>
                                            <option value="total_asc">Lowest Amount</option>
                                        </select>
                                        <label for="orderSortBy">Sort By</label>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter me-2"></i>Apply Filters
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Table -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Orders</h5>
                        <span class="badge bg-primary">245 results</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAllOrders">
                                                <label class="form-check-label" for="selectAllOrders"></label>
                                            </div>
                                        </th>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Items</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($order = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="orderCheck<?= $order['order_id'] ?>">
                                                    <label class="form-check-label"
                                                        for="orderCheck<?= $order['order_id'] ?>"></label>
                                                </div>
                                            </td>
                                            <td>#ORD-<?= htmlspecialchars($order['order_id']) ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle-sm me-2 bg-primary">
                                                        <?php
                                                        // Initials from first and last name
                                                        echo strtoupper(substr($order['first_name'], 0, 1) . substr($order['last_name'], 0, 1));
                                                        ?>
                                                    </div>
                                                    <div>
                                                        <?= htmlspecialchars($order['first_name'] . ' ' . $order['last_name']) ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= date("M d, Y", strtotime($order['date'])) ?></td>
                                            <td><?= htmlspecialchars($order['items']) ?></td>
                                            <td>₱<?= number_format($order['total'], 2) ?></td>
                                            <td>
                                                <?php
                                                $statusClass = match (strtolower($order['status'])) {
                                                    'delivered' => 'bg-success',
                                                    'pending' => 'bg-warning',
                                                    'cancelled' => 'bg-danger',
                                                    default => 'bg-secondary',
                                                };
                                                ?>
                                                <span
                                                    class="badge <?= $statusClass ?>"><?= htmlspecialchars(ucfirst($order['status'])) ?></span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        type="button" id="orderActionDropdown<?= $order['order_id'] ?>"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end"
                                                        aria-labelledby="orderActionDropdown<?= $order['order_id'] ?>">
                                                        <li><a class="dropdown-item"
                                                                href="order-details.php?id=<?= $order['order_id'] ?>"><i
                                                                    class="fas fa-eye me-2"></i>View Details</a></li>
                                                        <li><a class="dropdown-item"
                                                                href="edit-order.php?id=<?= $order['order_id'] ?>"><i
                                                                    class="fas fa-edit me-2"></i>Edit</a></li>
                                                        <li><a class="dropdown-item" href="#"><i
                                                                    class="fas fa-print me-2"></i>Print Invoice</a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item text-danger"
                                                                href="cancel-order.php?id=<?= $order['order_id'] ?>"><i
                                                                    class="fas fa-times-circle me-2"></i>Cancel Order</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="bulk-actions">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Bulk Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-truck me-2"></i>Mark as
                                                Shipped</a></li>
                                        <li><a class="dropdown-item" href="#"><i
                                                    class="fas fa-check-circle me-2"></i>Mark as Delivered</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print
                                                Invoices</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="#"><i
                                                    class="fas fa-times-circle me-2"></i>Cancel Orders</a></li>
                                    </ul>
                                </div>
                            </div>
                            <nav aria-label="Orders pagination">
                                <ul class="pagination justify-content-end mb-0">
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

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Orders by Status</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="orderStatusChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Orders Over Time</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="orderTimeChart" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Create Order Modal -->
    <div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createOrderModalLabel">Create New Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="customerSelect" class="form-label">Customer</label>
                            <select class="form-select" id="customerSelect" required>
                                <option value="">Select Customer</option>
                                <option value="1">John Doe</option>
                                <option value="2">Jane Smith</option>
                                <option value="3">Robert Brown</option>
                                <option value="4">Emma Johnson</option>
                                <option value="5">Michael Wilson</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Products</label>
                            <div class="table-responsive">
                                <table class="table table-hover" id="orderProductsTable">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-select">
                                                    <option value="">Select Product</option>
                                                    <option value="1">Organic Whole Milk - 1 Gallon</option>
                                                    <option value="2">Premium Aged Cheddar - 8oz</option>
                                                    <option value="3">Greek Yogurt - Plain - 32oz</option>
                                                    <option value="4">Grass-Fed Unsalted Butter - 16oz</option>
                                                    <option value="5">Vanilla Bean Ice Cream - 1.5qt</option>
                                                </select>
                                            </td>
                                            <td>₱5.99</td>
                                            <td>
                                                <input type="number" class="form-control" value="1" min="1">
                                            </td>
                                            <td>₱5.99</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5">
                                                <button type="button" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-plus me-1"></i> Add Product
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="shippingAddress" class="form-label">Shipping Address</label>
                                <textarea class="form-control" id="shippingAddress" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="billingAddress" class="form-label">Billing Address</label>
                                <textarea class="form-control" id="billingAddress" rows="3"></textarea>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" value="" id="sameAsShipping"
                                        checked>
                                    <label class="form-check-label" for="sameAsShipping">
                                        Same as shipping address
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="paymentMethod" class="form-label">Payment Method</label>
                                <select class="form-select" id="paymentMethod">
                                    <option value="credit_card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="cash_on_delivery">Cash on Delivery</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="shippingMethod" class="form-label">Shipping Method</label>
                                <select class="form-select" id="shippingMethod">
                                    <option value="standard">Standard Shipping (₱5.99)</option>
                                    <option value="express">Express Shipping (₱12.99)</option>
                                    <option value="overnight">Overnight Shipping (₱19.99)</option>
                                    <option value="store_pickup">Store Pickup (Free)</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="orderNotes" class="form-label">Order Notes</label>
                                <textarea class="form-control" id="orderNotes" rows="3"
                                    placeholder="Add any special instructions or notes for this order"></textarea>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm mt-4">
                                    <tr>
                                        <td>Subtotal:</td>
                                        <td class="text-end">₱5.99</td>
                                    </tr>
                                    <tr>
                                        <td>Shipping:</td>
                                        <td class="text-end">₱5.99</td>
                                    </tr>
                                    <tr>
                                        <td>Tax (7%):</td>
                                        <td class="text-end">₱0.84</td>
                                    </tr>
                                    <tr class="fw-bold">
                                        <td>Total:</td>
                                        <td class="text-end">₱12.82</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Create Order</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="static/js/admin.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Order Status Chart
            if (document.getElementById('orderStatusChart')) {
                const ctx = document.getElementById('orderStatusChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Delivered', 'Shipped', 'Processing', 'Pending', 'Cancelled'],
                        datasets: [{
                            data: [65, 15, 10, 5, 5],
                            backgroundColor: [
                                'rgba(25, 135, 84, 0.8)',
                                'rgba(13, 110, 253, 0.8)',
                                'rgba(255, 193, 7, 0.8)',
                                'rgba(13, 202, 240, 0.8)',
                                'rgba(220, 53, 69, 0.8)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right'
                            }
                        }
                    }
                });
            }

            // Orders Over Time Chart
            if (document.getElementById('orderTimeChart')) {
                const ctx = document.getElementById('orderTimeChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Mar 23', 'Mar 24', 'Mar 25', 'Mar 26', 'Mar 27', 'Mar 28', 'Mar 29'],
                        datasets: [{
                            label: 'Orders',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            borderColor: 'rgba(13, 110, 253, 1)',
                            data: [65, 59, 80, 81, 75, 85, 70],
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
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