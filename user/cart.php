<?php

session_start(); 
include('./../config/conn.php');
$user_id = $_SESSION['user_id']; 

$sql = "SELECT cart.*, products.product_name, products.product_image, products.price
        FROM cart
        JOIN products ON cart.product_id = products.product_id
        WHERE cart.user_id = $user_id";

$result = mysqli_query($conn, $sql);

$cart_items = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
    }
}

if (isset($_POST['delete_cart_id'])) {
    $delete_cart_id = $_POST['delete_cart_id'];

    $delete_sql = "DELETE FROM cart WHERE cart_id = ?";
    if ($stmt = mysqli_prepare($conn, $delete_sql)) {
        mysqli_stmt_bind_param($stmt, "i", $delete_cart_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        header('Location: cart.php');
        exit; 
    }
}


if (isset($_POST['clear_cart'])) {
    $user_id = $_SESSION['user_id'];

    $clear_sql = "DELETE FROM cart WHERE user_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $clear_sql)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        header('Location: cart.php');
        exit;
    }
}


$subtotal = 0;
$shipping = 0; 
$total = 0;

$sql = "SELECT c.quantity, p.price 
        FROM cart c 
        JOIN products p ON c.product_id = p.product_id 
        WHERE c.user_id = ?";
        
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    while ($item = mysqli_fetch_assoc($result)) {
        $subtotal += $item['quantity'] * $item['price'];
    }
    
    mysqli_stmt_close($stmt);
}

$total = $subtotal + $shipping;


if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];
    
    if ($quantity > 0) {
        $update_sql = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
        
        if ($stmt = mysqli_prepare($conn, $update_sql)) {
            mysqli_stmt_bind_param($stmt, "ii", $quantity, $cart_id);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: cart.php');
                exit;
            }
            mysqli_stmt_close($stmt);
        }
    }
}

if (isset($_POST['checkout'])) {
    // Get the current user ID from session
    $user_id = $_SESSION['user_id'];

    // Get the current date (for order creation)
    $order_date = date('Y-m-d H:i:s');

    // Fetch cart items for the user
    $cart_sql = "SELECT c.cart_id, c.product_id, c.quantity, c.total, p.admin_id FROM cart c INNER JOIN products p ON c.product_id = p.product_id WHERE c.user_id = ?";
    $cart_stmt = $conn->prepare($cart_sql);
    $cart_stmt->bind_param("i", $user_id);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result();

    if ($cart_result->num_rows > 0) {
        while ($cart_item = $cart_result->fetch_assoc()) {
            $cart_id = $cart_item['cart_id'];
            $product_id = $cart_item['product_id'];
            $quantity = $cart_item['quantity'];
            $total = $cart_item['total'];
            $admin_id = $cart_item['admin_id'];

            $order_sql = "INSERT INTO orders (admin_id, user_id, product_id, date, items, total, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $order_stmt = $conn->prepare($order_sql);
            $status = 'pending'; 
            $order_stmt->bind_param("iiisdis", $admin_id, $user_id, $product_id, $order_date, $quantity, $total, $status);
            $order_stmt->execute();
        }

        $clear_cart_sql = "DELETE FROM cart WHERE user_id = ?";
        $clear_cart_stmt = $conn->prepare($clear_cart_sql);
        $clear_cart_stmt->bind_param("i", $user_id);
        $clear_cart_stmt->execute();

        header("Location: cart.php");
        exit;
    } else {
        echo "Your cart is empty!";
    }
}


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT SUM(quantity) AS total_items FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_items = 0;
    if ($row = $result->fetch_assoc()) {
        $total_items = $row['total_items'];
    }
}
mysqli_free_result($result);
mysqli_close($conn);
?>

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
        <?php
        if (count($cart_items) > 0) {
            foreach ($cart_items as $item) {
                $total_price = $item['price'] * $item['quantity'];
                ?>
                <tr>
                    <td class="p-3">
                        <div class="d-flex align-items-center">
                            <img src="<?php echo $item['product_image']; ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="img-fluid rounded" style="width: 80px;">
                            <div class="ms-3">
                                <h6 class="mb-0"><?php echo htmlspecialchars($item['product_name']); ?></h6>
                            </div>
                        </div>
                    </td>
                    <td class="p-3 text-center">
                    <form method="POST" action="cart.php" class="d-flex">
    <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
    <input type="number" class="form-control text-center" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" style="width: 70px;"> 
    <button type="submit" class="btn btn-sm btn-outline-success ms-2" title="Update Quantity" style="height: 32px;"> 
        <i class="fas fa-check"></i>
    </button>
</form>

</td>
<td class="p-3 text-center">
    ₱<?php echo number_format($item['price'], 2); ?>
</td>
<td class="p-3 text-center">
    ₱<?php echo number_format($item['quantity'] * $item['price'], 2); ?>
</td>
                    <td class="p-3 text-center">
                    <form method="POST" class="d-inline">
    <input type="hidden" name="delete_cart_id" value="<?php echo $item['cart_id']; ?>">
    <button type="submit" class="btn btn-sm btn-outline-danger" title="Remove Item">
        <i class="fas fa-trash-alt"></i>
    </button>
</form>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='5' class='text-center p-3'>Your cart is empty.</td></tr>";
        }
        ?>
    </tbody>
</table>

                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <a href="products.php" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                        </a>
                        <form method="POST">
    <button type="submit" name="clear_cart" class="btn btn-outline-danger">
        <i class="fas fa-trash-alt me-2"></i>Clear Cart
    </button>
</form>
                    </div>


                    <div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Order Summary</h5>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <span>Subtotal</span>
            <span>₱<?php echo number_format($subtotal, 2); ?></span>
        </div>
        <div class="d-flex justify-content-between mb-3">
            <span>Shipping</span>
            <span>Free</span>
        </div>
        <hr />
        <div class="d-flex justify-content-between mb-3">
            <span class="fw-bold">Total</span>
            <span class="fw-bold">₱<?php echo number_format($total, 2); ?></span>
        </div>

    <form method="POST" class="d-grid mt-4">
        <button type="submit" name="checkout" class="btn btn-primary btn-lg">
            <i class="fas fa-lock me-2"></i>Proceed to Checkout
        </button>
    </form>


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