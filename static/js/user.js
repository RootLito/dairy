// User Interface Javascript
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

  // Product quantity controls
  const decreaseButtons = document.querySelectorAll('#decreaseQuantity, .btn-outline-secondary[type="button"]:first-child');
  const increaseButtons = document.querySelectorAll('#increaseQuantity, .btn-outline-secondary[type="button"]:last-child');
  const quantityInputs = document.querySelectorAll('#quantity, input[type="text"].form-control, input[type="number"].form-control');

  decreaseButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      const input = this.closest('.input-group').querySelector('input');
      const value = parseInt(input.value, 10);
      if (value > 1) {
        input.value = value - 1;
      }
    });
  });

  increaseButtons.forEach(function(button) {
    button.addEventListener('click', function() {
      const input = this.closest('.input-group').querySelector('input');
      const value = parseInt(input.value, 10);
      input.value = value + 1;
    });
  });

  // Add to cart button
  const addToCartButtons = document.querySelectorAll('.btn-primary');
  addToCartButtons.forEach(function(button) {
    // Check if the button contains "Add" text
    if (button.textContent.includes('Add')) {
      button.addEventListener('click', function(e) {
        e.preventDefault();
        addToCart();
      });
    }
  });

  // Product filter controls
  const priceRange = document.getElementById('priceRange');
  if (priceRange) {
    priceRange.addEventListener('input', function() {
      updatePriceFilter(this.value);
    });
  }
});

// Function to add item to cart
function addToCart() {
  // Show success message
  const alertContainer = document.createElement('div');
  alertContainer.className = 'position-fixed top-0 end-0 p-3';
  alertContainer.style.zIndex = '1050';
  
  alertContainer.innerHTML = `
    <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <i class="fas fa-check-circle me-2"></i> Item added to your cart!
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  `;
  
  document.body.appendChild(alertContainer);
  
  const toastElement = alertContainer.querySelector('.toast');
  const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
  toast.show();
  
  // Remove the element after it's hidden
  toastElement.addEventListener('hidden.bs.toast', function() {
    alertContainer.remove();
  });
  
  // Update cart count (in a real app this would communicate with backend)
  const cartBadge = document.querySelector('.fa-shopping-cart').nextElementSibling;
  if (cartBadge) {
    let count = parseInt(cartBadge.textContent, 10);
    cartBadge.textContent = count + 1;
  }
}

// Function to update price range display
function updatePriceFilter(value) {
  const displayElement = document.querySelector('.price-range-display');
  if (displayElement) {
    displayElement.textContent = `$${value}`;
  }
}