<?php
session_start();
include("./../config/conn.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ./../index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = mysqli_real_escape_string($conn, $_POST['firstName'] ?? '');
    $last_name = mysqli_real_escape_string($conn, $_POST['lastName'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');
    $birthdate = mysqli_real_escape_string($conn, $_POST['birthdate'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');

    $profile_image_path = null;

    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profileImage']['tmp_name'];
        $fileName = $_FILES['profileImage']['name'];
        $fileSize = $_FILES['profileImage']['size'];
        $fileType = $_FILES['profileImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = __DIR__ . '/../assets/profiles/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $newFileName = $user_id . '_' . time() . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $profile_image_path = 'assets/profiles/' . $newFileName;

                $old_image = '';
                $result = mysqli_query($conn, "SELECT image FROM users WHERE user_id = $user_id LIMIT 1");
                if ($result && mysqli_num_rows($result) === 1) {
                    $row = mysqli_fetch_assoc($result);
                    $old_image = $row['image'];
                }
                if ($old_image && file_exists(__DIR__ . "/../" . $old_image)) {
                    unlink(__DIR__ . "/../" . $old_image);
                }
            } else {
                $error_message = 'There was an error moving the uploaded file.';
            }
        } else {
            $error_message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
        }
    }

    $updateSql = "UPDATE users SET
        first_name = '$first_name',
        last_name = '$last_name',
        email = '$email',
        phone = '$phone',
        birthdate = '$birthdate',
        gender = '$gender'";

    if ($profile_image_path !== null) {
        $updateSql .= ", image = '$profile_image_path'";
    }

    $updateSql .= " WHERE user_id = $user_id";

    if (mysqli_query($conn, $updateSql)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $error_message = "Error updating record: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM users WHERE user_id = $user_id LIMIT 1";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
} else {
    $user = null;
}





if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DairyMart - My Account</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="static/css/styles.css" rel="stylesheet" />
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
                            <a href="account.php" class="list-group-item list-group-item-action active">
                                <i class="fas fa-user me-2"></i>Account Details
                            </a>
                            <a href="orders.php" class="list-group-item list-group-item-action">
                                <i class="fas fa-shopping-bag me-2"></i>My Orders
                            </a>
                            <a href="track.php" class="list-group-item list-group-item-action">
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
                    <?php if (!empty($error_message)) : ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    <?php if ($user && !empty($user['profile_image']) && file_exists(__DIR__ . '/../' . $user['profile_image'])): ?>
                                        <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image" class="rounded-circle img-fluid" style="width: 80px; height: 80px; object-fit: cover;" />
                                    <?php else: ?>
                                        <div class="avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-2" style="width: 80px; height: 80px; font-size: 2rem;">
                                            <?php
                                            if ($user) {
                                                echo strtoupper(substr($user['first_name'], 0, 1) . substr($user['last_name'], 0, 1));
                                            } else {
                                                echo "NA";
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-7 mb-3 mb-md-0">
                                    <h4 class="mb-1"><?php echo $user ? htmlspecialchars($user['first_name'] . " " . $user['last_name']) : ""; ?></h4>
                                    <p class="text-muted mb-0"><?php echo $user ? htmlspecialchars($user['email']) : ""; ?></p>
                                    <p class="text-muted mb-0">Member since: April 1</p>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <!-- <form method="post" enctype="multipart/form-data" id="profileImageForm">
                                        <label for="profileImageInput" class="btn btn-primary mb-2 mb-md-0">
                                            <i class="fas fa-camera me-1"></i> Change Photo
                                        </label>
                                        <input type="file" name="profileImage" id="profileImageInput" accept="image/*" style="display:none" onchange="document.getElementById('profileImageForm').submit();" />
                                    </form> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Personal Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <input type="hidden" name="profileImage" value="" />
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user ? $user['first_name'] : ""); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user ? $user['last_name'] : ""); ?>" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user ? $user['email'] : ""); ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user ? $user['phone'] : ""); ?>">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="birthdate" class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($user ? $user['birthdate'] : ""); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Gender</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" <?php if ($user && $user['gender'] == 'male') echo "checked"; ?>>
                                            <label class="form-check-label" for="genderMale">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female" <?php if ($user && $user['gender'] == 'female') echo "checked"; ?>>
                                            <label class="form-check-label" for="genderFemale">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other" <?php if ($user && $user['gender'] == 'other') echo "checked"; ?>>
                                            <label class="form-check-label" for="genderOther">Other</label>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </form>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Change Password</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="currentPassword" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                                </div>
                                <div class="mb-3">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                                </div>
                                <div class="mb-3">
                                    <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.replit.com/agent/bootstrap.bundle.min.js"></script>
</body>

</html>