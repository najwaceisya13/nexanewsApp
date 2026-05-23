<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'NexaNews - Website Berita Terkini')</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Poppins dari Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome untuk Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Warna Brand */
        :root {
            --primary-red: #c1121f;
            --primary-dark: #0f172a;
        }

        /* Navbar Sticky */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Menu aktif */
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link.active {
            color: var(--primary-red);
            font-weight: 600;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            right: 0;
            height: 3px;
            background-color: var(--primary-red);
        }

        /* Breaking News Bar */
        .breaking-news {
            background-color: var(--primary-red);
            color: white;
            padding: 12px 0;
            overflow: hidden;
        }

        .breaking-news-content {
            display: inline-block;
            animation: scroll 20s linear infinite;
            white-space: nowrap;
        }

        @keyframes scroll {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 500px;
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero-content {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
            z-index: 10;
            color: white;
        }

        .hero-badge {
            background-color: var(--primary-red);
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 12px;
            line-height: 1.2;
        }

        .hero-description {
            font-size: 18px;
            line-height: 1.6;
            opacity: 0.95;
        }

        /* Card Berita */
        .news-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .news-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .news-card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background-color: #e5e7eb;
        }

        .news-card-content {
            padding: 16px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .news-category-badge {
            background-color: var(--primary-red);
            color: white;
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
            width: fit-content;
        }

        .news-card-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #1f2937;
            line-height: 1.4;
            flex-grow: 1;
        }

        .news-card-meta {
            font-size: 12px;
            color: #9ca3af;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Button Style */
        .btn-primary {
            background-color: var(--primary-red);
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #a60c1d;
        }

        .btn-outline {
            border: 2px solid var(--primary-red);
            color: var(--primary-red);
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background-color: var(--primary-red);
            color: white;
        }

        /* Sidebar Styling */
        .sidebar-section {
            background-color: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #1f2937;
        }

        .feedback-form {
            background-color: var(--primary-dark);
            color: white;
            border-radius: 12px;
            padding: 24px;
            margin-top: 24px;
        }

        .feedback-form textarea {
            width: 100%;
            padding: 12px;
            border-radius: 6px;
            border: none;
            margin-bottom: 12px;
            font-family: 'Poppins', sans-serif;
            resize: vertical;
            min-height: 100px;
        }

        .feedback-form button {
            width: 100%;
            background-color: var(--primary-red);
            color: white;
            padding: 12px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .feedback-form button:hover {
            background-color: #a60c1d;
        }

        /* Footer */
        .footer {
            background-color: var(--primary-dark);
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }

        .footer-text {
            text-align: center;
            font-size: 14px;
            color: #9ca3af;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 32px;
            }

            .hero-content {
                bottom: 20px;
                left: 20px;
                right: 20px;
            }

            .hero-section {
                height: 300px;
            }
        }

        /* Trending List */
        .trending-item {
            display: flex;
            align-items: center;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e5e7eb;
        }

        .trending-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .trending-number {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary-red);
            min-width: 40px;
            text-align: center;
        }

        .trending-info {
            margin-left: 16px;
            flex-grow: 1;
        }

        .trending-title {
            font-weight: 600;
            color: #1f2937;
            line-height: 1.3;
            font-size: 14px;
        }

        .trending-views {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 4px;
        }

        /* Category Tag */
        .category-tag {
            display: inline-block;
            background-color: #f3f4f6;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            margin-right: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            color: #4b5563;
        }

        .category-tag:hover {
            background-color: var(--primary-red);
            color: white;
        }

        .category-tag.active {
            background-color: var(--primary-red);
            color: white;
        }

        /* Search Bar */
        .search-container {
            position: relative;
        }

        .search-container input {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            background-color: #f3f4f6;
            font-size: 14px;
        }

        .search-container input::placeholder {
            color: #9ca3af;
        }

        .search-container button {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--primary-red);
            font-size: 16px;
        }

        /* Alert/Toast */
        .alert {
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 16px;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #7f1d1d;
            border-left: 4px solid #ef4444;
        }

        /* Loading Animation */
        .spinner {
            border: 3px solid #f3f4f6;
            border-top: 3px solid var(--primary-red);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    @yield('additional_css')
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <div class="text-2xl font-bold" style="color: var(--primary-red);">
                            Nexa<span class="text-gray-900">News</span>
                        </div>
                    </a>
                </div>

                <!-- Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        Home
                    </a>
                    <a href="{{ route('category.show', 'makanan') }}" class="nav-link">
                        Makanan
                    </a>
                    <a href="{{ route('category.show', 'teknologi') }}" class="nav-link">
                        Teknologi
                    </a>
                    <a href="{{ route('category.show', 'pendidikan') }}" class="nav-link">
                        Pendidikan
                    </a>
                </div>

                <!-- Right Side Icons -->
                <div class="flex items-center space-x-4">
                    <!-- Search Icon -->
                    <button class="text-gray-600 hover:text-gray-900" onclick="toggleSearchModal()">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Auth Links -->
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary">
                            Register
                        </a>
                    @else
                        <div class="relative dropdown-menu">
                            <button class="flex items-center space-x-2 text-gray-600 hover:text-gray-900" onclick="toggleDropdown()">
                                <i class="fas fa-user-circle text-xl"></i>
                                <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                            </button>

                            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Admin
                                    </a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profile
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="px-4 py-2">
                                    @csrf
                                    <button type="submit" class="w-full text-left hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Breaking News -->
    <div class="breaking-news">
        <div class="max-w-7xl mx-auto px-4">
            <span style="font-weight: 600; font-size: 12px; margin-right: 16px;">🔴 BERITA TERKINI</span>
            <span class="breaking-news-content">
                Berita penting hari ini | Terus update dengan kami | Dapatkan informasi terbaru setiap saat
            </span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="min-h-screen">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">
                        Nexa<span class="text-red-600">News</span>
                    </h3>
                    <p class="text-gray-400 text-sm">
                        Platform berita terpercaya untuk informasi terkini seputar Makanan, Teknologi, dan Pendidikan.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Menu Utama</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                        <li><a href="{{ route('category.show', 'makanan') }}" class="hover:text-white">Makanan</a></li>
                        <li><a href="{{ route('category.show', 'teknologi') }}" class="hover:text-white">Teknologi</a></li>
                        <li><a href="{{ route('category.show', 'pendidikan') }}" class="hover:text-white">Pendidikan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li>Email: info@nexanews.com</li>
                        <li>Telepon: +62-800-0000</li>
                        <li>Sosial Media: @nexanews</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8">
                <div class="footer-text">
                    <p>&copy; 2026 NexaNews. All rights reserved. | Privacy Policy | Terms of Service</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Search Modal -->
    <div id="searchModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-center pt-20">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl shadow-lg">
            <form action="{{ route('search') }}" method="GET" class="flex gap-2">
                <input
                    type="text"
                    name="q"
                    placeholder="Cari berita..."
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-600"
                    autofocus
                    required
                >
                <button type="submit" class="btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <button onclick="toggleSearchModal()" class="mt-4 w-full text-center text-gray-500 hover:text-gray-700">
                Tutup (ESC)
            </button>
        </div>
    </div>

    <script>
        // Toggle Search Modal
        function toggleSearchModal() {
            const modal = document.getElementById('searchModal');
            modal.classList.toggle('hidden');
        }

        // Close search modal on ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.getElementById('searchModal').classList.add('hidden');
            }
        });

        // Toggle Dropdown Menu
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            if (!event.target.closest('.dropdown-menu')) {
                dropdown?.classList.add('hidden');
            }
        });

        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000);
            });
        });
    </script>

    @yield('additional_js')
</body>
</html>
