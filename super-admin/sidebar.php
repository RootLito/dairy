<!-- Sidebar -->
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
    <div class="position-sticky pt-3 d-flex flex-column">
        <div class="px-3 mb-4">
            <a href="index.php" class="text-decoration-none">
                <h5 class="text-danger">
                    <i class="fas fa-crown me-2"></i>DairyMart Super Admin
                </h5>
            </a>
            <div class="small text-muted">System Control Center</div>
        </div>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="super-admin-dashboard.php">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="super-admin-users.php">
                    <i class="fas fa-users-cog me-2"></i>
                    Role
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="super-admin-activities.php">
                    <i class="fas fa-eye me-2"></i>
                    Activity Monitor
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="super-admin-analytics.php">
                    <i class="fas fa-chart-bar me-2"></i>
                    Analytics
                </a>
            </li>
        </ul>

        <form method="post" class="btn btn-outline-danger btn-sm w-100 mt-5">
            <button type="submit" name="logout" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Log Out</button>
        </form>
    </div>
</nav>