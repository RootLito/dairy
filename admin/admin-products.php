<?php
session_start();
include("./../config/conn.php");

if (isset($_POST['add_product'])) {
    $product_name = $_POST['productName'];
    $sku = $_POST['productSKU'];
    $category = $_POST['productCategory'];
    $price = $_POST['productPrice'];
    $initial_stock = $_POST['productStock'];
    $description = $_POST['productDescription'];
    $weight = $_POST['productWeight'];
    $weight_unit = $_POST['weightUnit'];
    $tags = $_POST['productTags'];
    $is_active = isset($_POST['productStatus']) ? 1 : 0;

    $product_image = "";
    if (isset($_FILES['productImage'])) {
        $target_dir = "./../assets/products/";
        $target_file = $target_dir . basename($_FILES["productImage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
                $product_image = "./../assets/products/" . basename($_FILES["productImage"]["name"]);
            } else {
                $toastMessage = "Sorry, there was an error uploading your file.";
                $toastType = "bg-danger";
            }
        } else {
            $toastMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $toastType = "bg-danger";
        }
    }

    $sql = "INSERT INTO products (admin_id, product_name, category, price, sku, initial_stock, description, product_image, weight_volume, weight_unit, tags, is_active)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("issdsssssssi", $_SESSION['admin_id'], $product_name, $category, $price, $sku, $initial_stock, $description, $product_image, $weight, $weight_unit, $tags, $is_active);

        if ($stmt->execute()) {
            $toastMessage = "Product added successfully!";
            $toastType = "bg-success";
        } else {
            $toastMessage = "Error: " . $stmt->error;
            $toastType = "bg-danger";
        }
        $stmt->close();
    } else {
        $toastMessage = "Error: " . $conn->error;
        $toastType = "bg-danger";
    }
}


if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

$sql = "SELECT * FROM products WHERE admin_id = $admin_id";

$result = mysqli_query($conn, $sql);

if ($result) {
    $products = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $products = [];
    $error_message = "Error fetching products: " . mysqli_error($conn);
}



