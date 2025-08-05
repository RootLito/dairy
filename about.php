<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DairyMart - About Us</title>
    <link href="https://cdn.replit.com/agent/bootstrap-agent-dark-theme.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-cheese me-2"></i>DairyMart
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
                
                <div class="d-flex">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Login / Register <i class="fas fa-user me-1"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="login.php">Login</a></li>
                            <li><a class="dropdown-item" href="register.php">Register</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <section class="py-5 bg-primary text-white text-center">
            <div class="container py-4">
                <h1 class="display-4 fw-bold mb-3">Our Story</h1>
                <p class="lead mb-4">We're passionate about quality dairy products from sustainable farms</p>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1200&q=80" 
                             alt="DairyMart Team" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <img src="https://images.unsplash.com/photo-1506459225024-1428097a7e18?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80" 
                             alt="Happy Cows in Pasture" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-lg-6">
                        <h2 class="display-6 mb-4">Our Mission</h2>
                        <p class="lead mb-4">Delivering exceptional dairy products while supporting sustainable farming practices and animal welfare.</p>
                        <p>At DairyMart, we believe that the best dairy products come from happy, healthy cows raised on sustainable farms. We're committed to supporting local farmers who share our values of ethical animal treatment, environmental stewardship, and traditional craftsmanship.</p>
                        <p>Our mission extends beyond just selling dairy products. We aim to educate our customers about the importance of responsible farming practices and the impact of their purchasing decisions on the environment and local communities.</p>
                        <div class="d-flex mt-4">
                            <div class="me-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success me-2 fa-lg"></i>
                                    <h5 class="mb-0">Quality</h5>
                                </div>
                                <p class="text-muted">Only the finest dairy products from trusted sources</p>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-check-circle text-success me-2 fa-lg"></i>
                                    <h5 class="mb-0">Sustainability</h5>
                                </div>
                                <p class="text-muted">Environmentally responsible practices from farm to table</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-body-tertiary">
            <div class="container">
                <h2 class="display-6 text-center mb-5">Our Journey</h2>
                <div class="timeline">
                    <div class="row g-0">
                        <div class="col-md-6 order-md-1 timeline-item text-md-end">
                            <div class="timeline-content p-4 rounded shadow">
                                <div class="timeline-year bg-primary rounded-circle">2005</div>
                                <h4>Starting Small</h4>
                                <p>DairyMart began as a small cheese shop in Milk County, founded by James Wilson with just 10 local cheese varieties.</p>
                            </div>
                        </div>
                        <div class="col-md-6 order-md-2 timeline-item">
                            <div class="timeline-content p-4 rounded shadow mt-4 mt-md-5">
                                <div class="timeline-year bg-primary rounded-circle">2010</div>
                                <h4>Expanding Our Product Line</h4>
                                <p>We expanded our product line to include yogurts, butters, and specialty milk products from over 30 regional farms.</p>
                            </div>
                        </div>
                        <div class="col-md-6 order-md-3 timeline-item text-md-end">
                            <div class="timeline-content p-4 rounded shadow mt-4">
                                <div class="timeline-year bg-primary rounded-circle">2015</div>
                                <h4>Online Store Launch</h4>
                                <p>We launched our online store to reach dairy lovers nationwide with temperature-controlled shipping technology.</p>
                            </div>
                        </div>
                        <div class="col-md-6 order-md-4 timeline-item">
                            <div class="timeline-content p-4 rounded shadow mt-4 mt-md-5">
                                <div class="timeline-year bg-primary rounded-circle">2020</div>
                                <h4>Sustainability Commitment</h4>
                                <p>We pledged to work only with farms committed to sustainable practices, and launched our carbon-neutral shipping program.</p>
                            </div>
                        </div>
                        <div class="col-md-6 order-md-5 timeline-item text-md-end">
                            <div class="timeline-content p-4 rounded shadow mt-4">
                                <div class="timeline-year bg-primary rounded-circle">2025</div>
                                <h4>Looking Forward</h4>
                                <p>Today, we continue to grow our selection while maintaining our commitment to quality, community, and sustainability.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="py-5">
            <div class="container">
                <h2 class="display-6 text-center mb-5">Meet Our Team</h2>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 team-card">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80" alt="James Wilson" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">James Wilson</h5>
                                <p class="text-muted">Founder & CEO</p>
                                <p class="card-text">James founded DairyMart with a passion for artisanal cheese and sustainable farming practices. He personally visits each farm we partner with.</p>
                                <div class="social-icons mt-3">
                                    <a href="#" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                                    <a href="#" class="text-primary me-2"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="text-primary"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 team-card">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80" alt="Sarah Johnson" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Sarah Johnson</h5>
                                <p class="text-muted">Chief Product Officer</p>
                                <p class="card-text">With 15 years of experience in dairy product development, Sarah leads our product selection and quality control processes.</p>
                                <div class="social-icons mt-3">
                                    <a href="#" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                                    <a href="#" class="text-primary me-2"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="text-primary"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 team-card">
                            <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80" alt="Michael Chen" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Michael Chen</h5>
                                <p class="text-muted">Director of Operations</p>
                                <p class="card-text">Michael ensures that our products are stored, handled, and shipped under optimal conditions to preserve freshness and quality.</p>
                                <div class="social-icons mt-3">
                                    <a href="#" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                                    <a href="#" class="text-primary me-2"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="text-primary"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 team-card">
                            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80" alt="Emily Rodriguez" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="card-title">Emily Rodriguez</h5>
                                <p class="text-muted">Sustainability Director</p>
                                <p class="card-text">Emily works directly with our partner farms to implement and maintain environmentally friendly practices throughout our supply chain.</p>
                                <div class="social-icons mt-3">
                                    <a href="#" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                                    <a href="#" class="text-primary me-2"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="text-primary"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="py-5 bg-body-tertiary">
            <div class="container">
                <h2 class="display-6 text-center mb-5">Our Values</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0 bg-transparent">
                            <div class="card-body text-center">
                                <div class="value-icon mb-3">
                                    <i class="fas fa-leaf fa-3x text-success"></i>
                                </div>
                                <h4 class="card-title">Sustainability</h4>
                                <p class="card-text">We partner with farms that use sustainable agricultural practices to minimize environmental impact. From renewable energy to water conservation, our suppliers are committed to protecting the planet.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 bg-transparent">
                            <div class="card-body text-center">
                                <div class="value-icon mb-3">
                                    <i class="fas fa-heart fa-3x text-danger"></i>
                                </div>
                                <h4 class="card-title">Animal Welfare</h4>
                                <p class="card-text">Our dairy products come from farms where animal welfare is a top priority. Cows have access to pasture, nutritious feed, and receive proper veterinary care. Happy cows produce better milk—it's that simple.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0 bg-transparent">
                            <div class="card-body text-center">
                                <div class="value-icon mb-3">
                                    <i class="fas fa-users fa-3x text-primary"></i>
                                </div>
                                <h4 class="card-title">Community Support</h4>
                                <p class="card-text">We believe in supporting the communities where our products are produced. Our fair pricing ensures farmers receive proper compensation for their work, helping to sustain rural economies and family farms.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Farm Partners Section -->
        <section class="py-5">
            <div class="container">
                <h2 class="display-6 text-center mb-5">Our Farm Partners</h2>
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 farm-card">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <img src="https://images.unsplash.com/photo-1500595046743-cd271d694d30?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80" 
                                         alt="Green Valley Farms" class="img-fluid h-100" style="object-fit: cover;">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title">Green Valley Farms</h5>
                                        <p class="text-muted">Wisconsin, USA</p>
                                        <p class="card-text">A third-generation family farm specializing in artisanal cheddar and gouda. Their 100 Jersey cows graze on organic pastures year-round when weather permits.</p>
                                        <div class="farm-certifications mt-3">
                                            <span class="badge bg-success me-2">Organic Certified</span>
                                            <span class="badge bg-info">Family Owned</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 farm-card">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <img src="https://images.unsplash.com/photo-1590273466070-40c466b4432d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80" 
                                         alt="Alpine Meadows Dairy" class="img-fluid h-100" style="object-fit: cover;">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title">Alpine Meadows Dairy</h5>
                                        <p class="text-muted">Vermont, USA</p>
                                        <p class="card-text">Nestled in the Green Mountains, this cooperative of small farms produces award-winning butter and cream using traditional European methods.</p>
                                        <div class="farm-certifications mt-3">
                                            <span class="badge bg-success me-2">Sustainable Farming</span>
                                            <span class="badge bg-info">Cooperative</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 farm-card">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <img src="https://images.unsplash.com/photo-1501597301489-8b75b675fad7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80" 
                                         alt="Sunny Creek Yogurt" class="img-fluid h-100" style="object-fit: cover;">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title">Sunny Creek Yogurt</h5>
                                        <p class="text-muted">California, USA</p>
                                        <p class="card-text">Specializing in probiotic-rich yogurts and kefirs, this innovative farm uses solar power for 90% of their energy needs and implements water recycling systems.</p>
                                        <div class="farm-certifications mt-3">
                                            <span class="badge bg-success me-2">Solar Powered</span>
                                            <span class="badge bg-info">Water Conservation</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 farm-card">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <img src="https://images.unsplash.com/photo-1516253593875-bd7ba052fbc5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80" 
                                         alt="Heritage Blue Cheese" class="img-fluid h-100" style="object-fit: cover;">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title">Heritage Blue Cheese</h5>
                                        <p class="text-muted">Oregon, USA</p>
                                        <p class="card-text">A small-batch artisanal producer dedicated to preserving traditional blue cheese making techniques. Their aging caves are built into the hillside, using natural cooling.</p>
                                        <div class="farm-certifications mt-3">
                                            <span class="badge bg-success me-2">Artisanal</span>
                                            <span class="badge bg-info">Heritage Methods</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        

    <footer class="bg-dark text-white py-5">
        <div class="container">
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