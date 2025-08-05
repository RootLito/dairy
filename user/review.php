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
                    <div class="card p-4">
                        <h5 class="mb-3">Leave a Review</h5>
                        <div class="mb-3">
                            <label for="reviewText" class="form-label">Your Review</label>
                            <textarea class="form-control" id="reviewText" rows="3" placeholder="Write your review here..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary">Submit Review</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>

</html>