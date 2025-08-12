<?php
session_start();



include("./../config/conn.php");

$sqlAdmins = "SELECT * FROM admin ORDER BY created_at DESC";
$resultAdmins = mysqli_query($conn, $sqlAdmins);
$admins = [];
if ($resultAdmins && mysqli_num_rows($resultAdmins) > 0) {
    while ($row = mysqli_fetch_assoc($resultAdmins)) {
        $admins[] = $row;
    }
}

$sqlUsers = "SELECT user_id, first_name, last_name, email, status, is_active, created_at FROM users ORDER BY created_at DESC";
$resultUsers = mysqli_query($conn, $sqlUsers);
$users = [];
if ($resultUsers && mysqli_num_rows($resultUsers) > 0) {
    while ($row = mysqli_fetch_assoc($resultUsers)) {
        $users[] = $row;
    }
}

$sqlActiveUsers = "SELECT COUNT(*) AS active_count FROM users WHERE is_active = 1";
$resultActiveUsers = mysqli_query($conn, $sqlActiveUsers);
$activeUsersCount = 0;
if ($resultActiveUsers && $row = mysqli_fetch_assoc($resultActiveUsers)) {
    $activeUsersCount = $row['active_count'];
}
$sqlApproved = "SELECT COUNT(*) AS count FROM users WHERE status = 'approved'";
$resultApproved = mysqli_query($conn, $sqlApproved);
$approvedCount = ($resultApproved && $row = mysqli_fetch_assoc($resultApproved)) ? $row['count'] : 0;

$sqlPending = "SELECT COUNT(*) AS count FROM users WHERE status = 'pending'";
$resultPending = mysqli_query($conn, $sqlPending);
$pendingCount = ($resultPending && $row = mysqli_fetch_assoc($resultPending)) ? $row['count'] : 0;

$sqlRejected = "SELECT COUNT(*) AS count FROM users WHERE status = 'rejected'";
$resultRejected = mysqli_query($conn, $sqlRejected);
$rejectedCount = ($resultRejected && $row = mysqli_fetch_assoc($resultRejected)) ? $row['count'] : 0;



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['action'])) {
    $userId = $_POST['user_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        mysqli_query($conn, "UPDATE users SET status = 'approved' WHERE user_id = $userId");
    } elseif ($action === 'reject') {
        mysqli_query($conn, "UPDATE users SET status = 'rejected' WHERE user_id = $userId");
    } elseif ($action === 'delete') {
        mysqli_query($conn, "DELETE FROM users WHERE user_id = $userId");
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_id'], $_POST['action'])) {
    $adminId = (int)$_POST['admin_id'];
    $action = $_POST['action'];

    if ($action === 'suspend') {
        mysqli_query($conn, "UPDATE admin SET status = 'Suspended' WHERE admin_id = $adminId");
    } elseif ($action === 'unsuspend') {
        mysqli_query($conn, "UPDATE admin SET status = 'Full access' WHERE admin_id = $adminId");
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}



if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ./../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Role Management</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php include('./sidebar.php') ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Role Management</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportRoleReport()">
                            <i class="fas fa-download me-1"></i> Export Report
                        </button>
                    </div>
                </div>

                <div id="alertContainer"></div>

                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h4 class="mb-0" id="activeUsers"><?php echo $activeUsersCount; ?></h4>
                                <p class="mb-0">Active Users</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h4 class="mb-0" id="totalRoles"><?php echo $approvedCount; ?></h4>
                                <p class="mb-0">Approved Users</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h4 class="mb-0" id="pendingApprovals"><?php echo $pendingCount; ?></h4>
                                <p class="mb-0">Pending Approvals</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h4 class="mb-0" id="roleChanges"><?php echo $rejectedCount; ?></h4>
                                <p class="mb-0">Rejected</p>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- User Management Table -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Admin</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Shop Name</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($admins)): ?>
                                        <?php foreach ($admins as $admin): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($admin['full_name']); ?></td>
                                                <td><?php echo htmlspecialchars($admin['email']); ?></td>
                                                <td>
                                                    <?php 
                                                    $status = trim($admin['status']);
                                                    if (empty($status) || strtolower($status) === 'full access'): ?>
                                                        <span class="badge bg-success">Full Access</span>
                                                    <?php elseif (strtolower($status) === 'suspended'): ?>
                                                        <span class="badge bg-danger">Suspended</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-secondary"><?php echo htmlspecialchars($admin['status']); ?></span>
                                                    <?php endif; ?>
                                                </td>


                                                <td><?php echo htmlspecialchars($admin['shop_name']); ?></td>
                                                <td><?php echo date('Y-m-d', strtotime($admin['created_at'])); ?></td>
                                                <td>
                                                    <form method="POST" style="display:inline;">
                                                        <input type="hidden" name="admin_id" value="<?php echo $admin['admin_id']; ?>">
                                                        <button type="submit" name="action" value="unsuspend" class="btn btn-sm btn-outline-success"
                                                            <?php echo strtolower($admin['status']) === 'full access' ? 'disabled' : ''; ?>>
                                                            Unsuspend
                                                        </button>
                                                    </form>
                                                    <form method="POST" style="display:inline;">
                                                        <input type="hidden" name="admin_id" value="<?php echo $admin['admin_id']; ?>">
                                                        <button type="submit" name="action" value="suspend" class="btn btn-sm btn-outline-danger"
                                                            <?php echo strtolower($admin['status']) === 'suspended' ? 'disabled' : ''; ?>>
                                                            Suspend
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No Admins found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Users</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Active Status</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Registration Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td>
                                                    <?php if ($user['is_active']): ?>
                                                        <span class="badge bg-success">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Inactive</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td>
                                                    <?php
                                                    $status = strtolower(trim($user['status']));
                                                    switch ($status) {
                                                        case 'approved':
                                                            $badgeClass = 'bg-success';
                                                            break;
                                                        case 'pending':
                                                            $badgeClass = 'bg-warning text-dark';
                                                            break;
                                                        case 'rejected':
                                                            $badgeClass = 'bg-danger';
                                                            break;
                                                        default:
                                                            $badgeClass = 'bg-secondary';
                                                            $status = 'Unknown';
                                                    }
                                                    ?>
                                                    <span class="badge <?php echo $badgeClass; ?>">
                                                        <?php echo ucfirst($status); ?>
                                                    </span>
                                                </td>


                                                <td><?php echo date('Y-m-d', strtotime($user['created_at'])); ?></td>
                                                <td>
                                                    <form method="POST" style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                        <input type="hidden" name="action" value="approve">
                                                        <button class="btn btn-sm btn-outline-success" 
                                                            <?php echo strtolower(trim($user['status'])) === 'approved' ? 'disabled' : ''; ?>>
                                                            Approve
                                                        </button>
                                                    </form>

                                                    <form method="POST" style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                                        <input type="hidden" name="action" value="reject">
                                                        <button class="btn btn-sm btn-outline-danger" 
                                                            <?php echo strtolower(trim($user['status'])) === 'rejected' ? 'disabled' : ''; ?>>
                                                            Reject
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No Users found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>