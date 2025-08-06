<?php
session_start();
include('./../config/conn.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid product ID.";
    exit();
}

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to perform this action.");
}
$user_id = $_SESSION['user_id'];

$product_id = (int) $_GET['id'];

$sql = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Product not found.";
    exit();
}

$product = $result->fetch_assoc();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    $user_id = $_SESSION['user_id'] ?? null;
    $product_id = $_POST['product_id'] ?? null;
    $rating = $_POST['rating'] ?? 0;
    $title = trim($_POST['title'] ?? '');
    $details = trim($_POST['details'] ?? '');

    if (!$user_id) {
        die("You must be logged in to submit a review.");
    }
    if (!$product_id || $rating < 1 || $rating > 5 || empty($title)) {
        die("Invalid review data.");
    }

    $admin_id = null;
    $sql = "SELECT admin_id FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($admin_id);
    if (!$stmt->fetch()) {
        die("Product not found.");
    }
    $stmt->close();

    $sql = "INSERT INTO reviews (product_id, admin_id, user_id, rating, title, details) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiiss", $product_id, $admin_id, $user_id, $rating, $title, $details);

    if ($stmt->execute()) {
        header("Location: product-details.php?id=" . $product_id . "&review=success");
        exit;
    } else {
        echo "Error submitting review.";
    }
}


?>



<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Premium Aged Cheddar</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>

<body>
    <?php include './includes/nav.php'; ?>

    <main>


        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="product-images">
                            <div class="main-image bg-white rounded" style="height: 400px; overflow: hidden;">
                                <img src="<?= htmlspecialchars($product['product_image']) ?>"
                                    alt="<?= htmlspecialchars($product['product_name']) ?>"
                                    class="img-fluid d-block mx-auto"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="product-details">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h1 class="h2 mb-0"><?= htmlspecialchars($product['product_name']) ?></h1>
                                <!-- <button class="btn btn-link p-0 text-danger" title="Add to Wishlist">
                                    <i class="far fa-heart fa-lg"></i>
                                </button> -->
                            </div>
                            <div class="text-muted mb-3">Product Code: <?= htmlspecialchars($product['sku']) ?></div>

                            <div class="ratings mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="text-warning me-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                    </div>
                                    <div class="text-muted small">4.7 (123 reviews)</div>
                                </div>
                            </div>

                            <div class="pricing mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="h3 mb-0 text-primary me-2">₱<?= number_format($product['price'], 2) ?></div>
                                </div>
                                <div class="small <?= ($product['initial_stock'] > 0) ? 'text-success' : 'text-danger' ?> mt-1">
                                    <?= ($product['initial_stock'] > 0) ? 'In Stock' : 'Out of Stock' ?>
                                </div>
                            </div>

                            <div class="description mb-4">
                                <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                            </div>




                            <div class="actions mb-4">
                                <div class="row g-2">
                                    <div class="col-sm-6">
                                        <button class="btn btn-primary btn-lg w-100" id="addToCart">
                                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                        </button>
                                    </div>
                                    <div class="col-sm-6">
                                        <button class="btn btn-success btn-lg w-100" data-bs-toggle="modal" data-bs-target="#writeReviewModal">
                                            <i class="fas fa-pen me-2"></i>Write a Review
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="features mb-4">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-truck-fast text-primary me-2"></i>
                                            <div class="small">Free shipping on orders over ₱50</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-box-open text-primary me-2"></i>
                                            <div class="small">30-day satisfaction guarantee</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-shield-halved text-primary me-2"></i>
                                            <div class="small">Secure payment processing</div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-temperature-low text-primary me-2"></i>
                                            <div class="small">Temperature-controlled shipping</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="writeReviewModal" tabindex="-1" aria-labelledby="writeReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="writeReviewModalLabel">Write a Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="reviewRating" class="form-label">Overall Rating</label>
                            <div class="rating-stars mb-2" id="ratingStars">
                                <i class="far fa-star fs-4 me-1 star" data-value="1"></i>
                                <i class="far fa-star fs-4 me-1 star" data-value="2"></i>
                                <i class="far fa-star fs-4 me-1 star" data-value="3"></i>
                                <i class="far fa-star fs-4 me-1 star" data-value="4"></i>
                                <i class="far fa-star fs-4 star" data-value="5"></i>
                            </div>
                            <input type="hidden" id="reviewRating" name="rating" value="0">
                        </div>

                        <div class="mb-3">
                            <label for="reviewTitle" class="form-label">Review Title</label>
                            <input type="text" class="form-control" id="reviewTitle" name="title" required placeholder="Summarize your experience">
                        </div>

                        <div class="mb-3">
                            <label for="reviewBody" class="form-label">Review Details</label>
                            <textarea class="form-control" id="reviewBody" name="details" rows="5" required placeholder="Tell others about your experience with this product"></textarea>
                        </div>

                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Review Submitted</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Thank you for submitting your review! It has been saved successfully.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const stars = document.querySelectorAll('#ratingStars .star');
        const ratingInput = document.getElementById('reviewRating');
        let currentRating = 0;

        stars.forEach(star => {
            star.addEventListener('mouseover', () => {
                const val = parseInt(star.getAttribute('data-value'));
                highlightStars(val);
            });

            star.addEventListener('mouseout', () => {
                highlightStars(currentRating);
            });

            star.addEventListener('click', () => {
                currentRating = parseInt(star.getAttribute('data-value'));
                ratingInput.value = currentRating;
                highlightStars(currentRating);
            });
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                const val = parseInt(star.getAttribute('data-value'));
                if (val <= rating) {
                    star.classList.remove('far');
                    star.classList.add('fas', 'text-warning');
                } else {
                    star.classList.add('far');
                    star.classList.remove('fas', 'text-warning');
                }
            });
        }
    </script>
</body>

</html>