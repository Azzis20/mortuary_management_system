<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peaceful Rest - Mortuary Services</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #000;
            --secondary: #666;
            --border: #e0e0e0;
            --bg: #fff;
            --bg-light: #fafafa;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.7;
            color: var(--primary);
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.98);
            border-bottom: 1px solid var(--border);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--primary);
            letter-spacing: -0.5px;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 3rem;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--secondary);
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .nav-menu a:hover {
            color: var(--primary);
        }

        .btn-nav {
            color: var(--primary) !important;
            padding: 0.6rem 1.5rem;
            border: 1px solid var(--primary);
            border-radius: 2px;
            transition: all 0.3s;
        }

        .btn-nav:hover {
            background: var(--primary);
            color: white !important;
        }

        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
        }

        .mobile-toggle span {
            width: 24px;
            height: 2px;
            background: var(--primary);
            transition: all 0.3s;
        }

        /* Hero Section */
        .hero {
            margin-top: 72px;
            min-height: 85vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            border-bottom: 1px solid var(--border);
        }

        .hero-content {
            max-width: 800px;
            padding: 0 2rem;
            text-align: center;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 300;
            margin-bottom: 1.5rem;
            letter-spacing: -2px;
            line-height: 1.1;
        }

        .hero p {
            font-size: 1.1rem;
            color: var(--secondary);
            margin-bottom: 3rem;
            font-weight: 300;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 1rem 2.5rem;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 400;
            border-radius: 2px;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            opacity: 0.85;
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary);
            padding: 1rem 2.5rem;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 400;
            border: 1px solid var(--primary);
            border-radius: 2px;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
        }

        /* Services Section */
        .services {
            padding: 8rem 2rem;
            background: var(--bg-light);
        }

        .section-header {
            text-align: center;
            margin-bottom: 5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 2.5rem);
            font-weight: 300;
            color: var(--primary);
            margin-bottom: 1rem;
            letter-spacing: -1px;
        }

        .section-subtitle {
            color: var(--secondary);
            font-size: 1rem;
            font-weight: 300;
        }

        .services-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 3rem;
        }

        .service-card {
            text-align: center;
        }

        .service-card h3 {
            font-size: 1.1rem;
            margin-bottom: 0.8rem;
            font-weight: 500;
            letter-spacing: -0.3px;
        }

        .service-card p {
            color: var(--secondary);
            font-size: 0.95rem;
            line-height: 1.7;
            font-weight: 300;
        }

        /* Packages Section */
        .packages {
            padding: 8rem 2rem;
            background: var(--bg);
        }

        .packages-grid {
            max-width: 1200px;
            margin: 3rem auto 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .package-card {
            background: var(--bg);
            border: 1px solid var(--border);
            padding: 3rem 2rem;
            transition: all 0.3s;
        }

        .package-card:hover {
            border-color: var(--primary);
        }

        .package-card.featured {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .package-name {
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 2.5rem;
            letter-spacing: -0.5px;
        }

        .package-features {
            list-style: none;
            margin-bottom: 2.5rem;
        }

        .package-features li {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
            font-size: 0.95rem;
            font-weight: 300;
        }

        .package-card.featured .package-features li {
            border-bottom-color: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.9);
        }

        .package-features li:last-child {
            border-bottom: none;
        }

        .package-btn {
            width: 100%;
            padding: 1rem;
            text-decoration: none;
            font-weight: 400;
            font-size: 0.95rem;
            text-align: center;
            display: block;
            transition: all 0.3s;
            border-radius: 2px;
        }

        .package-card:not(.featured) .package-btn {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .package-card:not(.featured) .package-btn:hover {
            background: var(--primary);
            color: white;
        }

        .package-card.featured .package-btn {
            background: white;
            color: var(--primary);
        }

        .package-card.featured .package-btn:hover {
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background: var(--bg-light);
            padding: 5rem 2rem 3rem;
            border-top: 1px solid var(--border);
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 4rem;
            margin-bottom: 4rem;
        }

        .footer-section h4 {
            font-size: 1rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            letter-spacing: -0.3px;
        }

        .footer-section p {
            color: var(--secondary);
            margin-bottom: 0.8rem;
            font-size: 0.95rem;
            font-weight: 300;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
            text-align: center;
            color: var(--secondary);
            font-size: 0.9rem;
            font-weight: 300;
        }

        /* Mobile Responsive */
        @media (max-width: 968px) {
            .nav-menu {
                position: fixed;
                top: 73px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 73px);
                background: white;
                flex-direction: column;
                padding: 3rem 2rem;
                gap: 2rem;
                transition: left 0.3s;
                border-top: 1px solid var(--border);
            }

            .nav-menu.active {
                left: 0;
            }

            .mobile-toggle {
                display: flex;
            }

            .mobile-toggle.active span:nth-child(1) {
                transform: rotate(45deg) translate(6px, 6px);
            }

            .mobile-toggle.active span:nth-child(2) {
                opacity: 0;
            }

            .mobile-toggle.active span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -7px);
            }

            .services-grid,
            .packages-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .services {
                padding: 5rem 2rem;
            }

            .packages {
                padding: 5rem 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">Peaceful Rest</div>
            <div class="mobile-toggle" id="mobileToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <ul class="nav-menu" id="navMenu">
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#packages">Packages</a></li>
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}" class="btn-nav">Sign Up</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Honoring Lives with Dignity and Compassion</h1>
            <p>Professional mortuary services for your loved ones in their final journey</p>
            <div class="hero-buttons">
                <a href="#" class="btn-primary">Get Started</a>
                <a href="#packages" class="btn-secondary">View Packages</a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="section-header">
            <h2 class="section-title">Our Services</h2>
            <p class="section-subtitle">Comprehensive care delivered with respect and professionalism</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <h3>24/7 Availability</h3>
                <p>Round-the-clock service whenever you need us most</p>
            </div>
            <div class="service-card">
                <h3>Professional Embalming</h3>
                <p>Expert care by licensed professionals</p>
            </div>
            <div class="service-card">
                <h3>Memorial Services</h3>
                <p>Personalized arrangements honoring your loved one</p>
            </div>
            <div class="service-card">
                <h3>Transport Services</h3>
                <p>Safe and respectful transportation</p>
            </div>

            <div class="service-card">
                <h3>Family Support</h3>
                <p>Compassionate guidance through every step</p>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section id="packages" class="packages">
        <div class="section-header">
            <h2 class="section-title">Service Packages</h2>
            <p class="section-subtitle">Choose a package that best suits your needs</p>
        </div>
        <div class="packages-grid">
            <div class="package-card">
                <div class="package-name">Basic</div>
                <ul class="package-features">
                    <li>Body retrieval</li>
                    <li>Professional embalming</li>
                    <li>Basic casket</li>
                    <li>1-day viewing</li>
                    <li>Basic documentation</li>
                </ul>
                <a href="#" class="package-btn">Inquire Now</a>
            </div>

            <div class="package-card featured">
                <div class="package-name">Standard</div>
                <ul class="package-features">
                    <li>All Basic features</li>
                    <li>2-day viewing</li>
                    <li>Premium casket</li>
                    <li>Transport services</li>
                    <li>Memorial arrangement</li>
                    <li>Full documentation</li>
                </ul>
                <a href="#" class="package-btn">Inquire Now</a>
            </div>

            <div class="package-card">
                <div class="package-name">Premium</div>
                <ul class="package-features">
                    <li>All Standard features</li>
                    <li>Extended viewing</li>
                    <li>Luxury casket selection</li>
                    <li>Priority assistance</li>
                    <li>Family support services</li>
                </ul>
                <a href="#" class="package-btn">Inquire Now</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Peaceful Rest Mortuary</h4>
                <p>Serving families with compassion and dignity since 2005</p>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p>Phone: (123) 456-7890</p>
                <p>Email: info@peacefulrest.com</p>
            </div>
            <div class="footer-section">
                <h4>Hours</h4>
                <p>24/7 Emergency Service</p>
                <p>Office: Mon-Fri 9AM-5PM</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Peaceful Rest Mortuary. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const navMenu = document.getElementById('navMenu');

        mobileToggle.addEventListener('click', () => {
            mobileToggle.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Close menu when clicking on a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileToggle.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>