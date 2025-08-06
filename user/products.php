<?php
session_start();
include("./../config/conn.php");


if (!isset($_SESSION['user_id'])) {
    header("Location: ./../index.php");
    exit;
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ./../index.php");
    exit;
}

if (isset($_POST['product_id']) && isset($_POST['price'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $price = $_POST['price'];
    $quantity = 1;

    $total = $price * $quantity;

    $admin_sql = "SELECT admin_id FROM products WHERE product_id = ?";
    $admin_stmt = $conn->prepare($admin_sql);
    $admin_stmt->bind_param("i", $product_id);
    $admin_stmt->execute();
    $admin_result = $admin_stmt->get_result();

    if ($admin_result->num_rows > 0) {
        $admin_data = $admin_result->fetch_assoc();
        $admin_id = $admin_data['admin_id'];
    } else {
        echo "Product not found.";
        exit;
    }

    $sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cart_item = $result->fetch_assoc();
        $new_quantity = $cart_item['quantity'] + $quantity;
        $new_total = $price * $new_quantity;

        $update_sql = "UPDATE cart SET quantity = ?, total = ?, admin_id = ? WHERE user_id = ? AND product_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("iiiii", $new_quantity, $new_total, $admin_id, $user_id, $product_id);
        $update_stmt->execute();
    } else {
        $insert_sql = "INSERT INTO cart (user_id, product_id, quantity, price, total, admin_id) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iiidii", $user_id, $product_id, $quantity, $price, $total, $admin_id);
        $insert_stmt->execute();
    }

    header("Location: cart.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMart - Dairy Products</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/nav.php"); ?>

    <main>
        <section class="bg-dark py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h1 class="display-4 fw-bold">Fresh Dairy Products</h1>
                        <p class="fs-5 mb-4">Discover our selection of premium dairy products from local farms and renowned dairies worldwide.</p>
                    </div>
                    <div class="col-lg-6">
                        <img src="./../assets/images/cover.jpg" alt="Dairy Products" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 mb-4 mb-lg-0">
                        <div class="card sticky-lg-top" style="top: 1rem; z-index: 1;">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Filters</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h6 class="mb-3">Categories</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterMilk" checked>
                                        <label class="form-check-label" for="filterMilk">Milk & Cream</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterCheese" checked>
                                        <label class="form-check-label" for="filterCheese">Cheese</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterYogurt" checked>
                                        <label class="form-check-label" for="filterYogurt">Yogurt & Smoothies</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterButter" checked>
                                        <label class="form-check-label" for="filterButter">Butter & Spreads</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="filterSpecialty" checked>
                                        <label class="form-check-label" for="filterSpecialty">Specialty Dairy</label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="mb-3">Price Range</h6>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>₱0</span>
                                        <span class="price-range-display">₱50</span>
                                    </div>
                                    <input type="range" class="form-range" min="0" max="50" step="1" value="50" id="priceRange">
                                </div>

                                <div class="mb-4">
                                    <h6 class="mb-3">Dietary Preferences</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterOrganic">
                                        <label class="form-check-label" for="filterOrganic">Organic</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterLactoseFree">
                                        <label class="form-check-label" for="filterLactoseFree">Lactose-Free</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterLowFat">
                                        <label class="form-check-label" for="filterLowFat">Low-Fat</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="filterPlantBased">
                                        <label class="form-check-label" for="filterPlantBased">Plant-Based</label>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h6 class="mb-3">Brands</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterBrand1" checked>
                                        <label class="form-check-label" for="filterBrand1">Organic Valley</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterBrand2" checked>
                                        <label class="form-check-label" for="filterBrand2">Horizon</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterBrand3" checked>
                                        <label class="form-check-label" for="filterBrand3">Kerrygold</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="filterBrand4" checked>
                                        <label class="form-check-label" for="filterBrand4">Chobani</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="filterBrand5" checked>
                                        <label class="form-check-label" for="filterBrand5">Local Farms</label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary">Apply Filters</button>
                                    <button class="btn btn-outline-secondary">Reset Filters</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <section id="products" class="mb-5">
                            <h2 class="mb-4">All Products</h2>
                            <div class="row g-4">
                                <?php
                                $sql = "SELECT * FROM products";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($product = mysqli_fetch_assoc($result)) {
                                ?>
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card h-100">
                                                <img src="<?php echo $product['product_image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="badge bg-primary"><?php echo htmlspecialchars($product['category']); ?></span>
                                                    </div>
                                                    <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                                    <p class="card-text text-truncate"><?php echo htmlspecialchars($product['description']); ?></p>
                                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                                        <span class="fs-5 fw-bold">₱<?php echo number_format($product['price'], 2); ?></span>

                                                        <form method="POST" class="d-flex">
                                                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                                                            <button type="submit" class="btn btn-primary me-2">
                                                                <i class="fas fa-cart-plus me-1"></i>
                                                            </button>
                                                        </form>
                                                        <a href="product-details.php?id=<?php echo $product['product_id']; ?>" class="btn btn-info">
                                                            <i class="fas fa-eye me-1"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<p>No products available.</p>";
                                }

                                mysqli_free_result($result);
                                mysqli_close($conn);
                                ?>
                            </div>
                        </section>





                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
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
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="mb-3">DairyMart</h5>
                    <p>Your one-stop shop for all your dairy needs. Quality products from local farms and international dairies, fresh and delivered right to your doorstep.</p>
                    <div class="d-flex mt-4">
                        <a href="#" class="me-3 text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="me-3 text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="me-3 text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-white">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2 mb-4 mb-md-0">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php" class="text-decoration-none text-white">Home</a></li>
                        <li class="mb-2"><a href="products.php" class="text-decoration-none text-white">Products</a></li>
                        <li class="mb-2"><a href="about.php" class="text-decoration-none text-white">About Us</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-decoration-none text-white">Contact</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Blog</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-2 mb-4 mb-md-0">
                    <h5 class="mb-3">Customer Service</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-white">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-white">Shipping</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-white">Returns</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-white">Freshness Guarantee</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Support</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-4">
                    <h5 class="mb-3">Contact Us</h5>
                    <address>
                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Dairy Lane, Fresh City, Country</p>
                        <p class="mb-2"><i class="fas fa-phone me-2"></i> (123) 456-7890</p>
                        <p class="mb-2"><i class="fas fa-envelope me-2"></i> info@dairymart.com</p>
                    </address>
                    <div class="mt-3">
                        <h6>We Accept</h6>
                        <div class="d-flex mt-2">
                            <i class="fab fa-cc-visa fa-2x me-2"></i>
                            <i class="fab fa-cc-mastercard fa-2x me-2"></i>
                            <i class="fab fa-cc-amex fa-2x me-2"></i>
                            <i class="fab fa-cc-paypal fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-0">&copy; 2025 DairyMart. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                        <li class="list-inline-item ms-3"><a href="#" class="text-white text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="static/js/user.js"></script>
</body>

</html>