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
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-cheese me-2"></i>DairyMart
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
                
                <div class="d-flex">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Login / Register <i class="fas fa-user me-1"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="login.php">Login</a></li>
                            <li><a class="dropdown-item" href="register.php">Register</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <!-- Hero Section -->
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

    <!-- Featured Products -->
    <section class="py-5 bg-body-tertiary">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Featured Products</h2>
                <a href="products.php" class="btn btn-link text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="badge bg-danger position-absolute top-0 end-0 m-2">SALE</div>
                        <img src="https://images.unsplash.com/photo-1628088062854-d1870b4553da?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Organic Milk">
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
                            <p class="card-text text-truncate">Fresh organic whole milk from grass-fed cows. Rich, creamy and full of nutrients.</p>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <div>
                                    <span class="text-muted text-decoration-line-through">₱5.99</span>
                                    <span class="fs-5 fw-bold ms-2">₱4.99</span>
                                </div>
                                <button class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="badge bg-primary position-absolute top-0 end-0 m-2">NEW</div>
                        <img src="https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Aged Cheddar">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">Cheese</span>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="text-muted ms-1">(5.0)</span>
                                </div>
                            </div>
                            <h5 class="card-title">Aged Cheddar Reserve</h5>
                            <p class="card-text text-truncate">Premium aged cheddar with rich, complex flavor and sharp, crumbly texture. Aged 24 months.</p>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <span class="fs-5 fw-bold">₱8.99</span>
                                <button class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <img src="https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Greek Yogurt">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">Yogurt</span>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="text-muted ms-1">(4.0)</span>
                                </div>
                            </div>
                            <h5 class="card-title">Premium Greek Yogurt</h5>
                            <p class="card-text text-truncate">Creamy, protein-rich Greek yogurt. Perfect for breakfast or as a healthy snack.</p>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <span class="fs-5 fw-bold">₱3.49</span>
                                <button class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="badge bg-success position-absolute top-0 end-0 m-2">BESTSELLER</div>
                        <img src="https://images.unsplash.com/photo-1570197788417-0e82375c9371?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Artisan Butter">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">Butter</span>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="text-muted ms-1">(4.7)</span>
                                </div>
                            </div>
                            <h5 class="card-title">Artisan Cultured Butter</h5>
                            <p class="card-text text-truncate">Hand-crafted European-style cultured butter with sea salt. Rich, complex flavor.</p>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <span class="fs-5 fw-bold">₱6.99</span>
                                <button class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Special Deals Banner -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="card bg-dark text-white overflow-hidden hover-lift">
                        <img src="https://images.unsplash.com/photo-1604328698692-f76ea9498e76?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" class="card-img" alt="Cheese Collection">
                        <div class="card-img-overlay d-flex flex-column justify-content-end" style="background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);">
                            <h3 class="card-title">Artisan Cheese Collection</h3>
                            <p class="card-text">Save 15% when you purchase our premium cheese collection sampler.</p>
                            <a href="products.php#cheese" class="btn btn-primary mt-2 align-self-start">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card bg-dark text-white overflow-hidden hover-lift mb-4">
                        <img src="https://images.unsplash.com/photo-1559598467-f8b76c8155d0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" class="card-img" alt="Yogurt Special">
                        <div class="card-img-overlay d-flex flex-column justify-content-end" style="background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);">
                            <h3 class="card-title">Probiotic Yogurt Collection</h3>
                            <p class="card-text">Up to 30% off our premium probiotic yogurt varieties.</p>
                            <a href="products.php#yogurt" class="btn btn-primary mt-2 align-self-start">View Deals</a>
                        </div>
                    </div>
                    <div class="d-flex gap-4">
                        <div class="bg-primary rounded p-4 text-white text-center flex-grow-1 hover-lift">
                            <i class="fas fa-truck-fast fa-2x mb-3"></i>
                            <h5>Free Shipping</h5>
                            <p class="mb-0">On orders over ₱50</p>
                        </div>
                        <div class="bg-primary rounded p-4 text-white text-center flex-grow-1 hover-lift">
                            <i class="fas fa-headset fa-2x mb-3"></i>
                            <h5>24/7 Support</h5>
                            <p class="mb-0">Expert assistance</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- New Arrivals -->
    <section class="py-5 bg-body-tertiary">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">New Arrivals</h2>
                <a href="products.php#new" class="btn btn-link text-decoration-none">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="row g-4">
                <!-- New Arrival 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="badge bg-primary position-absolute top-0 end-0 m-2">NEW</div>
                        <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Organic Blue Cheese">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">Cheese</span>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="text-muted ms-1">(5.0)</span>
                                </div>
                            </div>
                            <h5 class="card-title">Organic Blue Cheese</h5>
                            <p class="card-text text-truncate">Premium artisanal blue cheese made with organic milk from local pasture-raised cows.</p>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <span class="fs-5 fw-bold">₱9.99</span>
                                <button class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Arrival 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="badge bg-primary position-absolute top-0 end-0 m-2">NEW</div>
                        <img src="https://images.unsplash.com/photo-1576506295286-5cda18df9ef4?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Coconut Yogurt">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">Yogurt</span>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="text-muted ms-1">(4.0)</span>
                                </div>
                            </div>
                            <h5 class="card-title">Coconut Milk Yogurt</h5>
                            <p class="card-text text-truncate">Dairy-free probiotic yogurt made with organic coconut milk. Rich and creamy texture.</p>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <span class="fs-5 fw-bold">₱4.49</span>
                                <button class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Arrival 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="badge bg-primary position-absolute top-0 end-0 m-2">NEW</div>
                        <img src="https://images.unsplash.com/photo-1632347170292-927fc9a45361?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Whipped Butter">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">Butter</span>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="text-muted ms-1">(4.5)</span>
                                </div>
                            </div>
                            <h5 class="card-title">Honey Whipped Butter</h5>
                            <p class="card-text text-truncate">Light and airy whipped butter blended with organic wildflower honey. Perfect for spreading.</p>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <span class="fs-5 fw-bold">₱5.49</span>
                                <button class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New Arrival 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100">
                        <div class="badge bg-primary position-absolute top-0 end-0 m-2">NEW</div>
                        <img src="https://images.unsplash.com/photo-1561658286-ec958e075bed?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="Caramel Ice Cream">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-primary">Ice Cream</span>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="text-muted ms-1">(4.9)</span>
                                </div>
                            </div>
                            <h5 class="card-title">Salted Caramel Ice Cream</h5>
                            <p class="card-text text-truncate">Creamy artisanal ice cream with homemade salted caramel swirls and caramel chunks.</p>
                            <div class="d-flex align-items-center justify-content-between mt-3">
                                <span class="fs-5 fw-bold">₱7.99</span>
                                <button class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
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