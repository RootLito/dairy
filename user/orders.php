<?php
session_start();
include('./../config/conn.php');

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in.";
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT o.order_id, o.date, o.items, o.total, o.status 
        FROM orders o
        WHERE o.user_id = ? 
        ORDER BY o.date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total_orders = 0;
$completed_orders = 0;
$in_transit_orders = 0;

$count_sql = "SELECT status, COUNT(*) as count 
              FROM orders 
              WHERE user_id = ? 
              GROUP BY status";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("i", $user_id);
$count_stmt->execute();
$count_result = $count_stmt->get_result();

while ($row = $count_result->fetch_assoc()) {
    $status = strtolower($row['status']);
    $count = (int)$row['count'];
    $total_orders += $count;

    if ($status === 'completed') {
        $completed_orders = $count;
    } elseif ($status === 'in transit') {
        $in_transit_orders = $count;
    }
}

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
    <title>DairyMart - My Orders</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/nav.php"); ?>
    <main>
        <div class="container">
            <h1 class="mb-4">My Account</h1>
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 mb-4">
                            <div class="card">
                                <div class="card">
                                    <div class="list-group list-group-flush">
                                        <a href="account.php" class="list-group-item list-group-item-action">
                                            <i class="fas fa-user me-2"></i>Account Details
                                        </a>
                                        <a href="orders.php" class="list-group-item list-group-item-action active">
                                            <i class="fas fa-shopping-bag me-2"></i>My Orders
                                        </a>
                                        <a href="track.php" class="list-group-item list-group-item-action">
                                            <i class="fas fa-truck me-2"></i>Track Order
                                        </a>
                                        <a href="cart.php" class="list-group-item list-group-item-action">
                                            <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
                                        </a>
                                        <a href="review.php" class="list-group-item list-group-item-action">
                                            <i class="fas fa-star me-2"></i>Rate and Review
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-3">
                                            <label for="orderFilter" class="form-label">Filter by Status</label>
                                            <select class="form-select" id="orderFilter">
                                                <option value="all" selected>All Orders</option>
                                                <option value="processing">Processing</option>
                                                <option value="shipped">Shipped</option>
                                                <option value="delivered">Delivered</option>
                                                <option value="cancelled">Cancelled</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="timeFilter" class="form-label">Time Period</label>
                                            <select class="form-select" id="timeFilter">
                                                <option value="all" selected>All Time</option>
                                                <option value="30days">Last 30 Days</option>
                                                <option value="6months">Last 6 Months</option>
                                                <option value="1year">Last Year</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="orderSearch" class="form-label">Search by Order #</label>
                                            <input type="text" class="form-control" id="orderSearch" placeholder="e.g., DM12345678">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button class="btn btn-primary w-100">
                                                <i class="fas fa-filter me-2"></i>Apply
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Recent Orders</h5>
                                    <span class="badge bg-primary"><?php echo $result->num_rows; ?> Orders</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Order #</th>
                                                    <th>Date</th>
                                                    <th>Items</th>
                                                    <th>Total</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($order = $result->fetch_assoc()) {
                                                    $order_id = $order['order_id'];
                                                    $date = date("M d, Y", strtotime($order['date']));
                                                    $items = $order['items'];
                                                    $total = number_format($order['total'], 2);
                                                    $status = $order['status'];
                                                ?>
                                                    <tr>
                                                        <td><a href="#orderDetails<?php echo $order_id; ?>" data-bs-toggle="modal" class="text-decoration-none fw-bold"><?php echo $order_id; ?></a></td>
                                                        <td><?php echo $date; ?></td>
                                                        <td><?php echo $items; ?> items</td>
                                                        <td>₱<?php echo $total; ?></td>
                                                        <td>
                                                            <span class="badge 
                                    <?php echo ($status == 'Shipped') ? 'bg-info' : ($status == 'Delivered' ? 'bg-success' : 'bg-danger'); ?>">
                                                                <?php echo ucfirst($status); ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                    Actions
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a class="dropdown-item" href="#orderDetails<?php echo $order_id; ?>" data-bs-toggle="modal"><i class="fas fa-eye me-2"></i>View Details</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-file-invoice me-2"></i>Invoice</a></li>
                                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-truck me-2"></i>Track Package</a></li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                                    <div class="text-muted small">
                                        Showing <?php echo $result->num_rows; ?> orders
                                    </div>
                                    <nav aria-label="Order pagination">
                                        <ul class="pagination pagination-sm mb-0">
                                            <li class="page-item disabled">
                                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                            </li>
                                            <li class="page-item active" aria-current="page">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">Next</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <div class="text-primary mb-2">
                                                <i class="fas fa-shopping-bag fa-2x"></i>
                                            </div>
                                            <h5 class="card-title display-6 mb-0"><?= $total_orders ?></h5>
                                            <p class="card-text text-muted">Total Orders</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <div class="text-success mb-2">
                                                <i class="fas fa-box-open fa-2x"></i>
                                            </div>
                                            <h5 class="card-title display-6 mb-0"><?= $completed_orders ?></h5>
                                            <p class="card-text text-muted">Completed</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <div class="text-info mb-2">
                                                <i class="fas fa-shipping-fast fa-2x"></i>
                                            </div>
                                            <h5 class="card-title display-6 mb-0"><?= $in_transit_orders ?></h5>
                                            <p class="card-text text-muted">In Transit</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="orderDetails1" tabindex="-1" aria-labelledby="orderDetailsModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel1">Order #DM87654321</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Order Information</h6>
                            <p class="mb-1">Date: March 25, 2025</p>
                            <p class="mb-1">Status: <span class="badge bg-info">Shipped</span></p>
                            <p class="mb-1">Payment Method: Visa ending in 4321</p>
                            <p class="mb-0">Tracking Number: <a href="#" class="text-decoration-none">1ZW4567890123456789</a></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Shipping Information</h6>
                            <p class="mb-1">Juliebert</p>
                            <p class="mb-1">123 Main Street</p>
                            <p class="mb-1">Anytown, CA 12345</p>
                            <p class="mb-0">United States</p>
                        </div>
                    </div>

                    <h6 class="fw-bold border-bottom pb-2 mb-3">Order Items</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1618164436378-64484e0fed7c?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100&q=80" alt="Premium Aged Cheddar" class="img-thumbnail me-3" style="width: 60px;">
                                            <div>
                                                <p class="mb-0 fw-bold">Premium Aged Cheddar</p>
                                                <small class="text-muted">200g (8oz)</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₱12.99</td>
                                    <td>2</td>
                                    <td>₱25.98</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1571543441651-601c86060fc4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100&q=80" alt="Organic Greek Yogurt" class="img-thumbnail me-3" style="width: 60px;">
                                            <div>
                                                <p class="mb-0 fw-bold">Organic Greek Yogurt</p>
                                                <small class="text-muted">32oz, Plain</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₱6.99</td>
                                    <td>3</td>
                                    <td>₱20.97</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1570794358672-8037e348d2f4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100&q=80" alt="Fresh Whipping Cream" class="img-thumbnail me-3" style="width: 60px;">
                                            <div>
                                                <p class="mb-0 fw-bold">Fresh Whipping Cream</p>
                                                <small class="text-muted">16oz, Heavy Cream</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₱4.29</td>
                                    <td>1</td>
                                    <td>₱4.29</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1489007012214-9648eedadffc?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100&q=80" alt="Grass-Fed Butter" class="img-thumbnail me-3" style="width: 60px;">
                                            <div>
                                                <p class="mb-0 fw-bold">Grass-Fed Butter</p>
                                                <small class="text-muted">8oz, Unsalted</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₱8.49</td>
                                    <td>1</td>
                                    <td>₱8.49</td>
                                </tr>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                    <td>₱59.73</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Shipping:</td>
                                    <td>₱12.99</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Tax:</td>
                                    <td>₱7.25</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Discount:</td>
                                    <td>-₱5.00</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Order Total:</td>
                                    <td class="fw-bold">₱89.97</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <h6 class="fw-bold border-bottom pb-2 mb-3">Order Timeline</h6>
                    <div class="timeline-small mb-0">
                        <div class="timeline-item">
                            <div class="timeline-point bg-success"></div>
                            <div class="timeline-content">
                                <p class="mb-0 fw-bold">Order Placed</p>
                                <p class="small text-muted mb-0">March 25, 2025, 9:34 AM</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-point bg-success"></div>
                            <div class="timeline-content">
                                <p class="mb-0 fw-bold">Payment Confirmed</p>
                                <p class="small text-muted mb-0">March 25, 2025, 9:38 AM</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-point bg-success"></div>
                            <div class="timeline-content">
                                <p class="mb-0 fw-bold">Processing</p>
                                <p class="small text-muted mb-0">March 25, 2025, 11:15 AM</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-point bg-success"></div>
                            <div class="timeline-content">
                                <p class="mb-0 fw-bold">Packed & Ready</p>
                                <p class="small text-muted mb-0">March 26, 2025, 10:22 AM</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-point bg-info"></div>
                            <div class="timeline-content">
                                <p class="mb-0 fw-bold">Shipped</p>
                                <p class="small text-muted mb-0">March 26, 2025, 3:45 PM</p>
                                <p class="small text-muted mb-0">Package has left our warehouse</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-point bg-secondary"></div>
                            <div class="timeline-content">
                                <p class="mb-0 fw-bold">In Transit</p>
                                <p class="small text-muted mb-0">Expected: March 29, 2025</p>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-point bg-secondary"></div>
                            <div class="timeline-content">
                                <p class="mb-0 fw-bold">Delivered</p>
                                <p class="small text-muted mb-0">Expected: March 29-30, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-primary me-2">
                        <i class="fas fa-truck me-2"></i>Track Package
                    </a>
                    <a href="#" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-file-invoice me-2"></i>Invoice
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Modal 2 -->
    <div class="modal fade" id="orderDetails2" tabindex="-1" aria-labelledby="orderDetailsModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel2">Order #DM87654320</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold">Order Information</h6>
                            <p class="mb-1">Date: March 15, 2025</p>
                            <p class="mb-1">Status: <span class="badge bg-success">Delivered</span></p>
                            <p class="mb-1">Payment Method: Mastercard ending in 9876</p>
                            <p class="mb-0">Tracking Number: <a href="#" class="text-decoration-none">1ZW0987654321098765</a></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold">Shipping Information</h6>
                            <p class="mb-1">John Doe</p>
                            <p class="mb-1">Sulop, Davao del Sur</p>
                        </div>
                    </div>

                    <h6 class="fw-bold border-bottom pb-2 mb-3">Order Items</h6>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1634487359989-3e90c9432133?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100&q=80" alt="Double Cream Brie" class="img-thumbnail me-3" style="width: 60px;">
                                            <div>
                                                <p class="mb-0 fw-bold">Double Cream Brie</p>
                                                <small class="text-muted">8oz wheel</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₱11.99</td>
                                    <td>1</td>
                                    <td>₱11.99</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://images.unsplash.com/photo-1571543441651-601c86060fc4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100&q=80" alt="Organic Greek Yogurt" class="img-thumbnail me-3" style="width: 60px;">
                                            <div>
                                                <p class="mb-0 fw-bold">Organic Greek Yogurt</p>
                                                <small class="text-muted">32oz, Plain</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>₱6.99</td>
                                    <td>1</td>
                                    <td>₱6.99</td>
                                </tr>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Subtotal:</td>
                                    <td>₱18.98</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Shipping:</td>
                                    <td>₱6.99</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Tax:</td>
                                    <td>₱2.01</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Order Total:</td>
                                    <td class="fw-bold">₱27.98</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <h6 class="fw-bold border-bottom pb-2 mb-3">Delivery Confirmation</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <img src="https://images.unsplash.com/photo-1563227812-1ea732a3ba00?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=600&q=80" alt="Delivery Photo" class="img-fluid rounded">
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Delivered On:</strong> March 17, 2025, 2:43 PM</p>
                            <p class="mb-2"><strong>Received By:</strong> Left at front door</p>
                            <p class="mb-2"><strong>Delivery Notes:</strong> Package was left as instructed in a shaded area near the front door.</p>
                            <div class="alert alert-success mb-0">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-check-circle fa-2x"></i>
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-bold">Temperature Check: PASSED</p>
                                        <p class="mb-0 small">Package maintained safe temperature during shipping. All dairy products were in optimal condition.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0">Rate Your Products</h6>
                        </div>
                        <div class="card-body p-3">
                            <div class="d-flex flex-column flex-md-row mb-3">
                                <div class="me-md-3 mb-3 mb-md-0">
                                    <img src="https://images.unsplash.com/photo-1634487359989-3e90c9432133?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100&q=80" alt="Double Cream Brie" class="img-thumbnail" style="width: 60px;">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Double Cream Brie</h6>
                                    <div class="rating-stars mb-2">
                                        <i class="far fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                        <i class="far fa-star text-warning"></i>
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control" rows="2" placeholder="Share your thoughts on this product..."></textarea>
                                    </div>
                                    <button class="btn btn-sm btn-primary">Submit Review</button>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-md-row">
                                <div class="me-md-3 mb-3 mb-md-0">
                                    <img src="https://images.unsplash.com/photo-1571543441651-601c86060fc4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=100&q=80" alt="Organic Greek Yogurt" class="img-thumbnail" style="width: 60px;">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">Organic Greek Yogurt</h6>
                                    <div class="rating-stars mb-2">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                    </div>
                                    <div class="alert alert-success py-2 mb-0">
                                        <small>You rated this product 5 stars on March 20, 2025.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reorder Section -->
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary">
                            <i class="fas fa-sync me-2"></i>Reorder All Items
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-file-invoice me-2"></i>Invoice
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>