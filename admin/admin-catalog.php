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
if (isset($_POST['pullout_submit'])) {
    $product_id = (int) $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];
    $price = (float) $_POST['price'];

    if ($quantity > 0 && $price >= 0) {
        $sql = "INSERT INTO pull_out (product_id, quantity, price) VALUES ($product_id, $quantity, $price)";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: ./admin-catalog.php");
            exit;
        } else {
            echo "<script>alert('Failed to save pullout.');</script>";
        }
    } else {
        echo "<script>alert('Invalid quantity or price.');</script>";
    }
} elseif (isset($_POST['product_id']) && isset($_POST['price'])) {
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
    <title>TechMart - Dairy Products</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('./sidebar.php') ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <section class="py-5">
                    <div class="container">
                        <div class="row">
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
                                                            <div class="d-flex align-items-center">
                                                                <p class="card-text text-truncate mb-0" style="max-width: 85%;">
                                                                    <?= htmlspecialchars($product['description']) ?>
                                                                </p>
                                                                <button type="button" class="btn btn-sm btn-success ms-2" data-bs-toggle="modal" data-bs-target="#descModal<?= $product['product_id'] ?>" style="font-size: 0.7rem;">
                                                                    Details
                                                                </button>
                                                            </div>
                                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                                <span class="fs-5 fw-bold">₱<?php echo number_format($product['price'], 2); ?></span>

                                                                <div class="d-flex">
                                                                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#pulloutModal<?= $product['product_id'] ?>">
                                                                        <i class="fas fa-box-open me-1"></i> Pullout
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="descModal<?= $product['product_id'] ?>" tabindex="-1" aria-labelledby="descModalLabel<?= $product['product_id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="descModalLabel<?= $product['product_id'] ?>">Description of <?= htmlspecialchars($product['product_name']) ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <?= nl2br(htmlspecialchars($product['description'])) ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="pulloutModal<?= $product['product_id'] ?>" tabindex="-1" aria-labelledby="pulloutModalLabel<?= $product['product_id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="pulloutModalLabel<?= $product['product_id'] ?>">Pullout <?= htmlspecialchars($product['product_name']) ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

                                                                    <div class="mb-3">
                                                                        <label for="productName<?= $product['product_id'] ?>" class="form-label">Product Name</label>
                                                                        <input
                                                                            type="text"
                                                                            class="form-control"
                                                                            id="productName<?= $product['product_id'] ?>"
                                                                            value="<?= htmlspecialchars($product['product_name']) ?>"
                                                                            readonly>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="quantity<?= $product['product_id'] ?>" class="form-label">Quantity</label>
                                                                        <input
                                                                            type="number"
                                                                            class="form-control"
                                                                            id="quantity<?= $product['product_id'] ?>"
                                                                            name="quantity"
                                                                            min="1"
                                                                            max="<?= (int)$product['initial_stock'] ?>"
                                                                            required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="price<?= $product['product_id'] ?>" class="form-label">Price (₱)</label>
                                                                        <input
                                                                            type="number"
                                                                            class="form-control"
                                                                            id="price<?= $product['product_id'] ?>"
                                                                            name="price"
                                                                            min="0"
                                                                            step="0.01"
                                                                            value="<?= htmlspecialchars($product['price']) ?>"
                                                                            required>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-primary btn-sm" name="pullout_submit">Confirm Pullout</button>
                                                                </div>
                                                            </div>
                                                        </form>

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

                            </div>
                            <div class="col-lg-3 mb-4 mb-lg-0">
                                <div class="card sticky-lg-top" style="top: 1rem; z-index: 1;">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Pullout Products</h5>
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
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>