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
                            <a href="account.php" class="list-group-item list-group-item-action ">
                                <i class="fas fa-user me-2"></i>Account Details
                            </a>
                            <a href="orders.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-shopping-bag me-2"></i>My Orders
                            </a>
                            <a href="track.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-truck me-2"></i>Track Order
                            </a>
                            <a href="cart.php" class="list-group-item list-group-item-action active">
                                <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
                            </a>
                            <a href="review.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-star me-2"></i>Rate and Review
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card mb-4">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="p-3">Product</th>
                                            <th scope="col" class="p-3 text-center">Quantity</th>
                                            <th scope="col" class="p-3 text-center">Price</th>
                                            <th scope="col" class="p-3 text-center">Total</th>
                                            <th scope="col" class="p-3 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Item 1 -->
                                        <tr>
                                            <td class="p-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1572449043416-55f4685c9bbf?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Organic Whole Milk" class="img-fluid rounded" style="width: 80px;">
                                                    <div class="ms-3">
                                                        <h6 class="mb-0">Organic Whole Milk</h6>
                                                        <small class="text-muted">1 Gallon</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">
                                                <div class="input-group input-group-sm w-75 mx-auto">
                                                    <button class="btn btn-outline-secondary" type="button">-</button>
                                                    <input type="number" class="form-control text-center" value="1" min="1">
                                                    <button class="btn btn-outline-secondary" type="button">+</button>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">₱4.99</td>
                                            <td class="p-3 text-center fw-bold">₱4.99</td>
                                            <td class="p-3 text-center">
                                                <button class="btn btn-sm btn-outline-danger" title="Remove Item">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Item 2 -->
                                        <tr>
                                            <td class="p-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1624937327495-94d357104cfd?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Cheddar Cheese Block" class="img-fluid rounded" style="width: 80px;">
                                                    <div class="ms-3">
                                                        <h6 class="mb-0">Cheddar Cheese Block</h6>
                                                        <small class="text-muted">16 oz</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">
                                                <div class="input-group input-group-sm w-75 mx-auto">
                                                    <button class="btn btn-outline-secondary" type="button">-</button>
                                                    <input type="number" class="form-control text-center" value="1" min="1">
                                                    <button class="btn btn-outline-secondary" type="button">+</button>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">₱6.49</td>
                                            <td class="p-3 text-center fw-bold">₱6.49</td>
                                            <td class="p-3 text-center">
                                                <button class="btn btn-sm btn-outline-danger" title="Remove Item">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Item 3 -->
                                        <tr>
                                            <td class="p-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="https://images.unsplash.com/photo-1632923295091-b9c6e8cda0a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Greek Yogurt" class="img-fluid rounded" style="width: 80px;">
                                                    <div class="ms-3">
                                                        <h6 class="mb-0">Greek Yogurt</h6>
                                                        <small class="text-muted">32 oz</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">
                                                <div class="input-group input-group-sm w-75 mx-auto">
                                                    <button class="btn btn-outline-secondary" type="button">-</button>
                                                    <input type="number" class="form-control text-center" value="1" min="1">
                                                    <button class="btn btn-outline-secondary" type="button">+</button>
                                                </div>
                                            </td>
                                            <td class="p-3 text-center">₱5.99</td>
                                            <td class="p-3 text-center fw-bold">₱5.99</td>
                                            <td class="p-3 text-center">
                                                <button class="btn btn-sm btn-outline-danger" title="Remove Item">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                        </button>
                        <button class="btn btn-outline-danger">
                            <i class="fas fa-trash-alt me-2"></i>Clear Cart
                        </button>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Apply Coupon Code</h5>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter coupon code" />
                                <button class="btn btn-primary" type="button">Apply</button>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Subtotal</span>
                                <span>₱2,147.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Tax</span>
                                <span>₱171.76</span>
                            </div>
                            <hr />
                            <div class="d-flex justify-content-between mb-3">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold">₱2,318.76</span>
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-primary btn-lg">
                                    <i class="fas fa-lock me-2"></i>Proceed to Checkout
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt me-1"></i> Secure Checkout
                                </small>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>