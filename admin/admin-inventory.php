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
            <!-- Sidebar -->
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="px-3 mb-4">
                        <a href="index.html" class="text-decoration-none">
                            <h5 class="text-primary">
                                <i class="fas fa-store me-2"></i>DairyMart Admin
                            </h5>
                        </a>
                        <div class="small text-muted">Dashboard Control Panel</div>
                    </div>
                    <hr>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="admin-dashboard.html">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-users.html">
                                <i class="fas fa-users me-2"></i>
                                User Management
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="admin-inventory.html">
                                <i class="fas fa-boxes me-2"></i>
                                Inventory
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-orders.html">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Orders
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-reports.html">
                                <i class="fas fa-chart-line me-2"></i>
                                Reports
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-income.html">
                                <i class="fas fa-money-bill-wave me-2"></i>
                                Income & Expenses
                            </a>
                        </li>
                    </ul>
                    
                    <hr>
                    <div class="px-3 mt-4">
                        <div class="d-flex align-items-center pb-3">
                            <div class="avatar-circle me-3">
                                <span>AD</span>
                            </div>
                            <div>
                                <h6 class="mb-0">Admin User</h6>
                                <div class="small text-muted">System Administrator</div>
                            </div>
                        </div>
                        <div class="d-grid">
                            <a href="login.html" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt me-2"></i>Log Out
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <!-- Header with Notification -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Inventory Management</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <i class="fas fa-plus me-1"></i> Add Product
                        </button>
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary export-data-btn" data-type="inventory-csv">
                                <i class="fas fa-file-csv me-1"></i> CSV
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary export-data-btn" data-type="inventory-pdf">
                                <i class="fas fa-file-pdf me-1"></i> PDF
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Alert Container -->
                <div id="alertContainer"></div>
                
                <!-- Inventory Filter Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Filter Inventory</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="inventorySearch" placeholder="Search">
                                    <label for="inventorySearch">Search Products</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select" id="categoryFilter">
                                        <option value="">All Categories</option>
                                        <option value="milk">Milk</option>
                                        <option value="cheese">Cheese</option>
                                        <option value="yogurt">Yogurt</option>
                                        <option value="butter">Butter</option>
                                        <option value="icecream">Ice Cream</option>
                                    </select>
                                    <label for="categoryFilter">Category</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select" id="stockFilter">
                                        <option value="">All Stock Levels</option>
                                        <option value="low">Low Stock (< 10)</option>
                                        <option value="normal">Normal Stock (10-50)</option>
                                        <option value="high">High Stock (> 50)</option>
                                    </select>
                                    <label for="stockFilter">Stock Level</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select" id="statusFilter">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <label for="statusFilter">Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Inventory Table -->
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Product Inventory</h5>
                        <span class="badge bg-primary">125 Products</span>
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
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="product1Check">
                                                <label class="form-check-label" for="product1Check"></label>
                                            </div>
                                        </td>
                                        <td>#2001</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/60x60?text=Milk" class="rounded me-3" alt="Product Image" width="60" height="60">
                                                <div>
                                                    <div class="fw-medium">Organic Whole Milk - 1 Gallon</div>
                                                    <div class="small text-muted">SKU: MILK-ORG-GAL</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Milk</td>
                                        <td>₱5.99</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm stock-input" value="45" min="0" data-product-id="2001" style="width: 80px;">
                                        </td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="productActionDropdown1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="productActionDropdown1">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>View Sales</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-tags me-2"></i>Manage Promotions</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="product2Check">
                                                <label class="form-check-label" for="product2Check"></label>
                                            </div>
                                        </td>
                                        <td>#2002</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/60x60?text=Cheese" class="rounded me-3" alt="Product Image" width="60" height="60">
                                                <div>
                                                    <div class="fw-medium">Premium Aged Cheddar - 8oz</div>
                                                    <div class="small text-muted">SKU: CHEESE-CHED-8OZ</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Cheese</td>
                                        <td>₱6.49</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm stock-input" value="28" min="0" data-product-id="2002" style="width: 80px;">
                                        </td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="productActionDropdown2" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="productActionDropdown2">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>View Sales</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-tags me-2"></i>Manage Promotions</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="product3Check">
                                                <label class="form-check-label" for="product3Check"></label>
                                            </div>
                                        </td>
                                        <td>#2003</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/60x60?text=Yogurt" class="rounded me-3" alt="Product Image" width="60" height="60">
                                                <div>
                                                    <div class="fw-medium">Greek Yogurt - Plain - 32oz</div>
                                                    <div class="small text-muted">SKU: YOG-GRK-32OZ</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Yogurt</td>
                                        <td>₱4.29</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm stock-input" value="8" min="0" data-product-id="2003" style="width: 80px;">
                                        </td>
                                        <td><span class="badge bg-warning">Low Stock</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="productActionDropdown3" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="productActionDropdown3">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>View Sales</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-tags me-2"></i>Manage Promotions</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="product4Check">
                                                <label class="form-check-label" for="product4Check"></label>
                                            </div>
                                        </td>
                                        <td>#2004</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/60x60?text=Butter" class="rounded me-3" alt="Product Image" width="60" height="60">
                                                <div>
                                                    <div class="fw-medium">Grass-Fed Unsalted Butter - 16oz</div>
                                                    <div class="small text-muted">SKU: BUTR-GF-16OZ</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Butter</td>
                                        <td>₱5.49</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm stock-input" value="36" min="0" data-product-id="2004" style="width: 80px;">
                                        </td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="productActionDropdown4" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="productActionDropdown4">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>View Sales</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-tags me-2"></i>Manage Promotions</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="product5Check">
                                                <label class="form-check-label" for="product5Check"></label>
                                            </div>
                                        </td>
                                        <td>#2005</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="https://via.placeholder.com/60x60?text=IceCream" class="rounded me-3" alt="Product Image" width="60" height="60">
                                                <div>
                                                    <div class="fw-medium">Vanilla Bean Ice Cream - 1.5qt</div>
                                                    <div class="small text-muted">SKU: ICE-VAN-1.5QT</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Ice Cream</td>
                                        <td>₱7.99</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm stock-input" value="0" min="0" data-product-id="2005" style="width: 80px;">
                                        </td>
                                        <td><span class="badge bg-danger">Out of Stock</span></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="productActionDropdown5" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="productActionDropdown5">
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>View Sales</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fas fa-tags me-2"></i>Manage Promotions</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash-alt me-2"></i>Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <nav aria-label="Inventory pagination">
                            <ul class="pagination justify-content-center mb-0">
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
                
                <!-- Inventory Analytics Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Inventory Status</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="inventoryStatusChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Inventory by Category</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="inventoryCategoryChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Low Stock Alerts</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Greek Yogurt - Plain - 32oz</span>
                                        <span class="badge bg-warning rounded-pill">8 left</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Cottage Cheese - 16oz</span>
                                        <span class="badge bg-warning rounded-pill">5 left</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Vanilla Bean Ice Cream - 1.5qt</span>
                                        <span class="badge bg-danger rounded-pill">0 left</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Chocolate Milk - 1qt</span>
                                        <span class="badge bg-warning rounded-pill">4 left</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <span>Strawberry Yogurt - 6oz</span>
                                        <span class="badge bg-warning rounded-pill">7 left</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-sm btn-primary">Order Inventory</button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" required>
                            </div>
                            <div class="col-md-4">
                                <label for="productSKU" class="form-label">SKU</label>
                                <input type="text" class="form-control" id="productSKU" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="productCategory" class="form-label">Category</label>
                                <select class="form-select" id="productCategory" required>
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
                                <input type="number" class="form-control" id="productPrice" min="0.01" step="0.01" required>
                            </div>
                            <div class="col-md-4">
                                <label for="productStock" class="form-label">Initial Stock</label>
                                <input type="number" class="form-control" id="productStock" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="productDescription" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="productImage">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="productWeight" class="form-label">Weight/Volume</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="productWeight" min="0" step="0.01">
                                    <select class="form-select" id="weightUnit" style="max-width: 100px;">
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
                                <input type="text" class="form-control" id="productTags" placeholder="organic, fresh, local">
                            </div>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="productStatus" checked>
                            <label class="form-check-label" for="productStatus">Product Active</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Product</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="static/js/admin.js"></script>
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
</body>
</html>