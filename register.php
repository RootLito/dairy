<?php
include("./config/conn.php");

$toastMessage = "";
$toastType = "bg-success";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];
    $birthdate = $_POST['birthdate'];  
    $gender = $_POST['gender'];        

    if ($password !== $confirm_password) {
        $toastMessage = "Passwords do not match.";
        $toastType = "bg-danger";
    } else {
        $sql = "INSERT INTO users (first_name, last_name, email, phone, password, birthdate, gender) 
            VALUES ('$first_name', '$last_name', '$email', '$phone', '$password', '$birthdate', '$gender')";
        if (mysqli_query($conn, $sql)) {
            $toastMessage = "Registration successful!";
            $toastType = "bg-success";
        } else {
            if (mysqli_errno($conn) == 1062) {
                $toastMessage = "This email address is already registered.";
            } else {
                $toastMessage = "Error: " . mysqli_error($conn);
            }
            $toastType = "bg-danger";
        }
    }
    mysqli_close($conn);
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
                        <?php echo htmlspecialchars($toastMessage); ?>
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
                            <h4 class="mb-0">Register</h4>
                            <a href="index.php" class="text-white text-decoration-none">
                                <i class="fas fa-arrow-left me-2"></i>Home
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted mb-4">
                                Join DairyMart to shop our wide selection of tech products. Already have an account? <a href="login.php" class="text-decoration-none">Login</a>.
                            </p>

                            <form id="registerForm" method="post" action="register.php">
                                <h5 class="mb-3">Personal Information</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" required />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" required />
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="birthdate" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="birthdate" name="birthdate" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label d-block">Gender</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" />
                                            <label class="form-check-label" for="genderMale">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" />
                                            <label class="form-check-label" for="genderFemale">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other" />
                                            <label class="form-check-label" for="genderOther">Other</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" required />
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" />
                                    <div class="form-text">For order updates and delivery notifications</div>
                                </div>

                                <h5 class="mt-4 mb-3">Account Security</h5>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required />
                                    <div class="form-text">Password must be at least 8 characters and include a number and a special character</div>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required />
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-user-plus me-2"></i>Create Account
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Benefits of Creating an Account</h5>
                            <div class="row mt-3">
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-history fa-2x"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6>Order History</h6>
                                            <p class="text-muted mb-0">Track your orders and view order history</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-shipping-fast fa-2x"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6>Fast Checkout</h6>
                                            <p class="text-muted mb-0">Save your details for a quicker checkout</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-heart fa-2x"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6>Wishlist</h6>
                                            <p class="text-muted mb-0">Save products to purchase later</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 text-primary">
                                            <i class="fas fa-tag fa-2x"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6>Exclusive Offers</h6>
                                            <p class="text-muted mb-0">Get access to member-only deals</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <footer class="bg-dark text-white py-5 mt-5">
                        <div class="container">
                            <hr />
                            <div class="row">
                                <p class="mb-0 text-center">&copy; 2025 DairyMart. All rights reserved.</p>
                            </div>
                        </div>
                    </footer>
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
                    delay: 2000
                });
                toast.show();
            }
        });
    </script>
</body>

</html>