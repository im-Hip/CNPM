<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLearn - Excellence in Teaching</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #1e88e5, #0277bd);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .top-bar {
            background: rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            font-size: 14px;
        }

        .top-bar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .contact-info {
            display: flex;
            gap: 20px;
        }

        .contact-info span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .auth-links a {
            color: white;
            text-decoration: none;
            margin-left: 10px;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        /* Navigation */
        .navbar {
            padding: 15px 0;
            position: relative;
            z-index: 10;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            color: white;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo::before {
            content: '';
            width: 30px;
            height: 30px;
            background: linear-gradient(45deg, #ff4757, #3742fa);
            border-radius: 50%;
            margin-right: 10px;
            position: relative;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 20px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 14px;
            padding: 10px 0;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-menu a:hover {
            color: #ffeb3b;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: #ffeb3b;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .nav-menu a:hover::after {
            transform: scaleX(1);
        }

        .search-btn {
            background: none;
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 10px;
            border-radius: 50%;
            transition: background 0.3s ease;
        }

        .search-btn:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Hamburger Menu */
        .hamburger {
            display: none;
            font-size: 24px;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3)),
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><rect fill="%23333" width="100%" height="100%"/><rect fill="%23444" x="0" y="200" width="100%" height="200" opacity="0.5"/><circle fill="%23666" cx="300" cy="150" r="100" opacity="0.3"/><circle fill="%23777" cx="900" cy="400" r="150" opacity="0.2"/></svg>');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            position: relative;
            min-height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
            color: white;
            font-weight: 300;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 1s ease-out;
        }

        .hero-subtitle {
            font-size: 1.1em;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .hero-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1);
            margin: 30px auto;
            border-radius: 15px;
            position: relative;
            animation: bounceIn 1s ease-out 0.5s both;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .hero-logo::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 5px;
        }

        /* Decorative Elements */
        .wave-decoration {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path d="M0,60 Q300,0 600,60 T1200,60 V120 H0 Z" fill="white"/></svg>');
            background-size: cover;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-element {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 80%;
            left: 70%;
            animation-delay: 4s;
        }

        /* Footer Styles */
        .footer {
            background: linear-gradient(135deg, #0277bd, #1e88e5);
            color: white;
            padding: 40px 0;
            position: relative;
            animation: fadeInUp 1s ease-out;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }

        .footer-column:nth-child(1) { animation-delay: 0.2s; }
        .footer-column:nth-child(2) { animation-delay: 0.4s; }
        .footer-column:nth-child(3) { animation-delay: 0.6s; }

        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-column p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.8;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease, transform 0.3s ease;
            display: inline-block;
        }

        .footer-column ul li a:hover {
            color: #ffeb3b;
            transform: scale(1.05);
        }

        .footer-column .contact-info {
            display: flex;
            flex-direction: column;
            gap: 10px;
            font-size: 14px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 20px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                opacity: 0;
                transform: scale(0.3) rotate(0deg);
            }
            50% {
                opacity: 1;
                transform: scale(1.1) rotate(180deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(360deg);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @keyframes parallax {
            0% {
                transform: translateY(0px);
            }
            100% {
                transform: translateY(50px);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: rgba(30, 136, 229, 0.95);
                padding: 20px;
                text-align: center;
            }

            .nav-menu.active {
                display: flex;
            }

            .hamburger {
                display: block;
            }

            .hero h1 {
                font-size: 2em;
            }

            .hero-subtitle {
                font-size: 1em;
            }

            .contact-info {
                display: none;
            }

            .top-bar .container {
                justify-content: center;
            }

            .footer-container {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .footer-column {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 80px 0;
                min-height: 50vh;
            }

            .hero h1 {
                font-size: 1.8em;
            }

            .hero-logo {
                width: 60px;
                height: 60px;
            }

            .hero-logo::before {
                width: 30px;
                height: 30px;
            }

            .footer-column {
                min-width: 100%;
            }
        }

        /* Interactive Effects */
        .hero-logo:hover {
            transform: scale(1.1) rotate(10deg);
            transition: all 0.3s ease;
        }

        .search-btn:active {
            transform: scale(0.95);
        }
    </style>
</head>
<body>
    <header class="header">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="container">
                <div class="contact-info">
                    <span>📅 Mon - Sat / 6:30AM - 5:30PM</span>
                    <span>📍 280 An Dương Vương, Phường Chợ Quán, Tp.Hồ Chí Minh</span>
                    <span>📞 028 3835 2020</span>
                </div>
                <div class="auth-links">
                    <a href="{{ route('login') }}" style="margin-right: 10px;">👤 Login</a>
                    <a href="{{ route('register') }}">Register</a>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="navbar">
            <div class="nav-container">
                <a href="{{ route('home') }}" class="logo">EduLearn</a>
                <ul class="nav-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home') }}">About Us</a></li>
                    <li><a href="{{ route('home') }}">Exam</a></li>
                    <li><a href="{{ route('home') }}">Contact</a></li>
                </ul>
                <button class="search-btn">🔍</button>
                <button class="hamburger">☰</button>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="hero">
            <div class="floating-elements">
                <div class="floating-element"></div>
                <div class="floating-element"></div>
                <div class="floating-element"></div>
            </div>
            
            <div class="hero-content">
                <h1>Learn Excellence in Teaching</h1>
                <div class="hero-subtitle">COURSES / EVENTS / E-LEARNING</div>
                <div class="hero-logo"></div>
            </div>
            
            <div class="wave-decoration"></div>
        </div>
    </header>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-column">
                <h3>About EduLearn</h3>
                <p>EduLearn is dedicated to providing high-quality education and training solutions to empower teachers and learners worldwide. Join us to achieve excellence in teaching.</p>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home') }}">About Us</a></li>
                    <li><a href="{{ route('home') }}">Exam</a></li>
                    <li><a href="{{ route('home') }}">Contact</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact Us</h3>
                <div class="contact-info">
                    <span>📅 Mon - Sat / 6:30AM - 5:30PM</span>
                    <span>📍 280 An Dương Vương, Phường Chợ Quán, Tp.Hồ Chí Minh</span>
                    <span>📞 028 3835 2020</span>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2025 Quản Lý Lịch Học. All rights reserved.
        </div>
    </footer>

    <script>
        // Add smooth scrolling and interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Hamburger menu toggle
            const hamburger = document.querySelector('.hamburger');
            const navMenu = document.querySelector('.nav-menu');
            hamburger.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });

            // Add scroll effect to header
            let lastScrollY = window.scrollY;
            window.addEventListener('scroll', () => {
                const header = document.querySelector('.navbar');
                if (window.scrollY > 100) {
                    header.style.background = 'rgba(30, 136, 229, 0.95)';
                    header.style.backdropFilter = 'blur(10px)';
                } else {
                    header.style.background = 'transparent';
                    header.style.backdropFilter = 'none';
                }
                lastScrollY = window.scrollY;

                // Parallax effect for floating elements
                const floatingElements = document.querySelectorAll('.floating-element');
                const scrollPosition = window.scrollY;
                floatingElements.forEach((el, index) => {
                    const speed = 0.1 * (index + 1);
                    el.style.transform = `translateY(${scrollPosition * speed}px)`;
                });
            });

            // Add click effects to buttons
            document.querySelectorAll('button, .logo').forEach(element => {
                element.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        background: rgba(255, 255, 255, 0.3);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: ripple 0.6s ease-out;
                        pointer-events: none;
                    `;
                    
                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);
                    
                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // Add CSS animation for ripple effect
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>