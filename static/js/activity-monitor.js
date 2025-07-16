// Activity Monitor JavaScript
class ActivityMonitor {
    constructor() {
        this.activities = [];
        this.currentPage = 1;
        this.itemsPerPage = 10;
        this.isRealTime = false;
        this.realTimeInterval = null;
        this.filters = {
            dateRange: 'today',
            activityType: 'all',
            userRole: 'all',
            status: 'all',
            search: ''
        };
        this.isInitialized = false;
    }

    init() {
        if (this.isInitialized) return;
        
        this.loadActivities();
        this.setupEventListeners();
        this.updateStatistics();
        this.renderActivityTable();
        this.isInitialized = true;
    }

    loadActivities() {
        // Generate comprehensive sample activity data
        const sampleActivities = [
            {
                id: 1,
                timestamp: new Date().toISOString(),
                userId: 1,
                userName: 'John Doe',
                userRole: 'user',
                action: 'Product View',
                details: 'Viewed product: Organic Whole Milk',
                ipAddress: '192.168.1.100',
                userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                sessionId: 'sess_123456',
                requestId: 'req_789012',
                status: 'success',
                type: 'product'
            },
            {
                id: 2,
                timestamp: new Date(Date.now() - 300000).toISOString(),
                userId: 2,
                userName: 'Jane Smith',
                userRole: 'admin',
                action: 'User Login',
                details: 'Admin user logged in successfully',
                ipAddress: '192.168.1.101',
                userAgent: 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                sessionId: 'sess_234567',
                requestId: 'req_890123',
                status: 'success',
                type: 'login'
            },
            {
                id: 3,
                timestamp: new Date(Date.now() - 600000).toISOString(),
                userId: 3,
                userName: 'Bob Wilson',
                userRole: 'user',
                action: 'Order Placed',
                details: 'Order #12345 placed successfully for ₱125.50',
                ipAddress: '192.168.1.102',
                userAgent: 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15',
                sessionId: 'sess_345678',
                requestId: 'req_901234',
                status: 'success',
                type: 'order'
            },
            {
                id: 4,
                timestamp: new Date(Date.now() - 900000).toISOString(),
                userId: 4,
                userName: 'Alice Johnson',
                userRole: 'admin',
                action: 'Product Added',
                details: 'Added new product: Greek Yogurt Variety Pack',
                ipAddress: '192.168.1.103',
                userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                sessionId: 'sess_456789',
                requestId: 'req_012345',
                status: 'success',
                type: 'product'
            },
            {
                id: 5,
                timestamp: new Date(Date.now() - 1200000).toISOString(),
                userId: 5,
                userName: 'Charlie Brown',
                userRole: 'user',
                action: 'Login Failed',
                details: 'Failed login attempt - incorrect password',
                ipAddress: '192.168.1.104',
                userAgent: 'Mozilla/5.0 (Android 11; Mobile; rv:68.0) Gecko/68.0 Firefox/88.0',
                sessionId: 'sess_567890',
                requestId: 'req_123456',
                status: 'error',
                type: 'login'
            },
            {
                id: 6,
                timestamp: new Date(Date.now() - 1800000).toISOString(),
                userId: 2,
                userName: 'Jane Smith',
                userRole: 'admin',
                action: 'User Role Updated',
                details: 'Changed user role for John Doe from user to admin',
                ipAddress: '192.168.1.101',
                userAgent: 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                sessionId: 'sess_234567',
                requestId: 'req_234567',
                status: 'success',
                type: 'user'
            },
            {
                id: 7,
                timestamp: new Date(Date.now() - 2400000).toISOString(),
                userId: 6,
                userName: 'David Lee',
                userRole: 'user',
                action: 'Password Reset',
                details: 'Password reset requested and completed',
                ipAddress: '192.168.1.105',
                userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                sessionId: 'sess_678901',
                requestId: 'req_345678',
                status: 'warning',
                type: 'user'
            },
            {
                id: 8,
                timestamp: new Date(Date.now() - 3600000).toISOString(),
                userId: 1,
                userName: 'John Doe',
                userRole: 'user',
                action: 'Profile Updated',
                details: 'Updated profile information and preferences',
                ipAddress: '192.168.1.100',
                userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                sessionId: 'sess_123456',
                requestId: 'req_456789',
                status: 'success',
                type: 'user'
            },
            {
                id: 9,
                timestamp: new Date(Date.now() - 4200000).toISOString(),
                userId: 4,
                userName: 'Alice Johnson',
                userRole: 'admin',
                action: 'System Backup',
                details: 'Initiated system backup process',
                ipAddress: '192.168.1.103',
                userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                sessionId: 'sess_456789',
                requestId: 'req_567890',
                status: 'success',
                type: 'system'
            },
            {
                id: 10,
                timestamp: new Date(Date.now() - 5400000).toISOString(),
                userId: 7,
                userName: 'Eva Martinez',
                userRole: 'user',
                action: 'Account Registration',
                details: 'New user account created successfully',
                ipAddress: '192.168.1.106',
                userAgent: 'Mozilla/5.0 (iPad; CPU OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15',
                sessionId: 'sess_789012',
                requestId: 'req_678901',
                status: 'success',
                type: 'user'
            }
        ];

        this.activities = sampleActivities;
        localStorage.setItem('activityLog', JSON.stringify(this.activities));
    }

