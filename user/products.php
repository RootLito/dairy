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
                        <div class="d-flex">
                            <button class="btn btn-primary me-3">
                                <i class="fas fa-filter me-2"></i>Filter Products
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-outline-light dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Sort By
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                                    <li><a class="dropdown-item" href="#">Best Sellers</a></li>
                                    <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                                    <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                                    <li><a class="dropdown-item" href="#">Newest Arrivals</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="https://images.unsplash.com/photo-1628088062854-d1870b4553da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" alt="Dairy Products" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <!-- Filters and Products Grid -->
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <!-- Filters Sidebar -->
                    <div class="col-lg-3 mb-4 mb-lg-0">
                        <div class="card sticky-lg-top" style="top: 1rem; z-index: 1;">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Filters</h5>
                            </div>
                            <div class="card-body">
                                <!-- Category Filter -->
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

                                <!-- Price Range Filter -->
                                <div class="mb-4">
                                    <h6 class="mb-3">Price Range</h6>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>₱0</span>
                                        <span class="price-range-display">₱50</span>
                                    </div>
                                    <input type="range" class="form-range" min="0" max="50" step="1" value="50" id="priceRange">
                                </div>

                                <!-- Dietary Preferences -->
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

                                <!-- Brands Filter -->
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

                                <!-- Rating Filter -->
                                <div class="mb-4">
                                    <h6 class="mb-3">Customer Rating</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="ratingFilter" id="rating4up" checked>
                                        <label class="form-check-label" for="rating4up">
                                            <div class="text-warning">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            & Up
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="ratingFilter" id="rating3up">
                                        <label class="form-check-label" for="rating3up">
                                            <div class="text-warning">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="far fa-star"></i>
                                                <i class="far fa-star"></i>
                                            </div>
                                            & Up
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ratingFilter" id="ratingAll">
                                        <label class="form-check-label" for="ratingAll">
                                            All Ratings
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary">Apply Filters</button>
                                    <button class="btn btn-outline-secondary">Reset Filters</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="col-lg-9">
                        <!-- Milk Products Section -->
                        <section id="milk" class="mb-5">
                            <h2 class="mb-4">Milk & Cream</h2>
                            <div class="row g-4">
                                <!-- Milk Product 1 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-success position-absolute top-0 end-0 m-2">ORGANIC</div>
                                        <img src="https://images.unsplash.com/photo-1563636619-e9143da7973b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Organic Whole Milk">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Milk</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span class="text-muted ms-1">(4.5)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Organic Whole Milk</h5>
                                            <p class="card-text text-truncate">Farm-fresh organic whole milk, pasteurized and homogenized, rich in nutrients.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱4.99</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Milk Product 2 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-info position-absolute top-0 end-0 m-2">LOW FAT</div>
                                        <img src="https://images.unsplash.com/photo-1576186726115-4d51596775d1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Low-Fat Milk">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Milk</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <span class="text-muted ms-1">(4.0)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Low-Fat Milk (1%)</h5>
                                            <p class="card-text text-truncate">Creamy and smooth low-fat milk, perfect for everyday consumption.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱3.99</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Milk Product 3 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-warning position-absolute top-0 end-0 m-2">LACTOSE-FREE</div>
                                        <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Lactose-Free Milk">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Milk</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <span class="text-muted ms-1">(5.0)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Lactose-Free Milk</h5>
                                            <p class="card-text text-truncate">Real milk with lactase enzyme added for easier digestion, great taste without discomfort.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱5.49</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Heavy Cream -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <img src="https://images.unsplash.com/photo-1557142046-c704a3266b9b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Heavy Cream">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Cream</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span class="text-muted ms-1">(4.7)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Premium Heavy Cream</h5>
                                            <p class="card-text text-truncate">Rich and indulgent heavy cream, perfect for baking and cooking.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱4.29</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Cheese Products Section -->
                        <section id="cheese" class="mb-5">
                            <h2 class="mb-4">Cheese</h2>
                            <div class="row g-4">
                                <!-- Cheese Product 1 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-primary position-absolute top-0 end-0 m-2">AGED</div>
                                        <img src="https://images.unsplash.com/photo-1566454825481-9c704264a707?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Cheddar Cheese">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Cheese</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <span class="text-muted ms-1">(4.9)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Aged Cheddar Cheese</h5>
                                            <p class="card-text text-truncate">Sharp and flavorful cheddar cheese, aged for 24 months.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱7.99</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cheese Product 2 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-success position-absolute top-0 end-0 m-2">ARTISAN</div>
                                        <img src="https://images.unsplash.com/photo-1588010431045-3f5128169602?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Gouda Cheese">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Cheese</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span class="text-muted ms-1">(4.5)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Smoked Gouda Cheese</h5>
                                            <p class="card-text text-truncate">Creamy gouda with a distinctive smoky flavor, perfect for sandwiches and charcuterie boards.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱8.49</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cheese Product 3 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-primary position-absolute top-0 end-0 m-2">IMPORTED</div>
                                        <img src="https://images.unsplash.com/photo-1452195100486-9cc805987862?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Blue Cheese">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Cheese</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <span class="text-muted ms-1">(4.2)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Italian Blue Cheese</h5>
                                            <p class="card-text text-truncate">Rich and bold blue cheese imported from Italy, ideal for salads and pasta dishes.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱9.99</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Yogurt Products Section -->
                        <section id="yogurt" class="mb-5">
                            <h2 class="mb-4">Yogurt & Smoothies</h2>
                            <div class="row g-4">
                                <!-- Yogurt Product 1 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-success position-absolute top-0 end-0 m-2">GREEK</div>
                                        <img src="https://images.unsplash.com/photo-1488477181946-6428a0291777?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Greek Yogurt">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Yogurt</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <span class="text-muted ms-1">(4.9)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Greek Yogurt Variety Pack</h5>
                                            <p class="card-text text-truncate">Assorted flavors of creamy high-protein Greek yogurt, perfect for breakfast or snacks.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱6.99</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Yogurt Product 2 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-info position-absolute top-0 end-0 m-2">LOW SUGAR</div>
                                        <img src="https://images.unsplash.com/photo-1505252585461-04db1eb84625?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Probiotic Yogurt">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Yogurt</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <span class="text-muted ms-1">(4.1)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Probiotic Plain Yogurt</h5>
                                            <p class="card-text text-truncate">Rich in live active cultures for gut health, versatile for sweet or savory dishes.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱4.49</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Smoothie Product -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-danger position-absolute top-0 end-0 m-2">NEW</div>
                                        <img src="https://images.unsplash.com/photo-1571942676516-bcab84649e44?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Berry Smoothie">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Smoothie</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span class="text-muted ms-1">(4.6)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Mixed Berry Smoothie</h5>
                                            <p class="card-text text-truncate">Ready-to-drink smoothie made with real yogurt and mixed berries, perfect for on-the-go.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱3.99</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Butter & Cream Section -->
                        <section id="butter" class="mb-5">
                            <h2 class="mb-4">Butter & Cream</h2>
                            <div class="row g-4">
                                <!-- Butter Product 1 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-success position-absolute top-0 end-0 m-2">GRASS-FED</div>
                                        <img src="https://images.unsplash.com/photo-1589985270958-bf20ad23a15a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Grass-Fed Butter">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Butter</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <span class="text-muted ms-1">(5.0)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Irish Grass-Fed Butter</h5>
                                            <p class="card-text text-truncate">Rich, golden butter from grass-fed cows, with a naturally higher omega-3 content.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱6.49</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Butter Product 2 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-info position-absolute top-0 end-0 m-2">WHIPPED</div>
                                        <img src="https://images.unsplash.com/photo-1600419991300-1985c6eb7c1c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Whipped Butter">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Butter</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <span class="text-muted ms-1">(4.0)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Whipped Butter with Sea Salt</h5>
                                            <p class="card-text text-truncate">Light and airy whipped butter with a touch of sea salt, spreadable straight from the refrigerator.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱4.99</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cream Product -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-primary position-absolute top-0 end-0 m-2">ORGANIC</div>
                                        <img src="https://images.unsplash.com/photo-1514228742587-6b1558fcca3d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Sour Cream">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Cream</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span class="text-muted ms-1">(4.5)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Organic Sour Cream</h5>
                                            <p class="card-text text-truncate">Rich and tangy organic sour cream, perfect for topping baked potatoes or adding to recipes.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱3.79</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Specialty Products Section -->
                        <section id="specialty" class="mb-5">
                            <h2 class="mb-4">Specialty Dairy Products</h2>
                            <div class="row g-4">
                                <!-- Specialty Product 1 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-danger position-absolute top-0 end-0 m-2">ARTISAN</div>
                                        <img src="https://images.unsplash.com/photo-1605790557839-d7e516b3f3a3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Artisan Feta">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Specialty</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star-half-alt"></i>
                                                    <span class="text-muted ms-1">(4.7)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Artisan Feta in Brine</h5>
                                            <p class="card-text text-truncate">Traditional sheep's milk feta, crumbly and tangy, perfect for salads and Mediterranean dishes.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱8.99</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Specialty Product 2 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-warning position-absolute top-0 end-0 m-2">IMPORTED</div>
                                        <img src="https://images.unsplash.com/photo-1626957341926-98953ef9b6d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Mascarpone">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Specialty</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <span class="text-muted ms-1">(4.9)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Italian Mascarpone</h5>
                                            <p class="card-text text-truncate">Smooth and creamy Italian mascarpone cheese, essential for authentic tiramisu.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱6.49</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Specialty Product 3 -->
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100">
                                        <div class="badge bg-success position-absolute top-0 end-0 m-2">PLANT-BASED</div>
                                        <img src="https://images.unsplash.com/photo-1576618148400-f54bed99fcfd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Almond Milk">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="badge bg-primary">Specialty</span>
                                                <div class="text-warning">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="far fa-star"></i>
                                                    <span class="text-muted ms-1">(4.2)</span>
                                                </div>
                                            </div>
                                            <h5 class="card-title">Organic Almond Milk</h5>
                                            <p class="card-text text-truncate">Creamy plant-based alternative to dairy milk, made from organic almonds.</p>
                                            <div class="d-flex align-items-center justify-content-between mt-3">
                                                <span class="fs-5 fw-bold">₱4.99</span>
                                                <button class="btn btn-primary">
                                                    <i class="fas fa-cart-plus me-1"></i> Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Pagination -->
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