<?php
session_start();
include('./../config/conn.php');
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("User not logged in.");
}

$sql = "SELECT r.rating, r.title, r.details, r.created_at,
               p.product_id, p.product_name, p.product_image,
               a.shop_name
        FROM reviews r
        JOIN products p ON r.product_id = p.product_id
        JOIN admin a ON r.admin_id = a.admin_id
        WHERE r.user_id = ?
        ORDER BY r.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$reviews = $result->fetch_all(MYSQLI_ASSOC);

if (!$reviews) {
    $reviews = [];
}


if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Your Cart</title>
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
                <div class="col-lg-3 mb-4">
                    <div class="card">
                        <div class="list-group list-group-flush">
                            <a href="account.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-user me-2"></i>Account Details
                            </a>
                            <a href="orders.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-shopping-bag me-2"></i>My Orders
                            </a>
                            <a href="track.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-truck me-2"></i>Track Order
                            </a>
                            <a href="cart.php" class="list-group-item list-group-item-action ">
                                <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
                            </a>
                            <a href="review.php" class="list-group-item list-group-item-action active">
                                <i class="fas fa-star me-2"></i>Rate and Review
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <h2 class="mb-4">Products You've Reviewed</h2>

                    <div class="card p-4">
                        <div class="container mt-4">

                            <?php if (count($reviews) === 0): ?>
                                <p>You haven't reviewed any products yet.</p>
                            <?php else: ?>
                                <?php foreach ($reviews as $review): ?>
                                    <div class="card mb-3">
                                        <div class="row g-0">
                                            <div class="col-md-3 text-center p-3">
                                                <img src="<?= htmlspecialchars($review['product_image']) ?>" alt="<?= htmlspecialchars($review['product_name']) ?>" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                                                <p class="mt-2 mb-0"><small>Shop: <strong><?= htmlspecialchars($review['shop_name']) ?></strong></small></p>
                                                <a href="product-details.php?id=<?= $review['product_id'] ?>" class="btn btn-sm btn-outline-primary mt-2">View Product</a>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= htmlspecialchars($review['product_name']) ?></h5>
                                                    <p>
                                                        <?php
                                                        $fullStars = floor($review['rating']);
                                                        $halfStar = ($review['rating'] - $fullStars) >= 0.5;
                                                        for ($i = 1; $i <= 5; $i++) {
                                                            if ($i <= $fullStars) {
                                                                echo '<i class="fas fa-star text-warning"></i> ';
                                                            } elseif ($halfStar && $i == $fullStars + 1) {
                                                                echo '<i class="fas fa-star-half-alt text-warning"></i> ';
                                                            } else {
                                                                echo '<i class="far fa-star text-warning"></i> ';
                                                            }
                                                        }
                                                        ?>
                                                    </p>
                                                    <h6><?= htmlspecialchars($review['title']) ?></h6>

                                                    <p class="card-text"><?= nl2br(htmlspecialchars($review['details'])) ?></p>
                                                    <p class="card-text"><small class="text-muted">Reviewed on <?= date("F j, Y", strtotime($review['created_at'])) ?></small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>