    setupEventListeners() {
        // Filter event listeners
        document.getElementById('dateRange').addEventListener('change', (e) => {
            this.filters.dateRange = e.target.value;
        });

        document.getElementById('activityType').addEventListener('change', (e) => {
            this.filters.activityType = e.target.value;
        });

        document.getElementById('userRole').addEventListener('change', (e) => {
            this.filters.userRole = e.target.value;
        });

        document.getElementById('activityStatus').addEventListener('change', (e) => {
            this.filters.status = e.target.value;
        });

        document.getElementById('searchActivity').addEventListener('input', (e) => {
            this.filters.search = e.target.value;
        });

        // Auto-refresh toggle
        document.getElementById('autoRefresh').addEventListener('change', (e) => {
            if (e.target.checked) {
                this.startAutoRefresh();
            } else {
                this.stopAutoRefresh();
            }
        });
    }

    applyFilters() {
        this.currentPage = 1;
        this.renderActivityTable();
        this.updateStatistics();
    }

    clearFilters() {
        this.filters = {
            dateRange: 'today',
            activityType: 'all',
            userRole: 'all',
            status: 'all',
            search: ''
        };

        // Reset form controls
        document.getElementById('dateRange').value = 'today';
        document.getElementById('activityType').value = 'all';
        document.getElementById('userRole').value = 'all';
        document.getElementById('activityStatus').value = 'all';
        document.getElementById('searchActivity').value = '';

        this.applyFilters();
    }

    getFilteredActivities() {
        let filtered = [...this.activities];

        // Date range filter
        if (this.filters.dateRange !== 'all') {
            const now = new Date();
            let cutoffDate;
            
            switch(this.filters.dateRange) {
                case 'today':
                    cutoffDate = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                    break;
                case 'week':
                    cutoffDate = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
                    break;
                case 'month':
                    cutoffDate = new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000);
                    break;
            }
            
            if (cutoffDate) {
                filtered = filtered.filter(activity => new Date(activity.timestamp) >= cutoffDate);
            }
        }

        // Activity type filter
        if (this.filters.activityType !== 'all') {
            filtered = filtered.filter(activity => activity.type === this.filters.activityType);
        }

        // User role filter
        if (this.filters.userRole !== 'all') {
            filtered = filtered.filter(activity => activity.userRole === this.filters.userRole);
        }

        // Status filter
        if (this.filters.status !== 'all') {
            filtered = filtered.filter(activity => activity.status === this.filters.status);
        }

