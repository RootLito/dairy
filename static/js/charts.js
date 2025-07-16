// Initialize all charts on the admin dashboard
document.addEventListener('DOMContentLoaded', function() {
  // Check if we're on a page with charts
  if (document.getElementById('salesChart')) {
    initSalesChart();
  }
  
  if (document.getElementById('productsChart')) {
    initProductsChart();
  }
  
  if (document.getElementById('customerChart')) {
    initCustomerChart();
  }
  
  if (document.getElementById('orderStatusChart')) {
    initOrderStatusChart();
  }
  
  if (document.getElementById('revenueChart')) {
    initRevenueChart();
  }
  
  if (document.getElementById('incomeChart')) {
    initIncomeChart();
  }
  
  if (document.getElementById('expensesChart')) {
    initExpensesChart();
  }
  
  if (document.getElementById('categoryDistributionChart')) {
    initCategoryDistributionChart();
  }
});

// Sales Over Time Chart
function initSalesChart() {
  const ctx = document.getElementById('salesChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      datasets: [{
        label: 'Sales 2023',
        backgroundColor: 'rgba(13, 110, 253, 0.1)',
        borderColor: 'rgba(13, 110, 253, 1)',
        data: [18500, 21000, 19500, 23000, 25500, 28000, 24500, 27000, 29500, 31000, 33500, 30000],
        tension: 0.3,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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
      },
      plugins: {
        legend: {
          display: true
        },
        tooltip: {
          mode: 'index',
          intersect: false
        }
      }
    }
  });
}

// Top Products Chart
function initProductsChart() {
  const ctx = document.getElementById('productsChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Premium Cheese', 'Organic Milk', 'Greek Yogurt', 'Butter', 'Cottage Cheese'],
      datasets: [{
        label: 'Units Sold',
        backgroundColor: 'rgba(13, 110, 253, 0.8)',
        data: [256, 214, 189, 175, 162]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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
      },
      plugins: {
        legend: {
          display: false
        }
      }
    }
  });
}

// Customer Distribution Chart
function initCustomerChart() {
  const ctx = document.getElementById('customerChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['North America', 'Europe', 'Asia', 'Australia', 'South America', 'Africa'],
      datasets: [{
        label: 'Customer Distribution',
        backgroundColor: [
          'rgba(13, 110, 253, 0.8)',
          'rgba(220, 53, 69, 0.8)',
          'rgba(25, 135, 84, 0.8)',
          'rgba(255, 193, 7, 0.8)',
          'rgba(13, 202, 240, 0.8)',
          'rgba(108, 117, 125, 0.8)'
        ],
        data: [45, 25, 15, 8, 5, 2]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right'
        }
      }
    }
  });
}

// Order Status Chart
function initOrderStatusChart() {
  const ctx = document.getElementById('orderStatusChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: ['Delivered', 'Shipped', 'Processing', 'Cancelled'],
      datasets: [{
        label: 'Order Status',
        backgroundColor: [
          'rgba(25, 135, 84, 0.8)',
          'rgba(13, 110, 253, 0.8)',
          'rgba(255, 193, 7, 0.8)',
          'rgba(220, 53, 69, 0.8)'
        ],
        data: [65, 20, 10, 5]
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

// Revenue Chart
function initRevenueChart() {
  const ctx = document.getElementById('revenueChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
      datasets: [{
        label: 'This Month',
        backgroundColor: 'rgba(13, 110, 253, 0.1)',
        borderColor: 'rgba(13, 110, 253, 1)',
        data: [12500, 14000, 15500, 16000],
        tension: 0.4,
        fill: true
      },
      {
        label: 'Last Month',
        backgroundColor: 'rgba(173, 181, 189, 0.1)',
        borderColor: 'rgba(173, 181, 189, 1)',
        data: [11000, 13000, 14000, 15000],
        tension: 0.4,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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
      },
      plugins: {
        legend: {
          display: true
        }
      }
    }
  });
}

// Income Distribution Chart
function initIncomeChart() {
  const ctx = document.getElementById('incomeChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Q1', 'Q2', 'Q3', 'Q4'],
      datasets: [{
        label: 'Revenue',
        backgroundColor: 'rgba(13, 110, 253, 0.8)',
        data: [150000, 175000, 200000, 225000]
      },
      {
        label: 'Expenses',
        backgroundColor: 'rgba(220, 53, 69, 0.8)',
        data: [110000, 125000, 145000, 160000]
      },
      {
        label: 'Profit',
        backgroundColor: 'rgba(25, 135, 84, 0.8)',
        data: [40000, 50000, 55000, 65000]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
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
      },
      plugins: {
        legend: {
          position: 'top'
        }
      }
    }
  });
}

// Expenses Chart
function initExpensesChart() {
  const ctx = document.getElementById('expensesChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Inventory Cost', 'Marketing', 'Salaries', 'Logistics', 'Operations', 'Other'],
      datasets: [{
        label: 'Expense Distribution',
        backgroundColor: [
          'rgba(13, 110, 253, 0.8)',
          'rgba(220, 53, 69, 0.8)',
          'rgba(25, 135, 84, 0.8)',
          'rgba(255, 193, 7, 0.8)',
          'rgba(13, 202, 240, 0.8)',
          'rgba(108, 117, 125, 0.8)'
        ],
        data: [35, 20, 25, 10, 7, 3]
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'right'
        }
      }
    }
  });
}

// Category Distribution Chart
function initCategoryDistributionChart() {
  const ctx = document.getElementById('categoryDistributionChart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'polarArea',
    data: {
      labels: ['Milk', 'Cheese', 'Yogurt', 'Butter', 'Ice Cream'],
      datasets: [{
        label: 'Sales by Category',
        backgroundColor: [
          'rgba(13, 110, 253, 0.7)',
          'rgba(220, 53, 69, 0.7)',
          'rgba(25, 135, 84, 0.7)',
          'rgba(255, 193, 7, 0.7)',
          'rgba(13, 202, 240, 0.7)'
        ],
        data: [35, 25, 20, 15, 5]
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