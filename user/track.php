<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DairyMart - Place and Track Order</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="static/css/styles.css" rel="stylesheet" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-cheese me-2"></i>DairyMart
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                            <li><a class="dropdown-item" href="products.php#laptops">Laptops</a></li>
                            <li><a class="dropdown-item" href="products.php#smartphones">Smartphones</a></li>
                            <li><a class="dropdown-item" href="products.php#tablets">Tablets</a></li>
                            <li><a class="dropdown-item" href="products.php#audio">Audio</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="products.php#accessories">Accessories</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
                <form class="d-flex mb-2 mb-lg-0 me-lg-3">
                    <input class="form-control me-2" type="search" placeholder="Search for products..." aria-label="Search" />
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="d-flex">
                    <a href="cart.php" class="btn btn-outline-primary position-relative me-2">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle active" type="button" id="userDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fas fa-user me-1"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="login.php">Login</a></li>
                            <li><a class="dropdown-item" href="register.php">Register</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item active" href="account.php">My Account</a></li>
                            <li><a class="dropdown-item" href="orders.php">My Orders</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <div class="container my-5">
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
                        <a href="track.php" class="list-group-item list-group-item-action active">
                            <i class="fas fa-truck me-2"></i>Track Order
                        </a>
                        <a href="cart.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
                        </a>
                        <a href="review.php" class="list-group-item list-group-item-action">
                            <i class="fas fa-star me-2"></i>Rate and Review
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <h2 class="mb-4">Place and Track Order</h2>

                <div class="card p-4 mb-4">
                    <h5 class="mb-3">Track Your Order</h5>
                    <div class="mb-3">
                        <label for="orderNumber" class="form-label">Order Number</label>
                        <input
                            type="text"
                            class="form-control"
                            id="orderNumber"
                            placeholder="Enter your order number" />
                    </div>
                    <button class="btn btn-primary">Track Order</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>