// Advanced Analytics JavaScript
class AdvancedAnalytics {
    constructor() {
        this.charts = {};
        this.currentDateRange = 30;
        this.isInitialized = false;
    }

    init() {
        if (this.isInitialized) return;
        
        this.initializeAnalyticsData();
        this.setupEventListeners();
        this.showAnalyticsTab('frequency');
        this.isInitialized = true;
    }

    initializeAnalyticsData() {
        // Generate sample analytics data
        const analyticsData = {
            productFrequency: {
                'Milk': { total: 45, thisMonth: 12, lastMonth: 8, category: 'Dairy' },
                'Cheese': { total: 32, thisMonth: 9, lastMonth: 7, category: 'Dairy' },
                'Yogurt': { total: 28, thisMonth: 8, lastMonth: 6, category: 'Dairy' },
                'Butter': { total: 24, thisMonth: 7, lastMonth: 5, category: 'Dairy' },
                'Cream': { total: 18, thisMonth: 5, lastMonth: 4, category: 'Dairy' }
            },
            topSellingProducts: [
                { name: 'Organic Whole Milk', category: 'Milk', unitsSold: 1250, revenue: 3750, avgPrice: 3.00, growth: 12 },
                { name: 'Aged Cheddar', category: 'Cheese', unitsSold: 890, revenue: 8900, avgPrice: 10.00, growth: 8 },
                { name: 'Greek Yogurt', category: 'Yogurt', unitsSold: 756, revenue: 3780, avgPrice: 5.00, growth: 15 },
                { name: 'Grass-Fed Butter', category: 'Butter', unitsSold: 645, revenue: 3870, avgPrice: 6.00, growth: 5 },
                { name: 'Heavy Cream', category: 'Cream', unitsSold: 523, revenue: 2615, avgPrice: 5.00, growth: -2 }
            ],
            monthlySales: [
                { month: 'Jan 2025', revenue: 12500, orders: 450, avgOrderValue: 27.78, growthRate: 8.5, topCategory: 'Milk' },
                { month: 'Feb 2025', revenue: 13200, orders: 480, avgOrderValue: 27.50, growthRate: 5.6, topCategory: 'Cheese' },
                { month: 'Mar 2025', revenue: 14100, orders: 510, avgOrderValue: 27.65, growthRate: 6.8, topCategory: 'Yogurt' },
                { month: 'Apr 2025', revenue: 13800, orders: 495, avgOrderValue: 27.88, growthRate: -2.1, topCategory: 'Milk' },
                { month: 'May 2025', revenue: 15200, orders: 540, avgOrderValue: 28.15, growthRate: 10.1, topCategory: 'Butter' },
                { month: 'Jun 2025', revenue: 16500, orders: 590, avgOrderValue: 27.97, growthRate: 8.6, topCategory: 'Milk' }
            ]
        };

        // Store in localStorage
        localStorage.setItem('analyticsData', JSON.stringify(analyticsData));
    }

    setupEventListeners() {
        // Auto-refresh analytics every 5 minutes
        setInterval(() => {
            this.refreshCurrentTab();
        }, 300000);
    }

    showAnalyticsTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.analytics-tab').forEach(tab => {
            tab.classList.add('d-none');
        });

        // Show selected tab
        document.getElementById(`${tabName}Analysis`).classList.remove('d-none');

        // Update navigation
        document.querySelectorAll('#analyticsNav .nav-link').forEach(link => {
            link.classList.remove('active');
        });
        document.querySelector(`#analyticsNav .nav-link[onclick="showAnalyticsTab('${tabName}')"]`).classList.add('active');

        // Load tab content
        switch(tabName) {
            case 'frequency':
                this.loadProductFrequencyAnalysis();
                break;
            case 'topselling':
                this.loadTopSellingAnalysis();
                break;
            case 'trends':
                this.loadSalesTrendsAnalysis();
                break;
        }
    }

    loadProductFrequencyAnalysis() {
        const analyticsData = JSON.parse(localStorage.getItem('analyticsData'));
        const productFrequency = analyticsData.productFrequency;

        // Create product frequency chart
        this.createProductFrequencyChart(productFrequency);
        this.createCategoryFrequencyChart(productFrequency);
        this.populateProductFrequencyTable(productFrequency);
    }

    createProductFrequencyChart(data) {
        const ctx = document.getElementById('productFrequencyChart').getContext('2d');
        
        if (this.charts.productFrequency) {
            this.charts.productFrequency.destroy();
        }

        const labels = Object.keys(data);
        const thisMonth = labels.map(label => data[label].thisMonth);
        const lastMonth = labels.map(label => data[label].lastMonth);

        this.charts.productFrequency = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'This Month',
                        data: thisMonth,
                        backgroundColor: 'rgba(13, 110, 253, 0.8)',
                        borderColor: '#0d6efd',
                        borderWidth: 1
                    },
                    {
                        label: 'Last Month',
                        data: lastMonth,
                        backgroundColor: 'rgba(108, 117, 125, 0.8)',
                        borderColor: '#6c757d',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Products Added to Catalog by Month'
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

    createCategoryFrequencyChart(data) {
        const ctx = document.getElementById('categoryFrequencyChart').getContext('2d');
        
        if (this.charts.categoryFrequency) {
            this.charts.categoryFrequency.destroy();
        }

        // Group by category
        const categories = {};
        Object.keys(data).forEach(product => {
            const category = data[product].category;
            categories[category] = (categories[category] || 0) + data[product].total;
        });

        this.charts.categoryFrequency = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(categories),
                datasets: [{
                    data: Object.values(categories),
                    backgroundColor: [
                        '#0d6efd',
                        '#198754',
                        '#ffc107',
                        '#dc3545',
                        '#6f42c1'
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

    populateProductFrequencyTable(data) {
        const tableBody = document.getElementById('productFrequencyTable');
        tableBody.innerHTML = '';

        Object.keys(data).forEach(product => {
            const item = data[product];
            const change = item.thisMonth - item.lastMonth;
            const changePercent = item.lastMonth > 0 ? ((change / item.lastMonth) * 100).toFixed(1) : 0;
            const changeClass = change > 0 ? 'text-success' : change < 0 ? 'text-danger' : 'text-muted';
            const changeIcon = change > 0 ? 'fas fa-arrow-up' : change < 0 ? 'fas fa-arrow-down' : 'fas fa-minus';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.category}</td>
                <td><strong>${item.total}</strong></td>
                <td>${item.thisMonth}</td>
                <td>${item.lastMonth}</td>
                <td class="${changeClass}">
                    <i class="${changeIcon} me-1"></i>
                    ${change > 0 ? '+' : ''}${change} (${changePercent}%)
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    loadTopSellingAnalysis() {
        const analyticsData = JSON.parse(localStorage.getItem('analyticsData'));
        const topProducts = analyticsData.topSellingProducts;

        this.createTopProductsChart(topProducts);
        this.createRevenueByProductChart(topProducts);
        this.populateTopSellingTable(topProducts);
    }

    createTopProductsChart(data) {
        const ctx = document.getElementById('topProductsChart').getContext('2d');
        
        if (this.charts.topProducts) {
            this.charts.topProducts.destroy();
        }

        const labels = data.map(item => item.name);
        const quantities = data.map(item => item.unitsSold);

        this.charts.topProducts = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Units Sold',
                    data: quantities,
                    backgroundColor: 'rgba(25, 135, 84, 0.8)',
                    borderColor: '#198754',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    title: {
                        display: true,
                        text: 'Top Products by Quantity Sold'
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    }
                }
            }
        });
    }

    createRevenueByProductChart(data) {
        const ctx = document.getElementById('revenueByProductChart').getContext('2d');
        
        if (this.charts.revenueByProduct) {
            this.charts.revenueByProduct.destroy();
        }

        const labels = data.map(item => item.name);
        const revenues = data.map(item => item.revenue);

        this.charts.revenueByProduct = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: revenues,
                    backgroundColor: 'rgba(255, 193, 7, 0.8)',
                    borderColor: '#ffc107',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Revenue by Product'
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

    populateTopSellingTable(data) {
        const tableBody = document.getElementById('topSellingTable');
        tableBody.innerHTML = '';

        data.forEach((product, index) => {
            const growthClass = product.growth > 0 ? 'text-success' : product.growth < 0 ? 'text-danger' : 'text-muted';
            const growthIcon = product.growth > 0 ? 'fas fa-arrow-up' : product.growth < 0 ? 'fas fa-arrow-down' : 'fas fa-minus';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td><strong>#${index + 1}</strong></td>
                <td>${product.name}</td>
                <td>${product.category}</td>
                <td>${product.unitsSold.toLocaleString()}</td>
                <td>₱${product.revenue.toLocaleString()}</td>
                <td>₱${product.avgPrice.toFixed(2)}</td>
                <td class="${growthClass}">
                    <i class="${growthIcon} me-1"></i>
                    ${product.growth > 0 ? '+' : ''}${product.growth}%
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    loadSalesTrendsAnalysis() {
        const analyticsData = JSON.parse(localStorage.getItem('analyticsData'));
        const monthlySales = analyticsData.monthlySales;

        this.createSalesTrendsChart(monthlySales);
        this.createSeasonalChart(monthlySales);
        this.createGrowthRateChart(monthlySales);
        this.populateMonthlyPerformanceTable(monthlySales);
    }

    createSalesTrendsChart(data) {
        const ctx = document.getElementById('salesTrendsChart').getContext('2d');
        
        if (this.charts.salesTrends) {
            this.charts.salesTrends.destroy();
        }

        const labels = data.map(item => item.month);
        const revenues = data.map(item => item.revenue);
        const orders = data.map(item => item.orders);

        this.charts.salesTrends = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Revenue (₱)',
                        data: revenues,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Orders',
                        data: orders,
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Sales Trends'
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false,
                        },
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

    createSeasonalChart(data) {
        const ctx = document.getElementById('seasonalChart').getContext('2d');
        
        if (this.charts.seasonal) {
            this.charts.seasonal.destroy();
        }

        // Group by season (simplified)
        const seasons = {
            'Winter': data.slice(0, 2).reduce((sum, item) => sum + item.revenue, 0),
            'Spring': data.slice(2, 4).reduce((sum, item) => sum + item.revenue, 0),
            'Summer': data.slice(4, 6).reduce((sum, item) => sum + item.revenue, 0)
        };

        this.charts.seasonal = new Chart(ctx, {
            type: 'polarArea',
            data: {
                labels: Object.keys(seasons),
                datasets: [{
                    data: Object.values(seasons),
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.8)',
                        'rgba(25, 135, 84, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Seasonal Sales Distribution'
                    }
                }
            }
        });
    }

    createGrowthRateChart(data) {
        const ctx = document.getElementById('growthRateChart').getContext('2d');
        
        if (this.charts.growthRate) {
            this.charts.growthRate.destroy();
        }

        const labels = data.map(item => item.month);
        const growthRates = data.map(item => item.growthRate);

        this.charts.growthRate = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Growth Rate (%)',
                    data: growthRates,
                    backgroundColor: growthRates.map(rate => 
                        rate > 0 ? 'rgba(25, 135, 84, 0.8)' : 'rgba(220, 53, 69, 0.8)'
                    ),
                    borderColor: growthRates.map(rate => 
                        rate > 0 ? '#198754' : '#dc3545'
                    ),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Growth Rate'
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

    populateMonthlyPerformanceTable(data) {
        const tableBody = document.getElementById('monthlyPerformanceTable');
        tableBody.innerHTML = '';

        data.forEach(month => {
            const growthClass = month.growthRate > 0 ? 'text-success' : month.growthRate < 0 ? 'text-danger' : 'text-muted';
            const growthIcon = month.growthRate > 0 ? 'fas fa-arrow-up' : month.growthRate < 0 ? 'fas fa-arrow-down' : 'fas fa-minus';

            const row = document.createElement('tr');
            row.innerHTML = `
                <td><strong>${month.month}</strong></td>
                <td>₱${month.revenue.toLocaleString()}</td>
                <td>${month.orders.toLocaleString()}</td>
                <td>₱${month.avgOrderValue.toFixed(2)}</td>
                <td class="${growthClass}">
                    <i class="${growthIcon} me-1"></i>
                    ${month.growthRate > 0 ? '+' : ''}${month.growthRate}%
                </td>
                <td><span class="badge bg-primary">${month.topCategory}</span></td>
            `;
            tableBody.appendChild(row);
        });
    }

    refreshCurrentTab() {
        const activeTab = document.querySelector('#analyticsNav .nav-link.active');
        if (activeTab) {
            const tabName = activeTab.getAttribute('onclick').match(/'([^']+)'/)[1];
            this.showAnalyticsTab(tabName);
        }
    }
}

// Global functions for UI interactions
function showAnalyticsTab(tabName) {
    window.analytics.showAnalyticsTab(tabName);
}

function setDateRange(days) {
    window.analytics.currentDateRange = parseInt(days);
    window.analytics.refreshCurrentTab();
}

function toggleTopProductsView(viewType) {
    // Update button states
    document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`button[onclick="toggleTopProductsView('${viewType}')"]`).classList.add('active');
    
    // Refresh charts based on view type
    window.analytics.loadTopSellingAnalysis();
}

function toggleTrendsView(viewType) {
    // Update button states
    document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`button[onclick="toggleTrendsView('${viewType}')"]`).classList.add('active');
    
    // Refresh charts based on view type
    window.analytics.loadSalesTrendsAnalysis();
}

function exportAnalyticsReport() {
    const analyticsData = JSON.parse(localStorage.getItem('analyticsData'));
    const report = {
        generatedAt: new Date().toISOString(),
        dateRange: window.analytics.currentDateRange,
        data: analyticsData
    };
    
    const blob = new Blob([JSON.stringify(report, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `analytics-report-${new Date().toISOString().split('T')[0]}.json`;
    a.click();
    URL.revokeObjectURL(url);
}

// Initialize analytics
function initializeAnalytics() {
    window.analytics = new AdvancedAnalytics();
    window.analytics.init();
}
