// Super Admin Dashboard JavaScript
class SuperAdminDashboard {
    constructor() {
        this.userActivityChart = null;
        this.roleDistributionChart = null;
        this.isInitialized = false;
    }

    init() {
        if (this.isInitialized) return;
        
        this.checkSuperAdminAuth();
        this.initializeDashboardData();
        this.setupEventListeners();
        this.createCharts();
        this.loadRecentActivities();
        this.isInitialized = true;
    }

    checkSuperAdminAuth() {
        const currentUser = JSON.parse(localStorage.getItem('currentUser') || '{}');
        if (!currentUser.role || currentUser.role !== 'super_admin') {
            this.showAlert('Access denied. Super Admin privileges required.', 'danger');
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 2000);
            return;
        }
    }

    initializeDashboardData() {
        // Initialize super admin data in localStorage if not exists
        if (!localStorage.getItem('superAdminData')) {
            const superAdminData = {
                users: [
                    { id: 1, name: 'John Doe', email: 'john@example.com', role: 'user', active: true, lastActivity: new Date().toISOString() },
                    { id: 2, name: 'Jane Smith', email: 'jane@example.com', role: 'admin', active: true, lastActivity: new Date().toISOString() },
                    { id: 3, name: 'Bob Wilson', email: 'bob@example.com', role: 'user', active: false, lastActivity: new Date(Date.now() - 86400000).toISOString() }
                ],
                roles: [
                    { id: 1, name: 'super_admin', description: 'Full system access', permissions: ['all'] },
                    { id: 2, name: 'admin', description: 'Administrative access', permissions: ['user_management', 'product_management', 'order_management'] },
                    { id: 3, name: 'user', description: 'Basic user access', permissions: ['view_products', 'place_orders'] }
                ],
                activities: [],
                analytics: {
                    productFrequency: {},
                    salesData: {},
                    topProducts: []
                }
            };
            localStorage.setItem('superAdminData', JSON.stringify(superAdminData));
        }

        // Initialize activity tracking
        this.initializeActivityTracking();
        
        // Update dashboard stats
        this.updateDashboardStats();
    }

    initializeActivityTracking() {
        // Create sample activities for demonstration
        const activities = [
            {
                id: 1,
                timestamp: new Date().toISOString(),
                userId: 2,
                userName: 'Jane Smith',
                action: 'User Login',
                details: 'Admin user logged in successfully',
                ipAddress: '192.168.1.100',
                status: 'success'
            },
            {
                id: 2,
                timestamp: new Date(Date.now() - 1800000).toISOString(),
                userId: 1,
                userName: 'John Doe',
                action: 'Product Added',
                details: 'Added new product: Organic Milk',
                ipAddress: '192.168.1.101',
                status: 'success'
            },
            {
                id: 3,
                timestamp: new Date(Date.now() - 3600000).toISOString(),
                userId: 3,
                userName: 'Bob Wilson',
                action: 'Order Placed',
                details: 'Order #12345 placed successfully',
                ipAddress: '192.168.1.102',
                status: 'success'
            }
        ];

        const superAdminData = JSON.parse(localStorage.getItem('superAdminData'));
        if (superAdminData.activities.length === 0) {
            superAdminData.activities = activities;
            localStorage.setItem('superAdminData', JSON.stringify(superAdminData));
        }
    }

    updateDashboardStats() {
        const superAdminData = JSON.parse(localStorage.getItem('superAdminData'));
        const users = superAdminData.users;
        const activities = superAdminData.activities;

        // Update user statistics
        document.getElementById('totalUsers').textContent = users.length;
        document.getElementById('totalAdmins').textContent = users.filter(u => u.role === 'admin').length;
        document.getElementById('activeSessions').textContent = users.filter(u => u.active).length;
        document.getElementById('onlineAdmins').textContent = users.filter(u => u.role === 'admin' && u.active).length;

        // Update activity statistics
        const today = new Date().toDateString();
        const todayActivities = activities.filter(a => new Date(a.timestamp).toDateString() === today);
        document.getElementById('todayActivities').textContent = todayActivities.length;

        const lastHour = new Date(Date.now() - 3600000);
        const lastHourActivities = activities.filter(a => new Date(a.timestamp) > lastHour);
        document.getElementById('lastHourActivities').textContent = lastHourActivities.length;
    }

    setupEventListeners() {
        // Auto-refresh dashboard every 30 seconds
        setInterval(() => {
            this.updateDashboardStats();
            this.loadRecentActivities();
        }, 30000);
    }

    createCharts() {
        this.createUserActivityChart();
        this.createRoleDistributionChart();
    }

    createUserActivityChart() {
        const ctx = document.getElementById('userActivityChart').getContext('2d');
        
        // Generate sample data for the last 7 days
        const labels = [];
        const data = [];
        for (let i = 6; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            labels.push(date.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' }));
            data.push(Math.floor(Math.random() * 50) + 20);
        }

        this.userActivityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'User Activities',
                    data: data,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    }
                }
            }
        });
    }

    createRoleDistributionChart() {
        const ctx = document.getElementById('roleDistributionChart').getContext('2d');
        const superAdminData = JSON.parse(localStorage.getItem('superAdminData'));
        const users = superAdminData.users;

        const roleCounts = {};
        users.forEach(user => {
            roleCounts[user.role] = (roleCounts[user.role] || 0) + 1;
        });

        this.roleDistributionChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(roleCounts),
                datasets: [{
                    data: Object.values(roleCounts),
                    backgroundColor: [
                        '#dc3545',
                        '#ffc107',
                        '#0d6efd',
                        '#198754'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }

    loadRecentActivities() {
        const superAdminData = JSON.parse(localStorage.getItem('superAdminData'));
        const activities = superAdminData.activities.slice(-5).reverse(); // Get last 5 activities
        const tableBody = document.getElementById('recentActivitiesTable');
        
        tableBody.innerHTML = '';
        
        activities.forEach(activity => {
            const row = document.createElement('tr');
            const statusBadge = this.getStatusBadge(activity.status);
            const timeAgo = this.formatTimeAgo(activity.timestamp);
            
            row.innerHTML = `
                <td>${timeAgo}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                            ${activity.userName.split(' ').map(n => n[0]).join('')}
                        </div>
                        <div>
                            <div class="fw-medium">${activity.userName}</div>
                            <div class="small text-muted">${activity.ipAddress}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <strong>${activity.action}</strong>
                </td>
                <td>${activity.details}</td>
                <td>${statusBadge}</td>
            `;
            
            tableBody.appendChild(row);
        });
    }

    getStatusBadge(status) {
        const badges = {
            success: '<span class="badge bg-success">Success</span>',
            warning: '<span class="badge bg-warning text-dark">Warning</span>',
            error: '<span class="badge bg-danger">Error</span>'
        };
        return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
    }

    formatTimeAgo(timestamp) {
        const now = new Date();
        const time = new Date(timestamp);
        const diffInSeconds = Math.floor((now - time) / 1000);
        
        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m ago`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h ago`;
        return time.toLocaleDateString();
    }

    showAlert(message, type = 'info') {
        const alertContainer = document.getElementById('alertContainer');
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show`;
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        alertContainer.appendChild(alert);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
}

// Export system report function
function exportSystemReport() {
    const superAdminData = JSON.parse(localStorage.getItem('superAdminData'));
    const report = {
        generatedAt: new Date().toISOString(),
        totalUsers: superAdminData.users.length,
        activeUsers: superAdminData.users.filter(u => u.active).length,
        totalActivities: superAdminData.activities.length,
        recentActivities: superAdminData.activities.slice(-10)
    };
    
    const blob = new Blob([JSON.stringify(report, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `system-report-${new Date().toISOString().split('T')[0]}.json`;
    a.click();
    URL.revokeObjectURL(url);
}

// Initialize dashboard
function initializeSuperAdminDashboard() {
    const dashboard = new SuperAdminDashboard();
    dashboard.init();
}

// Global reference for debugging
window.superAdminDashboard = new SuperAdminDashboard();
