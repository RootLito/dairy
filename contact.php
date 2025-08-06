<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - Contact Us</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>

<body>
    <?php include 'nav.php'; ?>

    <main>
        <section class="py-5 bg-primary text-white">
            <div class="container py-4">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h1 class="display-4 fw-bold mb-3">Get in Touch</h1>
                        <p class="lead mb-4">We'd love to hear from you. Whether you have a question about our products, want to provide feedback, or are interested in partnership opportunities, our team is here to help.</p>
                        <div class="d-flex flex-wrap">
                            <div class="me-4 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-phone fa-lg me-2"></i>
                                    <span class="h5 mb-0">(123) 456-7890</span>
                                </div>
                                <div class="text-white-50 mt-1">Monday-Friday, 9am-5pm EST</div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-envelope fa-lg me-2"></i>
                                    <span class="h5 mb-0">help@dairymart.com</span>
                                </div>
                                <div class="text-white-50 mt-1">We'll respond within 24 hours</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80" alt="DairyMart Customer Service" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-8">
                        <h2 class="display-6 mb-4">Send Us a Message</h2>
                        <form id="contactForm" class="needs-validation" novalidate>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="John Doe" required>
                                    <div class="invalid-feedback">
                                        Please enter your name.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" placeholder="you@example.com" required>
                                    <div class="invalid-feedback">
                                        Please enter a valid email address.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number (Optional)</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="(123) 456-7890">
                                </div>
                                <div class="col-md-6">
                                    <label for="subject" class="form-label">Subject</label>
                                    <select class="form-select" id="subject" required>
                                        <option value="" selected disabled>Select a subject</option>
                                        <option value="order">Order Inquiry</option>
                                        <option value="product">Product Information</option>
                                        <option value="shipping">Shipping & Delivery</option>
                                        <option value="returns">Returns & Refunds</option>
                                        <option value="wholesale">Wholesale Inquiries</option>
                                        <option value="partnership">Partnership Opportunities</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a subject.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="orderNumber" class="form-label">Order Number (if applicable)</label>
                                    <input type="text" class="form-control" id="orderNumber" placeholder="e.g., DM12345678">
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Your Message</label>
                                    <textarea class="form-control" id="message" rows="5" placeholder="How can we help you?" required></textarea>
                                    <div class="invalid-feedback">
                                        Please enter your message.
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="privacyCheck" required>
                                        <label class="form-check-label" for="privacyCheck">
                                            I agree to the <a href="#" class="text-decoration-none">Privacy Policy</a> and consent to the processing of my data.
                                        </label>
                                        <div class="invalid-feedback">
                                            You must agree before submitting.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="newsletterCheck">
                                        <label class="form-check-label" for="newsletterCheck">
                                            I'd like to receive updates about products, special offers, and dairy news.
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button class="btn btn-primary btn-lg" type="submit">
                                        <i class="fas fa-paper-plane me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Success Message (hidden by default) -->
                        <div class="alert alert-success mt-4 d-none" id="contactSuccess">
                            <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Thank you for your message!</h4>
                            <p>We've received your inquiry and will get back to you as soon as possible, usually within 24 hours.</p>
                            <hr>
                            <p class="mb-0">Your reference number is: <strong id="referenceNumber">DM-20250329-1234</strong></p>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="sticky-lg-top" style="top: 100px;">
                            <!-- Contact Info Card -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h3 class="h5 card-title mb-4">Contact Information</h3>
                                    <ul class="list-unstyled">
                                        <li class="d-flex mb-4">
                                            <div class="icon-square bg-primary text-white rounded-circle p-2 me-3 flex-shrink-0">
                                                <i class="fas fa-map-marker-alt"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold">Headquarters</h6>
                                                <p class="text-muted mb-0">
                                                    123 Dairy Road<br>
                                                    Milk County, CA 90210<br>
                                                    United States
                                                </p>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4">
                                            <div class="icon-square bg-primary text-white rounded-circle p-2 me-3 flex-shrink-0">
                                                <i class="fas fa-phone"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold">Phone Numbers</h6>
                                                <p class="text-muted mb-1">Customer Service: (123) 456-7890</p>
                                                <p class="text-muted mb-1">Wholesale: (123) 456-7891</p>
                                                <p class="text-muted mb-0">Fax: (123) 456-7892</p>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4">
                                            <div class="icon-square bg-primary text-white rounded-circle p-2 me-3 flex-shrink-0">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold">Email Addresses</h6>
                                                <p class="text-muted mb-1">Customer Support: <a href="mailto:help@dairymart.com" class="text-decoration-none">help@dairymart.com</a></p>
                                                <p class="text-muted mb-1">Orders: <a href="mailto:orders@dairymart.com" class="text-decoration-none">orders@dairymart.com</a></p>
                                                <p class="text-muted mb-0">Wholesale: <a href="mailto:wholesale@dairymart.com" class="text-decoration-none">wholesale@dairymart.com</a></p>
                                            </div>
                                        </li>
                                        <li class="d-flex">
                                            <div class="icon-square bg-primary text-white rounded-circle p-2 me-3 flex-shrink-0">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold">Business Hours</h6>
                                                <p class="text-muted mb-1">Monday-Friday: 9:00 AM - 5:00 PM EST</p>
                                                <p class="text-muted mb-0">Saturday: 10:00 AM - 2:00 PM EST</p>
                                                <p class="text-muted mb-0">Sunday: Closed</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Social Media Card -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h3 class="h5 card-title mb-3">Connect With Us</h3>
                                    <p class="text-muted mb-3">Follow us on social media for the latest products, special offers, and dairy-related content.</p>
                                    <div class="d-flex justify-content-between">
                                        <a href="#" class="btn btn-outline-primary btn-sm">
                                            <i class="fab fa-facebook-f me-2"></i>Facebook
                                        </a>
                                        <a href="#" class="btn btn-outline-info btn-sm">
                                            <i class="fab fa-twitter me-2"></i>Twitter
                                        </a>
                                        <a href="#" class="btn btn-outline-danger btn-sm">
                                            <i class="fab fa-instagram me-2"></i>Instagram
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ Card -->
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="h5 card-title mb-3">Frequently Asked Questions</h3>
                                    <p class="text-muted mb-3">Find quick answers to common questions:</p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item bg-transparent px-0">
                                            <a href="#" class="text-decoration-none d-flex justify-content-between align-items-center">
                                                How do you ship perishable products?
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item bg-transparent px-0">
                                            <a href="#" class="text-decoration-none d-flex justify-content-between align-items-center">
                                                What is your return policy?
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item bg-transparent px-0">
                                            <a href="#" class="text-decoration-none d-flex justify-content-between align-items-center">
                                                Do you offer international shipping?
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item bg-transparent px-0">
                                            <a href="#" class="text-decoration-none d-flex justify-content-between align-items-center">
                                                How can I track my order?
                                                <i class="fas fa-angle-right"></i>
                                            </a>
                                        </li>
                                        <li class="list-group-item bg-transparent px-0 border-bottom-0">
                                            <a href="#" class="btn btn-link text-primary p-0">
                                                View all FAQs <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Location Section with Map -->
        <section class="py-5 bg-body-tertiary">
            <div class="container">
                <h2 class="display-6 text-center mb-5">Visit Our Headquarters</h2>
                <div class="row g-4">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <!-- Map Placeholder - In a real site, this would be an interactive map -->
                        <div class="card map-container">
                            <div class="ratio ratio-16x9">
                                <div class="bg-body-secondary d-flex justify-content-center align-items-center">
                                    <!-- This is a placeholder for a real map -->
                                    <div class="text-center p-4">
                                        <i class="fas fa-map-marked-alt fa-5x mb-3 text-muted"></i>
                                        <h5 class="mb-0">Interactive Map</h5>
                                        <p class="text-muted">(Map integration would be here)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h3 class="h4 card-title mb-4">Directions to Our Office</h3>
                                <div class="mb-4">
                                    <h5 class="h6">Address</h5>
                                    <p class="mb-0">
                                        123 Dairy Road<br>
                                        Milk County, CA 90210<br>
                                        United States
                                    </p>
                                </div>
                                <div class="mb-4">
                                    <h5 class="h6">By Car</h5>
                                    <p>From Highway 101, take Exit 15 toward Milk County. Turn right onto Dairy Road. Our office is located 1.5 miles down on the right, across from the Farmers Market.</p>
                                </div>
                                <div class="mb-4">
                                    <h5 class="h6">Public Transportation</h5>
                                    <p>Take the Metro Blue Line to Milk County Station. Transfer to Bus Route 42 and exit at Dairy Road. Our office is a short 2-minute walk from the bus stop.</p>
                                </div>
                                <div class="mb-4">
                                    <h5 class="h6">Parking</h5>
                                    <p>Free visitor parking is available in our lot. Enter from Dairy Road and follow signs for visitor parking.</p>
                                </div>
                                <div class="mt-4">
                                    <a href="#" class="btn btn-outline-primary">
                                        <i class="fas fa-directions me-2"></i>Get Directions
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h2 class="display-6 mb-4">Join Our Team</h2>
                        <p class="lead mb-4">Passionate about dairy? We're always looking for talented individuals to join our growing team.</p>
                        <p>At DairyMart, we value innovation, passion for quality, and a customer-first mindset. We offer competitive benefits, professional development opportunities, and a collaborative work environment.</p>
                        <p>Current openings include positions in:</p>
                        <ul class="mb-4">
                            <li>Product Sourcing & Development</li>
                            <li>Customer Experience</li>
                            <li>Digital Marketing</li>
                            <li>Warehouse & Fulfillment</li>
                            <li>Quality Control</li>
                        </ul>
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-briefcase me-2"></i>View Open Positions
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80" alt="DairyMart Team" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-primary text-white">
            <div class="container">
                <h2 class="display-6 text-center mb-5">We're Here to Help</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card bg-transparent border-white text-center h-100">
                            <div class="card-body">
                                <div class="icon-circle bg-white text-primary mx-auto mb-4">
                                    <i class="fas fa-headset fa-2x"></i>
                                </div>
                                <h4 class="card-title">Customer Support</h4>
                                <p class="card-text">Our friendly customer service team is ready to assist you with any questions or concerns.</p>
                                <a href="tel:+1234567890" class="btn btn-outline-light mt-3">
                                    <i class="fas fa-phone me-2"></i>(123) 456-7890
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-transparent border-white text-center h-100">
                            <div class="card-body">
                                <div class="icon-circle bg-white text-primary mx-auto mb-4">
                                    <i class="fas fa-comments fa-2x"></i>
                                </div>
                                <h4 class="card-title">Live Chat</h4>
                                <p class="card-text">Chat with our team in real-time for immediate assistance with your questions.</p>
                                <button class="btn btn-outline-light mt-3">
                                    <i class="fas fa-comment-dots me-2"></i>Start Chat
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-transparent border-white text-center h-100">
                            <div class="card-body">
                                <div class="icon-circle bg-white text-primary mx-auto mb-4">
                                    <i class="fas fa-question-circle fa-2x"></i>
                                </div>
                                <h4 class="card-title">Help Center</h4>
                                <p class="card-text">Browse our comprehensive knowledge base for detailed answers to common questions.</p>
                                <a href="#" class="btn btn-outline-light mt-3">
                                    <i class="fas fa-book me-2"></i>Visit Help Center
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="mb-3">DairyMart</h5>
                    <p>Your one-stop shop for all your dairy needs. Quality products, competitive prices, and excellent customer service.</p>
                    <div class="d-flex mt-4">
                        <a href="#" class="me-3 text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="me-3 text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="me-3 text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-white">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2 mb-4 mb-md-0">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php" class="text-decoration-none text-white">Home</a></li>
                        <li class="mb-2"><a href="products.php" class="text-decoration-none text-white">Products</a></li>
                        <li class="mb-2"><a href="about.php" class="text-decoration-none text-white">About Us</a></li>
                        <li class="mb-2"><a href="contact.php" class="text-decoration-none text-white">Contact</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Blog</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-2 mb-4 mb-md-0">
                    <h5 class="mb-3">Customer Service</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-white">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-white">Shipping</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-white">Returns</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-white">Warranty</a></li>
                        <li><a href="#" class="text-decoration-none text-white">Support</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-4">
                    <h5 class="mb-3">Contact Us</h5>
                    <address>
                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Dairy Road, Milk County, Country</p>
                        <p class="mb-2"><i class="fas fa-phone me-2"></i> (123) 456-7890</p>
                        <p class="mb-2"><i class="fas fa-envelope me-2"></i> info@dairymart.com</p>
                    </address>
                    <div class="mt-3">
                        <h6>We Accept</h6>
                        <div class="d-flex mt-2">
                            <i class="fab fa-cc-visa fa-2x me-2"></i>
                            <i class="fab fa-cc-mastercard fa-2x me-2"></i>
                            <i class="fab fa-cc-amex fa-2x me-2"></i>
                            <i class="fab fa-cc-paypal fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-0">&copy; 2025 DairyMart. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                        <li class="list-inline-item ms-3"><a href="#" class="text-white text-decoration-none">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>