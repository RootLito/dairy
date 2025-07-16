// Admin Dashboard Javascript
document.addEventListener('DOMContentLoaded', function() {
  // Initialize tooltips
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Initialize popovers
  const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  popoverTriggerList.map(function(popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });

  // Date range picker (if on pages that need it)
  if (document.getElementById('reportDateRange')) {
    document.getElementById('reportDateRange').addEventListener('change', function() {
      // This would handle date range changes for reports
      console.log('Date range changed to:', this.value);
    });
  }

  // Handle inventory search
  const inventorySearchInput = document.getElementById('inventorySearch');
  if (inventorySearchInput) {
    inventorySearchInput.addEventListener('input', function() {
      filterInventoryTable(this.value.toLowerCase());
    });
  }

  // Handle user search
  const userSearchInput = document.getElementById('userSearch');
  if (userSearchInput) {
    userSearchInput.addEventListener('input', function() {
      filterUserTable(this.value.toLowerCase());
    });
  }

  // Toggle user status
  const userStatusSwitches = document.querySelectorAll('.user-status-switch');
  userStatusSwitches.forEach(function(switchEl) {
    switchEl.addEventListener('change', function() {
      const userId = this.getAttribute('data-user-id');
      const status = this.checked ? 'active' : 'inactive';
      updateUserStatus(userId, status);
    });
  });

  // Handle inventory stock updates
  const stockInputs = document.querySelectorAll('.stock-input');
  stockInputs.forEach(function(input) {
    input.addEventListener('change', function() {
      const productId = this.getAttribute('data-product-id');
      updateProductStock(productId, this.value);
    });
  });

  // Handle export buttons
  const exportButtons = document.querySelectorAll('.export-data-btn');
  exportButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      const dataType = this.getAttribute('data-type');
      exportData(dataType);
    });
  });

  // Report filter handling
  const reportFilterForm = document.getElementById('reportFilterForm');
  if (reportFilterForm) {
    reportFilterForm.addEventListener('submit', function(e) {
      e.preventDefault();
      applyReportFilters();
    });
  }
});

// Function to filter inventory table based on search input
function filterInventoryTable(query) {
  const rows = document.querySelectorAll('#inventoryTable tbody tr');
  
  rows.forEach(function(row) {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(query) ? '' : 'none';
  });
}

// Function to filter user table based on search input
function filterUserTable(query) {
  const rows = document.querySelectorAll('#userTable tbody tr');
  
  rows.forEach(function(row) {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(query) ? '' : 'none';
  });
}

// Function to update user status (would connect to backend in real implementation)
function updateUserStatus(userId, status) {
  console.log(`User ${userId} status updated to ${status}`);
  // Show a success message
  const alertContainer = document.getElementById('alertContainer');
  if (alertContainer) {
    alertContainer.innerHTML = `
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        User status updated successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;
  }
}

// Function to update product stock (would connect to backend in real implementation)
function updateProductStock(productId, stockValue) {
  console.log(`Product ${productId} stock updated to ${stockValue}`);
  // Show a success message
  const alertContainer = document.getElementById('alertContainer');
  if (alertContainer) {
    alertContainer.innerHTML = `
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Inventory updated successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;
  }
}

// Function to export data (would connect to backend in real implementation)
function exportData(dataType) {
  console.log(`Exporting ${dataType} data`);
  // Show a success message
  const alertContainer = document.getElementById('alertContainer');
  if (alertContainer) {
    alertContainer.innerHTML = `
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        ${dataType} data export started. The file will be ready for download shortly.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;
  }
}

// Function to apply report filters (would connect to backend in real implementation)
function applyReportFilters() {
  console.log('Applying report filters');
  // Show loading state
  const reportContainer = document.getElementById('reportContainer');
  if (reportContainer) {
    reportContainer.innerHTML = `
      <div class="d-flex justify-content-center my-5">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    `;
    
    // Simulate loading delay
    setTimeout(() => {
      // Reset content (in real app, this would show filtered data)
      reportContainer.innerHTML = `
        <div class="alert alert-info">
          Report filters applied. This would show filtered data in a real application.
        </div>
      `;
    }, 1000);
  }
}