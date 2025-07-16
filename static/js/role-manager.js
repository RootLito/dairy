// Role Manager JavaScript
class RoleManager {
    constructor() {
        this.roles = [];
        this.users = [];
        this.permissions = [];
        this.roleChanges = [];
        this.currentEditingUser = null;
        this.isInitialized = false;
    }

    init() {
        if (this.isInitialized) return;
        
        this.checkSuperAdminAuth();
        this.initializeRoleData();
        this.setupEventListeners();
        this.loadRoleStatistics();
        this.loadUserRoleTable();
        this.loadRoleDefinitions();
        this.populatePermissionsList();
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

    initializeRoleData() {
        // Initialize or load existing role data
        let superAdminData = JSON.parse(localStorage.getItem('superAdminData') || '{}');
        
        if (!superAdminData.roles || !superAdminData.users) {
            superAdminData = {
                users: [
                    { 
                        id: 1, 
                        name: 'John Doe', 
                        email: 'john@example.com', 
                        role: 'user', 
                        permissions: ['view_products', 'place_orders'], 
                        active: true, 
                        lastActivity: new Date().toISOString(),
                        createdAt: new Date(Date.now() - 86400000 * 30).toISOString()
                    },
                    { 
                        id: 2, 
                        name: 'Jane Smith', 
                        email: 'jane@example.com', 
                        role: 'admin', 
                        permissions: ['user_management', 'product_management', 'order_management', 'view_reports'], 
                        active: true, 
                        lastActivity: new Date().toISOString(),
                        createdAt: new Date(Date.now() - 86400000 * 60).toISOString()
                    },
                    { 
                        id: 3, 
                        name: 'Bob Wilson', 
                        email: 'bob@example.com', 
                        role: 'user', 
                        permissions: ['view_products', 'place_orders'], 
                        active: false, 
                        lastActivity: new Date(Date.now() - 86400000).toISOString(),
                        createdAt: new Date(Date.now() - 86400000 * 45).toISOString()
                    },
                    { 
                        id: 4, 
                        name: 'Alice Johnson', 
                        email: 'alice@example.com', 
                        role: 'moderator', 
                        permissions: ['product_management', 'order_management'], 
                        active: true, 
                        lastActivity: new Date(Date.now() - 3600000).toISOString(),
                        createdAt: new Date(Date.now() - 86400000 * 15).toISOString()
                    },
                    { 
                        id: 5, 
                        name: 'Charlie Brown', 
                        email: 'charlie@example.com', 
                        role: 'user', 
                        permissions: ['view_products', 'place_orders'], 
                        active: true, 
                        lastActivity: new Date(Date.now() - 7200000).toISOString(),
                        createdAt: new Date(Date.now() - 86400000 * 10).toISOString()
                    }
                ],
                roles: [
                    { 
                        id: 1, 
                        name: 'super_admin', 
                        displayName: 'Super Admin',
                        description: 'Full system access and control', 
                        permissions: ['all'],
                        color: '#dc3545',
                        userCount: 1,
                        createdAt: new Date(Date.now() - 86400000 * 365).toISOString()
                    },
                    { 
                        id: 2, 
                        name: 'admin', 
                        displayName: 'Administrator',
                        description: 'Administrative access to manage users and products', 
                        permissions: ['user_management', 'product_management', 'order_management', 'view_reports'],
                        color: '#ffc107',
                        userCount: 1,
                        createdAt: new Date(Date.now() - 86400000 * 180).toISOString()
                    },
                    { 
                        id: 3, 
                        name: 'moderator', 
                        displayName: 'Moderator',
                        description: 'Content moderation and basic management', 
                        permissions: ['product_management', 'order_management'],
                        color: '#17a2b8',
                        userCount: 1,
                        createdAt: new Date(Date.now() - 86400000 * 90).toISOString()
                    },
                    { 
                        id: 4, 
                        name: 'user', 
                        displayName: 'User',
                        description: 'Basic user access for customers', 
                        permissions: ['view_products', 'place_orders'],
                        color: '#28a745',
                        userCount: 3,
                        createdAt: new Date(Date.now() - 86400000 * 365).toISOString()
                    }
                ],
                permissions: [
                    { id: 1, name: 'user_management', displayName: 'User Management', description: 'Create, edit, and delete users' },
                    { id: 2, name: 'product_management', displayName: 'Product Management', description: 'Add, edit, and remove products' },
                    { id: 3, name: 'order_management', displayName: 'Order Management', description: 'View and manage customer orders' },
                    { id: 4, name: 'view_reports', displayName: 'View Reports', description: 'Access to analytics and reports' },
                    { id: 5, name: 'view_products', displayName: 'View Products', description: 'Browse product catalog' },
                    { id: 6, name: 'place_orders', displayName: 'Place Orders', description: 'Purchase products and place orders' },
                    { id: 7, name: 'system_settings', displayName: 'System Settings', description: 'Configure system settings' },
                    { id: 8, name: 'financial_reports', displayName: 'Financial Reports', description: 'Access financial data and reports' }
                ],
                roleChanges: [
                    {
                        id: 1,
                        userId: 4,
                        userName: 'Alice Johnson',
                        oldRole: 'user',
                        newRole: 'moderator',
                        changedBy: 'Super Admin',
                        reason: 'Promoted to moderator for content management',
                        timestamp: new Date(Date.now() - 86400000 * 2).toISOString()
                    }
                ]
            };
            localStorage.setItem('superAdminData', JSON.stringify(superAdminData));
        }

        this.roles = superAdminData.roles;
        this.users = superAdminData.users;
        this.permissions = superAdminData.permissions;
        this.roleChanges = superAdminData.roleChanges || [];
    }

    setupEventListeners() {
        // Search functionality
        document.getElementById('userSearch').addEventListener('input', (e) => {
            this.filterUsers(e.target.value);
        });

        // Auto-refresh every 30 seconds
        setInterval(() => {
            this.loadRoleStatistics();
            this.loadUserRoleTable();
        }, 30000);
    }

    loadRoleStatistics() {
        const superAdminData = JSON.parse(localStorage.getItem('superAdminData'));
        const users = superAdminData.users;
        const roles = superAdminData.roles;
        const roleChanges = superAdminData.roleChanges || [];

        // Update statistics
        document.getElementById('totalRoles').textContent = roles.length;
        document.getElementById('activeUsers').textContent = users.filter(u => u.active).length;
        document.getElementById('pendingApprovals').textContent = Math.floor(Math.random() * 3); // Simulated pending approvals
        
        // Role changes today
        const today = new Date().toDateString();
        const todayChanges = roleChanges.filter(change => 
            new Date(change.timestamp).toDateString() === today
        );
        document.getElementById('roleChanges').textContent = todayChanges.length;
    }

    loadUserRoleTable() {
        const tableBody = document.getElementById('userRoleTable');
        tableBody.innerHTML = '';

        this.users.forEach(user => {
            const role = this.roles.find(r => r.name === user.role);
            const lastActivity = this.formatTimeAgo(user.lastActivity);
            const statusIcon = user.active ? 'text-success' : 'text-danger';
            const statusText = user.active ? 'Active' : 'Inactive';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle me-2" style="width: 35px; height: 35px; background-color: ${role?.color || '#6c757d'};">
                            ${user.name.split(' ').map(n => n[0]).join('')}
                        </div>
                        <div>
                            <div class="fw-medium">${user.name}</div>
                            <div class="small text-muted">ID: ${user.id}</div>
                        </div>
                    </div>
                </td>
                <td>${user.email}</td>
                <td>
                    <span class="badge" style="background-color: ${role?.color || '#6c757d'};">
                        ${role?.displayName || user.role}
                    </span>
                </td>
                <td>
                    <div class="small">
                        ${user.permissions.map(p => {
                            const perm = this.permissions.find(perm => perm.name === p);
                            return `<span class="badge bg-secondary me-1">${perm?.displayName || p}</span>`;
                        }).join('')}
                    </div>
                </td>
                <td>${lastActivity}</td>
                <td>
                    <i class="fas fa-circle ${statusIcon} me-1"></i>
                    ${statusText}
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" onclick="editUserRole(${user.id})" title="Edit Role">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-info" onclick="viewUserDetails(${user.id})" title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-${user.active ? 'warning' : 'success'}" onclick="toggleUserStatus(${user.id})" title="${user.active ? 'Deactivate' : 'Activate'}">
                            <i class="fas fa-${user.active ? 'ban' : 'check'}"></i>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    loadRoleDefinitions() {
        const container = document.getElementById('roleDefinitions');
        container.innerHTML = '';

        this.roles.forEach(role => {
            const permissionsList = role.permissions.includes('all') ? 
                '<span class="badge bg-danger">All Permissions</span>' :
                role.permissions.map(p => {
                    const perm = this.permissions.find(perm => perm.name === p);
                    return `<span class="badge bg-secondary me-1 mb-1">${perm?.displayName || p}</span>`;
                }).join('');

            const card = document.createElement('div');
            card.className = 'col-md-6 col-lg-4';
            card.innerHTML = `
                <div class="card h-100 border-2" style="border-color: ${role.color} !important;">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background-color: ${role.color}20;">
                        <h6 class="mb-0" style="color: ${role.color};">
                            <i class="fas fa-users me-2"></i>${role.displayName}
                        </h6>
                        <span class="badge bg-primary">${role.userCount} users</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-3">${role.description}</p>
                        <div class="mb-3">
                            <strong>Permissions:</strong>
                            <div class="mt-2">${permissionsList}</div>
                        </div>
                        <div class="small text-muted">
                            Created: ${new Date(role.createdAt).toLocaleDateString()}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group btn-group-sm w-100">
                            <button class="btn btn-outline-primary" onclick="editRole('${role.name}')">
                                <i class="fas fa-edit me-1"></i>Edit
                            </button>
                            <button class="btn btn-outline-info" onclick="viewRoleUsers('${role.name}')">
                                <i class="fas fa-users me-1"></i>Users
                            </button>
                            ${role.name !== 'super_admin' ? `
                                <button class="btn btn-outline-danger" onclick="deleteRole('${role.name}')">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });
    }

    populatePermissionsList() {
        const container = document.getElementById('permissionsList');
        container.innerHTML = '';

        this.permissions.forEach(permission => {
            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="perm_${permission.name}" value="${permission.name}">
                    <label class="form-check-label" for="perm_${permission.name}">
                        <strong>${permission.displayName}</strong>
                        <div class="small text-muted">${permission.description}</div>
                    </label>
                </div>
            `;
            container.appendChild(col);
        });
    }

    filterUsers(searchTerm) {
        const filteredUsers = this.users.filter(user => 
            user.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
            user.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
            user.role.toLowerCase().includes(searchTerm.toLowerCase())
        );

        const tableBody = document.getElementById('userRoleTable');
        tableBody.innerHTML = '';

        filteredUsers.forEach(user => {
            const role = this.roles.find(r => r.name === user.role);
            const lastActivity = this.formatTimeAgo(user.lastActivity);
            const statusIcon = user.active ? 'text-success' : 'text-danger';
            const statusText = user.active ? 'Active' : 'Inactive';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle me-2" style="width: 35px; height: 35px; background-color: ${role?.color || '#6c757d'};">
                            ${user.name.split(' ').map(n => n[0]).join('')}
                        </div>
                        <div>
                            <div class="fw-medium">${user.name}</div>
                            <div class="small text-muted">ID: ${user.id}</div>
                        </div>
                    </div>
                </td>
                <td>${user.email}</td>
                <td>
                    <span class="badge" style="background-color: ${role?.color || '#6c757d'};">
                        ${role?.displayName || user.role}
                    </span>
                </td>
                <td>
                    <div class="small">
                        ${user.permissions.map(p => {
                            const perm = this.permissions.find(perm => perm.name === p);
                            return `<span class="badge bg-secondary me-1">${perm?.displayName || p}</span>`;
                        }).join('')}
                    </div>
                </td>
                <td>${lastActivity}</td>
                <td>
                    <i class="fas fa-circle ${statusIcon} me-1"></i>
                    ${statusText}
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary" onclick="editUserRole(${user.id})" title="Edit Role">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-outline-info" onclick="viewUserDetails(${user.id})" title="View Details">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-outline-${user.active ? 'warning' : 'success'}" onclick="toggleUserStatus(${user.id})" title="${user.active ? 'Deactivate' : 'Activate'}">
                            <i class="fas fa-${user.active ? 'ban' : 'check'}"></i>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    createRole() {
        const form = document.getElementById('createRoleForm');
        const formData = new FormData(form);
        
        const roleName = document.getElementById('roleName').value.trim();
        const roleDescription = document.getElementById('roleDescription').value.trim();
        
        if (!roleName) {
            this.showAlert('Role name is required', 'danger');
            return;
        }

        // Check if role already exists
        if (this.roles.find(r => r.name === roleName.toLowerCase().replace(/\s+/g, '_'))) {
            this.showAlert('Role with this name already exists', 'danger');
            return;
        }

        // Get selected permissions
        const selectedPermissions = [];
        document.querySelectorAll('#permissionsList input[type="checkbox"]:checked').forEach(checkbox => {
            selectedPermissions.push(checkbox.value);
        });

        if (selectedPermissions.length === 0) {
            this.showAlert('At least one permission must be selected', 'danger');
            return;
        }

        const newRole = {
            id: this.roles.length + 1,
            name: roleName.toLowerCase().replace(/\s+/g, '_'),
            displayName: roleName,
            description: roleDescription || `Custom role: ${roleName}`,
            permissions: selectedPermissions,
            color: this.generateRandomColor(),
            userCount: 0,
            createdAt: new Date().toISOString()
        };

        this.roles.push(newRole);
        this.saveRoleData();
        this.loadRoleDefinitions();
        this.populateRoleDropdown();
        
        // Close modal and reset form
        const modal = bootstrap.Modal.getInstance(document.getElementById('createRoleModal'));
        modal.hide();
        form.reset();
        document.querySelectorAll('#permissionsList input[type="checkbox"]').forEach(cb => cb.checked = false);
        
        this.showAlert(`Role "${roleName}" created successfully`, 'success');
    }

    editUserRole(userId) {
        const user = this.users.find(u => u.id === userId);
        if (!user) return;

        this.currentEditingUser = user;
        
        // Populate modal
        document.getElementById('editUserName').textContent = `${user.name} (${user.email})`;
        
        // Populate role dropdown
        const roleSelect = document.getElementById('newRole');
        roleSelect.innerHTML = '';
        
        this.roles.forEach(role => {
            const option = document.createElement('option');
            option.value = role.name;
            option.textContent = role.displayName;
            option.selected = role.name === user.role;
            roleSelect.appendChild(option);
        });

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('editUserRoleModal'));
        modal.show();
    }

    updateUserRole() {
        if (!this.currentEditingUser) return;

        const newRole = document.getElementById('newRole').value;
        const reason = document.getElementById('roleReason').value.trim();
        
        if (!newRole) {
            this.showAlert('Please select a role', 'danger');
            return;
        }

        const oldRole = this.currentEditingUser.role;
        const role = this.roles.find(r => r.name === newRole);
        
        if (!role) {
            this.showAlert('Invalid role selected', 'danger');
            return;
        }

        // Update user role and permissions
        this.currentEditingUser.role = newRole;
        this.currentEditingUser.permissions = [...role.permissions];

        // Log the role change
        const roleChange = {
            id: this.roleChanges.length + 1,
            userId: this.currentEditingUser.id,
            userName: this.currentEditingUser.name,
            oldRole: oldRole,
            newRole: newRole,
            changedBy: 'Super Admin',
            reason: reason || 'No reason provided',
            timestamp: new Date().toISOString()
        };
        
        this.roleChanges.push(roleChange);

        // Update role user counts
        const oldRoleObj = this.roles.find(r => r.name === oldRole);
        const newRoleObj = this.roles.find(r => r.name === newRole);
        
        if (oldRoleObj) oldRoleObj.userCount = Math.max(0, oldRoleObj.userCount - 1);
        if (newRoleObj) newRoleObj.userCount = newRoleObj.userCount + 1;

        this.saveRoleData();
        this.loadUserRoleTable();
        this.loadRoleDefinitions();
        this.loadRoleStatistics();
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('editUserRoleModal'));
        modal.hide();
        document.getElementById('roleReason').value = '';
        
        this.currentEditingUser = null;
        this.showAlert(`User role updated successfully from ${oldRole} to ${newRole}`, 'success');
    }

    toggleUserStatus(userId) {
        const user = this.users.find(u => u.id === userId);
        if (!user) return;

        user.active = !user.active;
        this.saveRoleData();
        this.loadUserRoleTable();
        this.loadRoleStatistics();
        
        const status = user.active ? 'activated' : 'deactivated';
        this.showAlert(`User ${user.name} has been ${status}`, 'success');
    }

    viewUserDetails(userId) {
        const user = this.users.find(u => u.id === userId);
        if (!user) return;

        const role = this.roles.find(r => r.name === user.role);
        const userChanges = this.roleChanges.filter(change => change.userId === userId);
        
        let changeHistory = '';
        if (userChanges.length > 0) {
            changeHistory = userChanges.map(change => 
                `<li class="list-group-item">
                    <strong>${new Date(change.timestamp).toLocaleDateString()}</strong>: 
                    ${change.oldRole} → ${change.newRole}
                    <div class="small text-muted">${change.reason}</div>
                </li>`
            ).join('');
        } else {
            changeHistory = '<li class="list-group-item">No role changes recorded</li>';
        }

        const alertHtml = `
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <h5 class="alert-heading">User Details: ${user.name}</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Email:</strong> ${user.email}<br>
                        <strong>Current Role:</strong> <span class="badge" style="background-color: ${role?.color}">${role?.displayName || user.role}</span><br>
                        <strong>Status:</strong> <span class="badge bg-${user.active ? 'success' : 'danger'}">${user.active ? 'Active' : 'Inactive'}</span><br>
                        <strong>Last Activity:</strong> ${new Date(user.lastActivity).toLocaleString()}<br>
                        <strong>Created:</strong> ${new Date(user.createdAt).toLocaleDateString()}
                    </div>
                    <div class="col-md-6">
                        <strong>Permissions:</strong><br>
                        ${user.permissions.map(p => {
                            const perm = this.permissions.find(perm => perm.name === p);
                            return `<span class="badge bg-secondary me-1">${perm?.displayName || p}</span>`;
                        }).join('')}
                    </div>
                </div>
                <hr>
                <strong>Role Change History:</strong>
                <ul class="list-group mt-2">
                    ${changeHistory}
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

        const alertContainer = document.getElementById('alertContainer');
        alertContainer.innerHTML = alertHtml;
    }

    saveRoleData() {
        const superAdminData = JSON.parse(localStorage.getItem('superAdminData'));
        superAdminData.roles = this.roles;
        superAdminData.users = this.users;
        superAdminData.permissions = this.permissions;
        superAdminData.roleChanges = this.roleChanges;
        localStorage.setItem('superAdminData', JSON.stringify(superAdminData));
    }

    generateRandomColor() {
        const colors = ['#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#dc3545', '#fd7e14', '#ffc107', '#198754', '#20c997', '#0dcaf0'];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    formatTimeAgo(timestamp) {
        const now = new Date();
        const time = new Date(timestamp);
        const diffInSeconds = Math.floor((now - time) / 1000);
        
        if (diffInSeconds < 60) return 'Just now';
        if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m ago`;
        if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h ago`;
        if (diffInSeconds < 2592000) return `${Math.floor(diffInSeconds / 86400)}d ago`;
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
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }
}

// Global functions for UI interactions
function createRole() {
    window.roleManager.createRole();
}

function editUserRole(userId) {
    window.roleManager.editUserRole(userId);
}

function updateUserRole() {
    window.roleManager.updateUserRole();
}

function toggleUserStatus(userId) {
    window.roleManager.toggleUserStatus(userId);
}

function viewUserDetails(userId) {
    window.roleManager.viewUserDetails(userId);
}

function editRole(roleName) {
    window.roleManager.showAlert(`Edit role functionality for "${roleName}" - Feature coming soon!`, 'info');
}

function viewRoleUsers(roleName) {
    const role = window.roleManager.roles.find(r => r.name === roleName);
    const users = window.roleManager.users.filter(u => u.role === roleName);
    
    if (users.length === 0) {
        window.roleManager.showAlert(`No users found with role "${role?.displayName || roleName}"`, 'info');
        return;
    }

    const userList = users.map(user => 
        `<li class="list-group-item d-flex justify-content-between align-items-center">
            ${user.name} (${user.email})
            <span class="badge bg-${user.active ? 'success' : 'danger'}">${user.active ? 'Active' : 'Inactive'}</span>
        </li>`
    ).join('');

    const alertHtml = `
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <h5 class="alert-heading">Users with role: ${role?.displayName || roleName}</h5>
            <hr>
            <ul class="list-group">
                ${userList}
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    const alertContainer = document.getElementById('alertContainer');
    alertContainer.innerHTML = alertHtml;
}

function deleteRole(roleName) {
    if (roleName === 'super_admin') {
        window.roleManager.showAlert('Cannot delete Super Admin role', 'danger');
        return;
    }

    const role = window.roleManager.roles.find(r => r.name === roleName);
    const usersWithRole = window.roleManager.users.filter(u => u.role === roleName);
    
    if (usersWithRole.length > 0) {
        window.roleManager.showAlert(`Cannot delete role "${role?.displayName || roleName}" - ${usersWithRole.length} user(s) still have this role`, 'danger');
        return;
    }

    if (confirm(`Are you sure you want to delete the role "${role?.displayName || roleName}"?`)) {
        window.roleManager.roles = window.roleManager.roles.filter(r => r.name !== roleName);
        window.roleManager.saveRoleData();
        window.roleManager.loadRoleDefinitions();
        window.roleManager.loadRoleStatistics();
        window.roleManager.showAlert(`Role "${role?.displayName || roleName}" deleted successfully`, 'success');
    }
}

function exportRoleReport() {
    const superAdminData = JSON.parse(localStorage.getItem('superAdminData'));
    const report = {
        generatedAt: new Date().toISOString(),
        totalRoles: superAdminData.roles.length,
        totalUsers: superAdminData.users.length,
        activeUsers: superAdminData.users.filter(u => u.active).length,
        roleDistribution: superAdminData.roles.map(role => ({
            name: role.displayName,
            userCount: role.userCount,
            permissions: role.permissions
        })),
        recentRoleChanges: superAdminData.roleChanges.slice(-10),
        users: superAdminData.users.map(user => ({
            name: user.name,
            email: user.email,
            role: user.role,
            active: user.active,
            lastActivity: user.lastActivity,
            permissions: user.permissions
        }))
    };
    
    const blob = new Blob([JSON.stringify(report, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `role-management-report-${new Date().toISOString().split('T')[0]}.json`;
    a.click();
    URL.revokeObjectURL(url);
    
    window.roleManager.showAlert('Role management report exported successfully', 'success');
}

// Initialize role manager
function initializeRoleManager() {
    window.roleManager = new RoleManager();
    window.roleManager.init();
}
