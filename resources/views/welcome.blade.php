<!-- UI trang chu -->

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
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
            overflow-x: hidden;
        }

        /* Header Styles với hiệu ứng gradient động */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            color: white;
            position: relative;
            overflow: hidden;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Particles background */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: particleFloat 20s infinite;
        }

        @keyframes particleFloat {

            0%,
            100% {
                transform: translateY(0) translateX(0) scale(1);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) translateX(100px) scale(0.5);
                opacity: 0;
            }
        }

        .top-bar {
            background: rgba(0, 0, 0, 0.2);
            padding: 12px 0;
            font-size: 14px;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
            gap: 25px;
            animation: fadeInDown 1s ease;
        }

        .contact-info span {
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.3s ease;
        }

        .contact-info span:hover {
            transform: translateY(-2px);
        }

        .auth-links {
            animation: fadeInDown 1s ease 0.2s both;
        }

        .auth-links a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            padding: 8px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .auth-links a:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Navigation với hiệu ứng glassmorphism */
        .navbar {
            padding: 20px 0;
            position: relative;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(102, 126, 234, 0.9);
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
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
            font-size: 28px;
            font-weight: bold;
            color: white;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            animation: bounceIn 1s ease;
        }

        .logo:hover {
            transform: scale(1.1) rotate(-5deg);
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.8);
        }

        .logo::before {
            content: '';
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #ff6b9d 0%, #ffc371 100%);
            border-radius: 50%;
            margin-right: 12px;
            animation: pulse 2s ease infinite, rotate 10s linear infinite;
            box-shadow: 0 0 20px rgba(255, 107, 157, 0.6);
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 5px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            padding: 12px 20px;
            position: relative;
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .nav-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-3px);
        }

        .nav-menu a::before {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 50%;
            transform: translateX(-50%) scaleX(0);
            width: 60%;
            height: 3px;
            background: linear-gradient(90deg, #ff6b9d, #ffc371);
            border-radius: 2px;
            transition: transform 0.3s ease;
        }

        .nav-menu a:hover::before {
            transform: translateX(-50%) scaleX(1);
        }

        .search-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 18px;
            cursor: pointer;
            padding: 12px;
            border-radius: 50%;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .search-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg) scale(1.1);
            box-shadow: 0 5px 20px rgba(255, 255, 255, 0.3);
        }

        .hamburger {
            display: none;
            font-size: 24px;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
        }

        /* Hero Section với hiệu ứng 3D */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.2)),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:%23667eea;stop-opacity:0.3"/><stop offset="100%" style="stop-color:%23764ba2;stop-opacity:0.3"/></linearGradient></defs><rect fill="url(%23grad1)" width="100%" height="100%"/><circle fill="%23ffffff" cx="200" cy="150" r="120" opacity="0.05"/><circle fill="%23ffffff" cx="1000" cy="400" r="180" opacity="0.05"/><circle fill="%23ffffff" cx="600" cy="300" r="100" opacity="0.05"/></svg>');
            background-size: cover;
            background-position: center;
            padding: 120px 0;
            text-align: center;
            position: relative;
            min-height: 65vh;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 1000px;
        }

        .hero-content {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
            transform-style: preserve-3d;
            animation: fadeInScale 1.2s ease;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8) translateZ(-100px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateZ(0);
            }
        }

        .hero h1 {
            font-size: 3.5em;
            margin-bottom: 25px;
            color: white;
            font-weight: 700;
            text-shadow: 0 5px 30px rgba(0, 0, 0, 0.5);
            animation: textGlow 3s ease-in-out infinite;
            letter-spacing: 2px;
        }

        @keyframes textGlow {

            0%,
            100% {
                text-shadow: 0 5px 30px rgba(0, 0, 0, 0.5),
                    0 0 20px rgba(255, 255, 255, 0.3);
            }

            50% {
                text-shadow: 0 5px 30px rgba(0, 0, 0, 0.5),
                    0 0 40px rgba(255, 255, 255, 0.6);
            }
        }

        .hero-subtitle {
            font-size: 1.2em;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 40px;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: 300;
            animation: fadeInUp 1s ease 0.3s both;
        }

        .hero-logo {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            margin: 40px auto;
            border-radius: 25px;
            position: relative;
            animation: float3D 3s ease-in-out infinite;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4),
                0 0 0 5px rgba(255, 255, 255, 0.1),
                inset 0 0 30px rgba(255, 255, 255, 0.2);
            transform-style: preserve-3d;
        }

        @keyframes float3D {

            0%,
            100% {
                transform: translateY(0) rotateX(0deg) rotateY(0deg);
            }

            25% {
                transform: translateY(-15px) rotateX(5deg) rotateY(5deg);
            }

            50% {
                transform: translateY(0) rotateX(0deg) rotateY(10deg);
            }

            75% {
                transform: translateY(-15px) rotateX(-5deg) rotateY(5deg);
            }
        }

        .hero-logo::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(45deg);
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: logoSpin 4s linear infinite;
        }

        @keyframes logoSpin {
            from {
                transform: translate(-50%, -50%) rotate(45deg);
            }

            to {
                transform: translate(-50%, -50%) rotate(405deg);
            }
        }

        .hero-logo:hover {
            transform: scale(1.15) rotateY(180deg);
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        /* Wave decoration với gradient - Cập nhật responsive */
        .wave-decoration {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 80px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path d="M0,60 Q300,0 600,60 T1200,60 V120 H0 Z" fill="white" opacity="0.9"/><path d="M0,80 Q300,30 600,80 T1200,80 V120 H0 Z" fill="white"/></svg>');
            background-repeat: repeat-x;
            background-size: auto 100%;
            animation: waveMove 10s linear infinite;
        }

        @keyframes waveMove {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: -1200px 0;
            }
        }

        /* Floating elements với nhiều màu */
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
            border-radius: 50%;
            animation: floatComplex 8s ease-in-out infinite;
            filter: blur(2px);
        }

        .floating-element:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 15%;
            left: 8%;
            background: radial-gradient(circle, rgba(255, 107, 157, 0.3), transparent);
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 55%;
            right: 12%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.3), transparent);
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 80px;
            height: 80px;
            top: 75%;
            left: 65%;
            background: radial-gradient(circle, rgba(255, 195, 113, 0.3), transparent);
            animation-delay: 4s;
        }

        .floating-element:nth-child(4) {
            width: 120px;
            height: 120px;
            top: 30%;
            right: 25%;
            background: radial-gradient(circle, rgba(240, 147, 251, 0.3), transparent);
            animation-delay: 1s;
        }

        @keyframes floatComplex {

            0%,
            100% {
                transform: translate(0, 0) rotate(0deg) scale(1);
            }

            25% {
                transform: translate(20px, -30px) rotate(90deg) scale(1.1);
            }

            50% {
                transform: translate(-20px, 20px) rotate(180deg) scale(0.9);
            }

            75% {
                transform: translate(30px, -10px) rotate(270deg) scale(1.05);
            }
        }

        /* Footer với gradient và animations */
        .footer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 50px 0 20px;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.8), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            to {
                left: 100%;
            }
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
        }

        .footer-column {
            flex: 1;
            min-width: 250px;
            opacity: 0;
            animation: slideInUp 0.8s ease forwards;
        }

        .footer-column:nth-child(1) {
            animation-delay: 0.1s;
        }

        .footer-column:nth-child(2) {
            animation-delay: 0.3s;
        }

        .footer-column:nth-child(3) {
            animation-delay: 0.5s;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer-column h3 {
            font-size: 20px;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            padding-bottom: 15px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #ff6b9d, #ffc371);
            border-radius: 2px;
            animation: expandLine 2s ease-in-out infinite;
        }

        @keyframes expandLine {

            0%,
            100% {
                width: 50px;
            }

            50% {
                width: 80px;
            }
        }

        .footer-column p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.9;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 12px;
            transform: translateX(0);
            transition: transform 0.3s ease;
        }

        .footer-column ul li:hover {
            transform: translateX(10px);
        }

        .footer-column ul li a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-block;
            position: relative;
        }

        .footer-column ul li a::before {
            content: '→';
            position: absolute;
            left: -20px;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .footer-column ul li a:hover {
            color: #ffc371;
        }

        .footer-column ul li a:hover::before {
            opacity: 1;
            left: -15px;
        }

        .footer-column .contact-info {
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 14px;
        }

        .footer-column .contact-info span {
            transition: transform 0.3s ease;
        }

        .footer-column .contact-info span:hover {
            transform: translateX(5px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 30px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
            animation: fadeIn 1s ease 1s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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
                transform: scale(0.3);
            }

            50% {
                opacity: 1;
                transform: scale(1.05);
            }

            70% {
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
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
                background: rgba(102, 126, 234, 0.98);
                backdrop-filter: blur(20px);
                padding: 20px;
                text-align: center;
                border-radius: 0 0 20px 20px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            }

            .nav-menu.active {
                display: flex;
            }

            .hamburger {
                display: block;
            }

            .hero h1 {
                font-size: 2.2em;
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
                margin-bottom: 30px;
            }

            .footer-column h3::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .wave-decoration {
                height: 60px;
            }
        }

        @media (max-width: 480px) {
            .hero {
                padding: 100px 0;
                min-height: 55vh;
            }

            .hero h1 {
                font-size: 1.9em;
            }

            .hero-logo {
                width: 80px;
                height: 80px;
            }

            .hero-logo::before {
                width: 40px;
                height: 40px;
            }

            .footer-column {
                min-width: 100%;
            }

            .wave-decoration {
                height: 50px;
            }
        }

        /* Scroll to top button */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.5);
            transition: all 0.3s ease;
            z-index: 1000;
            animation: bounceIn 0.5s ease;
        }

        .scroll-top.show {
            display: flex;
        }

        .scroll-top:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.7);
        }

        /* Ripple effect styles */
        .ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: rippleAnim 0.6s linear;
            pointer-events: none;
        }

        @keyframes rippleAnim {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</head>

<body>

    <header class="header">
        <!-- Particles -->
        <div class="particles" id="particles"></div>
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
                    <!-- <a href="{{ route('register') }}">Register</a> -->
                </div>
            </div>
        </div>
        <!-- Navigation -->
        <nav class="navbar">
            <div class="nav-container">
                <a href="{{ route('home') }}" class="logo">N9</a>
                <ul class="nav-menu">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('home') }}">About Us</a></li>
                    <li><a href="{{ route('exam.redirect') }}">Exam</a></li>
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
    <!-- Content spacer để thấy wave -->
    <div style="min-height: 50vh; background: white; padding: 60px 20px; text-align: center;">
        <h2 style="font-size: 2.5em; color: #667eea; margin-bottom: 20px;">Welcome to EduLearn</h2>
        <p style="font-size: 1.1em; color: #666; max-width: 800px; margin: 0 auto; line-height: 1.8;">
            Discover our comprehensive courses and programs designed to enhance your teaching skills.
            Join thousands of educators who have transformed their careers with us.
        </p>
    </div>
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
                    <li><a href="{{ route('exam.redirect') }}">Exam</a></li>
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
    <!-- Scroll to top button -->
    <button class="scroll-top" id="scrollTop">↑</button>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create particles
            const particlesContainer = document.getElementById('particles');
            for (let i = 0; i < 15; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.width = Math.random() * 10 + 5 + 'px';
                particle.style.height = particle.style.width;
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (Math.random() * 10 + 15) + 's';
                particlesContainer.appendChild(particle);
            }
            // Hamburger menu
            const hamburger = document.querySelector('.hamburger');
            const navMenu = document.querySelector('.nav-menu');
            hamburger.addEventListener('click', () => {
                navMenu.classList.toggle('active');
            });
            // Navbar scroll effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 100) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                // Scroll to top button
                const scrollTop = document.getElementById('scrollTop');
                if (window.scrollY > 300) {
                    scrollTop.classList.add('show');
                } else {
                    scrollTop.classList.remove('show');
                }
                // Parallax effect for floating elements (merged from second code)
                const floatingElements = document.querySelectorAll('.floating-element');
                const scrollPosition = window.scrollY;
                floatingElements.forEach((el, index) => {
                    const speed = 0.1 * (index + 1);
                    el.style.transform += ` translateY(${scrollPosition * speed}px)`;
                });
            });
            // Scroll to top functionality
            document.getElementById('scrollTop').addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            // Ripple effect (enhanced with second code's logic)
            document.querySelectorAll('button, .logo, .nav-menu a, .auth-links a').forEach(element => {
                element.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = element.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    element.style.position = 'relative';
                    element.style.overflow = 'hidden';
                    element.appendChild(ripple);
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
            // Smooth scrolling for navigation links (merged from second code)
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
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
        });
    </script>
    @include('partials._snow-effect')
</body>

</html>