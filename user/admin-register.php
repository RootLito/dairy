<?php
session_start();
include("./../config/conn.php");

$toastMessage = "";
$toastType = "bg-success";

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $shop_name = $_POST['shop_name'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($full_name == "" || $shop_name == "" || $address == "" || $contact == "" || $email == "" || $password == "") {
        $toastMessage = "Please fill all fields.";
        $toastType = "bg-danger";
    } else {
        $created_at = date("Y-m-d H:i:s");
        $sql = "INSERT INTO admin (user_id, full_name, shop_name, address, contact, email, password, created_at) VALUES ($user_id, '$full_name', '$shop_name', '$address', '$contact', '$email', '$password', '$created_at')";

        if (mysqli_query($conn, $sql)) {
            $toastMessage = "Admin account created successfully.";
            $toastType = "bg-success";
        } else {
            $toastMessage = "Error: " . mysqli_error($conn);
            $toastType = "bg-danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DairyMart - Register</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="static/css/styles.css" rel="stylesheet" />
    <style>
        #toast-container {
            position: fixed;
            top: 1rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1080;
        }
    </style>
</head>

<body>

    <div id="toast-container" aria-live="polite" aria-atomic="true" class="d-flex justify-content-center">
        <?php if ($toastMessage): ?>
            <div class="toast align-items-center <?php echo $toastType; ?> text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $toastMessage; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <main class="d-flex justify-content-center align-items-center min-vh-100 py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm mb-5">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Register Shop</h4>
                            <a href="products.php" class="text-white text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i>Home
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted mb-4">
                                Already have an account? <a href="admin-login.php" class="text-decoration-none">Login</a>.
                            </p>

                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="shop_name" class="form-label">Shop Name</label>
                                    <input type="text" class="form-control" id="shop_name" name="shop_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input type="text" class="form-control" id="contact" name="contact" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <label for="password" class="form-label">Password</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password', this)" aria-label="Toggle password visibility">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password', this)" aria-label="Toggle password visibility">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-user-plus me-2"></i>Create Account
                                    </button>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toastEl = document.querySelector('.toast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });
                toast.show();
            }
        });
    </script>
    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            }
        }
    </script>
</body>

</html>