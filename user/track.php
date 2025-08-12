<?php
session_start();
include('./../config/conn.php');

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in.";
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT order_id, date, items, status FROM orders WHERE user_id = ? ORDER BY date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ./../login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DairyMart - Place and Track Order</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="static/css/styles.css" rel="stylesheet" />
</head>

<body>
    <?php include("./includes/nav.php"); ?>
    <div class="container">
        <h1 class="mb-4">My Account</h1>
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card">
                    <div class="list-group list-group-flush">
                        <a href="account.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-user me-2"></i>Account Details
                        </a>
                        <a href="orders.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-bag me-2"></i>My Orders
                        </a>
                        <a href="track.php" class="list-group-item list-group-item-action active">
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
            <div class="col-lg-9">
                <h2 class="mb-4">Track Order</h2>
                <div class="card p-4 mb-4">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <div class="mb-4 border-bottom pb-3">
                                <h5>Order #<?= $row['order_id'] ?> <small class="text-muted">(<?= date("F j, Y, g:i a", strtotime($row['date'])) ?>)</small></h5>
                                <p><strong>Status:</strong> <?= ucfirst($row['status']) ?></p>
                                <p><strong>Items:</strong> <?= htmlspecialchars($row['items']) ?></p>
                                <div class="progress" style="height: 25px;">
                                    <?php
                                    $statuses = ['pending', 'in transit', 'completed'];
                                    $currentStatus = strtolower($row['status']);
                                    $statusIndex = array_search($currentStatus, $statuses);
                                    foreach ($statuses as $index => $label):
                                        $labelLower = strtolower($label);
                                        switch ($labelLower) {
                                            case 'pending':
                                                $color = 'bg-danger';
                                                break;
                                            case 'in transit':
                                                $color = 'bg-primary';
                                                break;
                                            case 'completed':
                                                $color = 'bg-success';
                                                break;
                                            default:
                                                $color = 'bg-secondary';
                                        }
                                        $opacity = $index <= $statusIndex ? 'opacity-100' : 'opacity-25';
                                    ?>
                                        <div class="progress-bar <?= "$color $opacity" ?>" role="progressbar" style="width: 33.3%">
                                            <?= ucwords($label) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No orders to track yet.</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>