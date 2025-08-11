<?php
session_start();
include("./config/conn.php");


$sql = "SELECT * FROM products WHERE is_active = 1 ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Home</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>

<body>
    <?php include 'nav.php'; ?>

    <section class="bg-dark text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h1 class="display-4 fw-bold mb-3">Fresh Dairy Products</h1>
                    <p class="fs-5 mb-4">Discover premium dairy products from local farms and renowned dairies worldwide.</p>
                    <div class="d-flex gap-3">
                        <a href="login.php" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Shop Now
                        </a>
                        <a href="login.php" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-tag me-2"></i>View Deals
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="rounded overflow-hidden shadow-lg">
                        <img src="https://images.unsplash.com/photo-1628088062854-d1870b4553da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Fresh Dairy Products" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Featured Categories</h2>
            <div class="row g-4">
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="products.php#milk" class="text-decoration-none">
                        <div class="card bg-dark text-white hover-lift h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-wine-bottle fa-3x mb-3"></i>
                                <h5 class="card-title mb-0">Milk & Cream</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="products.php#cheese" class="text-decoration-none">
                        <div class="card bg-dark text-white hover-lift h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-cheese fa-3x mb-3"></i>
                                <h5 class="card-title mb-0">Cheese</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="products.php#yogurt" class="text-decoration-none">
                        <div class="card bg-dark text-white hover-lift h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-blender fa-3x mb-3"></i>
                                <h5 class="card-title mb-0">Yogurt</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="products.php#butter" class="text-decoration-none">
                        <div class="card bg-dark text-white hover-lift h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-cookie fa-3x mb-3"></i>
                                <h5 class="card-title mb-0">Butter</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="products.php#icecream" class="text-decoration-none">
                        <div class="card bg-dark text-white hover-lift h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-ice-cream fa-3x mb-3"></i>
                                <h5 class="card-title mb-0">Ice Cream</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="products.php#specialty" class="text-decoration-none">
                        <div class="card bg-dark text-white hover-lift h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-star fa-3x mb-3"></i>
                                <h5 class="card-title mb-0">Specialty</h5>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-body-tertiary">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Dairymart Products</h2>
                <a href="login.php" class="btn btn-link text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-4">

                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100">

                            <?php if (!empty($product['product_image'])): ?>
                                <img src="uploads/<?= $product['product_image'] ?>" class="card-img-top" alt="<?= $product['product_name'] ?>">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/600x400?text=No+Image" class="card-img-top" alt="No Image">
                            <?php endif; ?>

                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary"><?= ucfirst($product['category']) ?></span>
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                        <span class="text-muted ms-1">(4.2)</span>
                                    </div>
                                </div>

                                <h5 class="card-title"><?= $product['product_name'] ?></h5>
                                <p class="card-text text-truncate"><?= $product['description'] ?></p>

                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <span class="fs-5 fw-bold">₱<?= number_format($product['price'], 2) ?></span>
                                    <a href="./login.php" class="btn btn-primary">
                                        <i class="fas fa-cart-plus me-1"></i> Add
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <p class="mb-0 text-center">&copy; 2025 DairyMart. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>