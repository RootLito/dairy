<?php
session_start();
include("./config/conn.php");

$toastMessage = "";
$toastType = "bg-danger";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if ($user['status'] === 'pending') {
            $toastMessage = "Your account is pending approval.";
        } elseif ($user['password'] === $password) {
            $user_id = $user['user_id'];
            $update_sql = "UPDATE users SET is_active = 1 WHERE user_id = $user_id";
            mysqli_query($conn, $update_sql);

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];

            header("Location: ./user/products.php");
            exit;
        } else {
            $toastMessage = "Incorrect password. Please try again.";
        }
    } else {
        $toastMessage = "No account found with that email.";
    }

    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DairyMart - Login</title>
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

    <!-- Toast container -->
    <div id="toast-container" aria-live="polite" aria-atomic="true" class="d-flex justify-content-center">
        <?php if ($toastMessage): ?>
            <div class="toast align-items-center <?php echo $toastType; ?> text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo htmlspecialchars($toastMessage); ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <main class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-sm mb-5">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Login</h4>
                            <a href="index.php" class="text-white text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i>Home
                            </a>
                        </div>

                        <div class="card-body p-4">
                            <p class="text-muted mb-4">Welcome back! Please enter your credentials to access your account.</p>
                            <form method="post" action="login.php" id="loginForm">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label for="password" class="form-label">Password</label>
                                        <a href="#" class="text-decoration-none small">Forgot Password?</a>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="showPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-4">
                                <p class="mb-0">Don't have an account? <a href="register.php" class="text-decoration-none">Register here</a></p>
                            </div>

                            <footer class="bg-dark text-white py-5 mt-4">
                                <div class="container">
                                    <hr>
                                    <div class="row">
                                        <p class="mb-0 text-center text-sm">&copy; 2025 DairyMart. All rights reserved.</p>
                                    </div>
                                </div>
                            </footer>
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
                    delay: 5000
                });
                toast.show();
            }

            const showPasswordBtn = document.getElementById('showPassword');
            const passwordInput = document.getElementById('password');

            showPasswordBtn.addEventListener('click', () => {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    showPasswordBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    showPasswordBtn.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    </script>
</body>

</html>