if (isset($_POST['add_category'])) {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $admin_id = $_SESSION['admin_id'];

    if (empty($category_name)) {
        echo "Category name cannot be empty.";
    } else {
        $insert_category_query = "INSERT INTO categories (category_name, admin_id) VALUES ('$category_name', '$admin_id')";
        $insert_category_result = mysqli_query($conn, $insert_category_query);

        if ($insert_category_result) {
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}


$update_id = null;
if (isset($_POST['update'])) {
    $update_id = $_POST['update_id'];
}



if (isset($_POST['update_product'])) {
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productSKU = $_POST['productSKU'];
    $productCategory = $_POST['productCategory'];
    $productPrice = $_POST['productPrice'];
    $productStock = $_POST['productStock'];
    $productDescription = $_POST['productDescription'];
    $productStatus = isset($_POST['productStatus']) ? 1 : 0;

    $product_image = "";
    if (isset($_FILES['productImage'])) {
        $target_dir = "./../assets/products/";
        $target_file = $target_dir . basename($_FILES["productImage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
                $product_image = "./../assets/products/" . basename($_FILES["productImage"]["name"]);
            } else {
                $toastMessage = "Sorry, there was an error uploading your file.";
                $toastType = "bg-danger";
            }
        } else {
            $toastMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $toastType = "bg-danger";
        }
    }

    $query = "UPDATE products SET 
                product_name = '$productName',
                sku = '$productSKU',
                category = '$productCategory',
                price = '$productPrice',
                initial_stock = '$productStock',
                description = '$productDescription',
                product_image = '$product_image',
                is_active = '$productStatus' 
              WHERE product_id = $productId";

    if (mysqli_query($conn, $query)) {
        $_SESSION['update_success'] = true;

        header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $productId);
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}

if (isset($_GET['update_id'])) {
    $productId = $_GET['update_id'];
    $query = "SELECT * FROM products WHERE product_id = $productId";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
}



if (isset($_POST['delete_product'])) {
    $delete_product_id = intval($_POST['delete_product_id']);

    $delete_query = "DELETE FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $delete_product_id);
    if ($stmt->execute()) {
        header("Location: ./admin-products.php");
    } else {
        echo "<div class='alert alert-danger'>Failed to delete product.</div>";
    }
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}




if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ./../login.php");
    exit();
}


mysqli_free_result($result);
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Inventory Management</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('./sidebar.php') ?>


            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Manage Products</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal"
                            data-bs-target="#addProductModal">
                            <i class="fas fa-plus me-1"></i> Add Product
                        </button>
                        <!-- <button type="button" class="btn btn-sm btn-success me-2" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="fas fa-plus me-1"></i> Add Category
                        </button> -->
                    </div>
                </div>

                <div id="alertContainer"></div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Product Inventory</h5>
                        <span class="badge bg-primary"><?php echo count($products); ?> Products</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="inventoryTable">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAllProducts">
                                                <label class="form-check-label" for="selectAllProducts"></label>
                                            </div>
                                        </th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Product</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($products)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center">No products available.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="product<?php echo $product['product_id']; ?>Check">
                                                        <label class="form-check-label"
                                                            for="product<?php echo $product['product_id']; ?>Check"></label>
                                                    </div>
                                                </td>
                                                <td>#<?php echo $product['product_id']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="<?php echo $product['product_image']; ?>" class="rounded me-3"
                                                            alt="Product Image" width="60" height="60">
                                                        <div>
                                                            <div class="fw-medium"><?php echo $product['product_name']; ?></div>
                                                            <div class="small text-muted">SKU: <?php echo $product['sku']; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?php echo ucfirst($product['category']); ?></td>
                                                <td>₱<?php echo number_format($product['price'], 2); ?></td>
                                                <td>
                                                    <input type="number" class="form-control form-control-sm stock-input"
                                                        value="<?php echo $product['initial_stock']; ?>" min="0"
                                                        data-product-id="<?php echo $product['product_id']; ?>"
                                                        style="width: 80px;">
                                                </td>
                                                <td><span
                                                        class="badge <?php echo $product['is_active'] ? 'bg-success' : 'bg-danger'; ?>"><?php echo $product['is_active'] ? 'Active' : 'Inactive'; ?></span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#updateProductModal<?= $product['product_id'] ?>">
                                                        Update
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteProductModal<?= $product['product_id'] ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="deleteForm">
                <input type="hidden" name="delete_id" id="delete_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteLabel">Confirm Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this order?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div id="toast-container" aria-live="polite" aria-atomic="true" class="d-flex justify-content-center">
        <?php if (isset($toastMessage)): ?>
            <div class="toast align-items-center <?php echo $toastType; ?> text-white border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo htmlspecialchars($toastMessage); ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
    </div>



    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" enctype="multipart/form-data" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="productName" required>
                            </div>
                            <div class="col-md-4">
                                <label for="productSKU" class="form-label">SKU</label>
                                <input type="text" class="form-control" id="productSKU" name="productSKU" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="productCategory" class="form-label">Category</label>
                                <select class="form-select" id="productCategory" name="productCategory" required>
                                    <option value="">Select Category</option>
                                    <option value="milk">Milk</option>
                                    <option value="cheese">Cheese</option>
                                    <option value="yogurt">Yogurt</option>
                                    <option value="butter">Butter</option>
                                    <option value="icecream">Ice Cream</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="productPrice" class="form-label">Price (₱)</label>
                                <input type="number" class="form-control" id="productPrice" name="productPrice"
                                    min="0.01" step="0.01" required>
                            </div>
                            <div class="col-md-4">
                                <label for="productStock" class="form-label">Initial Stock</label>
                                <input type="number" class="form-control" id="productStock" name="productStock" min="0"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="productDescription" name="productDescription"
                                rows="4"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="productImage" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="productImage" name="productImage">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productWeight" class="form-label">Weight/Volume</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="productWeight" name="productWeight"
                                        min="0" step="0.01">
                                    <select class="form-select" id="weightUnit" name="weightUnit"
                                        style="max-width: 100px;">
                                        <option value="oz">oz</option>
                                        <option value="lb">lb</option>
                                        <option value="g">g</option>
                                        <option value="kg">kg</option>
                                        <option value="ml">ml</option>
                                        <option value="l">l</option>
                                        <option value="gal">gal</option>
                                        <option value="qt">qt</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="productTags" class="form-label">Tags (comma separated)</label>
                                <input type="text" class="form-control" id="productTags" name="productTags"
                                    placeholder="organic, fresh, local">
                            </div>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="productStatus"
                                name="productStatus" checked>
                            <label class="form-check-label" for="productStatus">Product Active</label>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <?php foreach ($products as $product): ?>
        <div class="modal fade" id="updateProductModal<?= $product['product_id'] ?>" tabindex="-1" aria-labelledby="updateProductModalLabel<?= $product['product_id'] ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateProductModalLabel<?= $product['product_id'] ?>">Update Product #<?= $product['product_id'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">

                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <label for="productName<?= $product['product_id'] ?>" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="productName<?= $product['product_id'] ?>" name="productName" value="<?= htmlspecialchars($product['product_name'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="productSKU<?= $product['product_id'] ?>" class="form-label">SKU</label>
                                    <input type="text" class="form-control" id="productSKU<?= $product['product_id'] ?>" name="productSKU" value="<?= htmlspecialchars($product['sku'] ?? '') ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="productCategory<?= $product['product_id'] ?>" class="form-label">Category</label>
                                    <select class="form-select" id="productCategory<?= $product['product_id'] ?>" name="productCategory" required>
                                        <option value="">Select Category</option>
                                        <?php
                                        $categories = ['milk', 'cheese', 'yogurt', 'butter', 'icecream'];
                                        foreach ($categories as $cat): ?>
                                            <option value="<?= $cat ?>" <?= (isset($product['category']) && $product['category'] === $cat) ? 'selected' : '' ?>>
                                                <?= ucfirst($cat) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="productPrice<?= $product['product_id'] ?>" class="form-label">Price (₱)</label>
                                    <input type="number" class="form-control" id="productPrice<?= $product['product_id'] ?>" name="productPrice" min="0.01" step="0.01" value="<?= htmlspecialchars($product['price'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="productStock<?= $product['product_id'] ?>" class="form-label">Initial Stock</label>
                                    <input type="number" class="form-control" id="productStock<?= $product['product_id'] ?>" name="productStock" min="0" value="<?= htmlspecialchars($product['stock'] ?? '') ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="productDescription<?= $product['product_id'] ?>" class="form-label">Description</label>
                                <textarea class="form-control" id="productDescription<?= $product['product_id'] ?>" name="productDescription" rows="4"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="productImage<?= $product['product_id'] ?>" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="productImage<?= $product['product_id'] ?>" name="productImage">
                                <?php if (!empty($product['image'])): ?>
                                    <small>Current image: <?= htmlspecialchars($product['image']) ?></small>
                                <?php endif; ?>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="productWeight<?= $product['product_id'] ?>" class="form-label">Weight/Volume</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="productWeight<?= $product['product_id'] ?>" name="productWeight" min="0" step="0.01" value="<?= htmlspecialchars($product['weight'] ?? '') ?>">
                                        <select class="form-select" id="weightUnit<?= $product['product_id'] ?>" name="weightUnit" style="max-width: 100px;">
                                            <?php
                                            $units = ['oz', 'lb', 'g', 'kg', 'ml', 'l', 'gal', 'qt'];
                                            foreach ($units as $unit): ?>
                                                <option value="<?= $unit ?>" <?= (isset($product['weight_unit']) && $product['weight_unit'] === $unit) ? 'selected' : '' ?>>
                                                    <?= strtoupper($unit) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="productTags<?= $product['product_id'] ?>" class="form-label">Tags (comma separated)</label>
                                    <input type="text" class="form-control" id="productTags<?= $product['product_id'] ?>" name="productTags" value="<?= htmlspecialchars($product['tags'] ?? '') ?>" placeholder="organic, fresh, local">
                                </div>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="productStatus<?= $product['product_id'] ?>" name="productStatus" <?= (!isset($product['status']) || $product['status'] === 'active') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="productStatus<?= $product['product_id'] ?>">Product Active</label>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" name="update_product">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <?php foreach ($products as $product): ?>
        <div class="modal fade" id="deleteProductModal<?= $product['product_id'] ?>" tabindex="-1" aria-labelledby="deleteProductModalLabel<?= $product['product_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteProductModalLabel<?= $product['product_id'] ?>">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete <strong><?= htmlspecialchars($product['product_name']) ?></strong>?
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="delete_product_id" value="<?= $product['product_id'] ?>">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm" method="POST">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="category_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="add_category">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Inventory Status Chart
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('inventoryStatusChart')) {
                const ctx = document.getElementById('inventoryStatusChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['In Stock', 'Low Stock', 'Out of Stock'],
                        datasets: [{
                            data: [75, 20, 5],
                            backgroundColor: [
                                'rgba(25, 135, 84, 0.8)',
                                'rgba(255, 193, 7, 0.8)',
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
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            if (document.getElementById('inventoryCategoryChart')) {
                const ctx = document.getElementById('inventoryCategoryChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Milk', 'Cheese', 'Yogurt', 'Butter', 'Ice Cream'],
                        datasets: [{
                            label: 'Products by Category',
                            data: [28, 32, 25, 18, 22],
                            backgroundColor: 'rgba(13, 110, 253, 0.8)'
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
    <script>
        var confirmDeleteModal = document.getElementById('confirmDeleteModal');
        confirmDeleteModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var orderId = button.getAttribute('data-orderid');
            var input = confirmDeleteModal.querySelector('#delete_id');
            input.value = orderId;
        });
    </script>
</body>

</html>