        // Search filter
        if (this.filters.search) {
            const searchLower = this.filters.search.toLowerCase();
            filtered = filtered.filter(activity => 
                activity.userName.toLowerCase().includes(searchLower) ||
                activity.action.toLowerCase().includes(searchLower) ||
                activity.details.toLowerCase().includes(searchLower)
            );
        }

        return filtered;
    }

    renderActivityTable() {
        const filtered = this.getFilteredActivities();
        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        const paginatedActivities = filtered.slice(startIndex, endIndex);

        const tableBody = document.getElementById('activityTable');
        tableBody.innerHTML = '';

        paginatedActivities.forEach(activity => {
            const row = document.createElement('tr');
            const statusBadge = this.getStatusBadge(activity.status);
            const timeFormatted = this.formatTimestamp(activity.timestamp);

            row.innerHTML = `
                <td>${timeFormatted}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                            ${activity.userName.split(' ').map(n => n[0]).join('')}
                        </div>
                        <div>
                            <div class="fw-medium">${activity.userName}</div>
                            <div class="small text-muted">${activity.userRole}</div>
                        </div>
                    </div>
                </td>
                <td><strong>${activity.action}</strong></td>
                <td>${activity.details}</td>
                <td><code>${activity.ipAddress}</code></td>
                <td>${statusBadge}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="viewActivityDetails(${activity.id})">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Update pagination
        this.updatePagination(filtered.length);
    }

    updatePagination(totalItems) {
        const totalPages = Math.ceil(totalItems / this.itemsPerPage);
        document.getElementById('currentPage').textContent = this.currentPage;
        
        // Update pagination buttons (simplified)
        const prevBtn = document.querySelector('a[onclick="previousPage()"]');
        const nextBtn = document.querySelector('a[onclick="nextPage()"]');
        
        if (prevBtn) {
            prevBtn.parentElement.classList.toggle('disabled', this.currentPage === 1);
        }
        
        if (nextBtn) {
            nextBtn.parentElement.classList.toggle('disabled', this.currentPage === totalPages);
        }
    }

    updateStatistics() {
        const filtered = this.getFilteredActivities();
        
        document.getElementById('totalActivities').textContent = filtered.length;
        document.getElementById('successfulActivities').textContent = filtered.filter(a => a.status === 'success').length;
        document.getElementById('warningActivities').textContent = filtered.filter(a => a.status === 'warning').length;
        document.getElementById('errorActivities').textContent = filtered.filter(a => a.status === 'error').length;
    }

    getStatusBadge(status) {
        const badges = {
            success: '<span class="badge bg-success">Success</span>',
            warning: '<span class="badge bg-warning text-dark">Warning</span>',
            error: '<span class="badge bg-danger">Error</span>'
        };
        return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
    }

    formatTimestamp(timestamp) {
        const date = new Date(timestamp);
        return date.toLocaleString('en-US', {
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    toggleRealTimeMode() {
        this.isRealTime = !this.isRealTime;
        const toggleBtn = document.getElementById('realTimeToggle');
        
        if (this.isRealTime) {
            toggleBtn.innerHTML = '<i class="fas fa-pause me-1"></i> Stop Real-time';
            this.startRealTimeMonitoring();
        } else {
            toggleBtn.innerHTML = '<i class="fas fa-play me-1"></i> Start Real-time';
            this.stopRealTimeMonitoring();
        }
    }

    startRealTimeMonitoring() {
        this.realTimeInterval = setInterval(() => {
            this.simulateNewActivity();
            this.renderActivityTable();
            this.updateStatistics();
        }, 5000); // Update every 5 seconds
    }

    stopRealTimeMonitoring() {
        if (this.realTimeInterval) {
            clearInterval(this.realTimeInterval);
            this.realTimeInterval = null;
        }
    }

    startAutoRefresh() {
        setInterval(() => {
            this.renderActivityTable();
            this.updateStatistics();
        }, 30000); // Refresh every 30 seconds
    }

    stopAutoRefresh() {
        // Implementation depends on how you want to handle this
    }

    simulateNewActivity() {
        const users = ['John Doe', 'Jane Smith', 'Bob Wilson', 'Alice Johnson'];
        const actions = ['Product View', 'Order Placed', 'Profile Updated', 'Search Query'];
        const statuses = ['success', 'success', 'success', 'warning']; // Weighted towards success

        const newActivity = {
            id: this.activities.length + 1,
            timestamp: new Date().toISOString(),
            userId: Math.floor(Math.random() * 10) + 1,
            userName: users[Math.floor(Math.random() * users.length)],
            userRole: Math.random() > 0.7 ? 'admin' : 'user',
            action: actions[Math.floor(Math.random() * actions.length)],
            details: 'Real-time activity simulation',
            ipAddress: `192.168.1.${Math.floor(Math.random() * 255)}`,
            userAgent: 'Mozilla/5.0 (Simulated)',
            sessionId: `sess_${Math.random().toString(36).substr(2, 9)}`,
            requestId: `req_${Math.random().toString(36).substr(2, 9)}`,
            status: statuses[Math.floor(Math.random() * statuses.length)],
            type: 'product'
        };

        this.activities.unshift(newActivity);
        localStorage.setItem('activityLog', JSON.stringify(this.activities));
    }

    viewActivityDetails(activityId) {
        const activity = this.activities.find(a => a.id === activityId);
        if (!activity) return;

        // Populate modal with activity details
        document.getElementById('detailTimestamp').textContent = new Date(activity.timestamp).toLocaleString();
        document.getElementById('detailUser').textContent = `${activity.userName} (${activity.userRole})`;
        document.getElementById('detailAction').textContent = activity.action;
        document.getElementById('detailStatus').innerHTML = this.getStatusBadge(activity.status);
        document.getElementById('detailIP').textContent = activity.ipAddress;
        document.getElementById('detailUserAgent').textContent = activity.userAgent;
        document.getElementById('detailSessionId').textContent = activity.sessionId;
        document.getElementById('detailRequestId').textContent = activity.requestId;
        document.getElementById('detailData').textContent = JSON.stringify({
            details: activity.details,
            userId: activity.userId,
            type: activity.type
        }, null, 2);

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('activityDetailsModal'));
        modal.show();
    }

    refreshActivities() {
        this.renderActivityTable();
        this.updateStatistics();
        this.showAlert('Activities refreshed successfully', 'success');
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
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 3000);
    }

    nextPage() {
        const filtered = this.getFilteredActivities();
        const totalPages = Math.ceil(filtered.length / this.itemsPerPage);
        if (this.currentPage < totalPages) {
            this.currentPage++;
            this.renderActivityTable();
        }
    }

    previousPage() {
        if (this.currentPage > 1) {
            this.currentPage--;
            this.renderActivityTable();
        }
    }
}

// Global functions for UI interactions
function applyFilters() {
    window.activityMonitor.applyFilters();
}

function clearFilters() {
    window.activityMonitor.clearFilters();
}

function toggleRealTimeMode() {
    window.activityMonitor.toggleRealTimeMode();
}

function refreshActivities() {
    window.activityMonitor.refreshActivities();
}

function viewActivityDetails(activityId) {
    window.activityMonitor.viewActivityDetails(activityId);
}

function nextPage() {
    window.activityMonitor.nextPage();
}

function previousPage() {
    window.activityMonitor.previousPage();
}

function exportActivityReport() {
    const activities = window.activityMonitor.getFilteredActivities();
    const report = {
        generatedAt: new Date().toISOString(),
        filters: window.activityMonitor.filters,
        totalActivities: activities.length,
        activities: activities
    };
    
    const blob = new Blob([JSON.stringify(report, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `activity-report-${new Date().toISOString().split('T')[0]}.json`;
    a.click();
    URL.revokeObjectURL(url);
}

// Initialize activity monitor
function initializeActivityMonitor() {
    window.activityMonitor = new ActivityMonitor();
    window.activityMonitor.init();
}
