<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - NexaNews')</title>
    
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

        :root {
            --primary-red: #c1121f;
            --primary-dark: #0f172a;
        }

        .admin-sidebar {
            background-color: var(--primary-dark);
            transition: all 0.3s ease;
        }

        .nav-admin-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #94a3b8;
            font-weight: 500;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .nav-admin-link:hover {
            color: white;
            background-color: #1e293b;
        }

        .nav-admin-link.active {
            color: white;
            background-color: #1e293b;
            border-left-color: var(--primary-red);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
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
    </style>
    @yield('additional_css')
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Mobile Sidebar Backdrop -->
    <div id="sidebarBackdrop" class="fixed inset-0 z-40 bg-black/40 hidden lg:hidden" onclick="toggleMobileSidebar()"></div>

    <!-- Sidebar -->
    <aside id="adminSidebar" class="admin-sidebar w-64 text-white flex-shrink-0 flex flex-col fixed inset-y-0 left-0 z-50 transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-300">
        <!-- Brand Header -->
        <div class="h-16 flex items-center px-6 border-b border-slate-800">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                <span class="text-2xl font-extrabold tracking-wider" style="color: var(--primary-red);">Nexa<span class="text-white">News</span></span>
                <span class="text-[10px] bg-red-600 text-white font-semibold px-2 py-0.5 rounded-full uppercase">Admin</span>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 py-6 overflow-y-auto space-y-1">
            <div class="px-6 mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Navigasi Utama</div>
            
            <a href="{{ route('admin.dashboard') }}" class="nav-admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt w-6 text-lg mr-3"></i>Dashboard
            </a>
            
            <a href="{{ route('articles.index') }}" class="nav-admin-link {{ request()->routeIs('articles.*') ? 'active' : '' }}">
                <i class="fas fa-newspaper w-6 text-lg mr-3"></i>Kelola Artikel
            </a>
            
            <a href="{{ route('admin.comments') }}" class="nav-admin-link {{ request()->routeIs('admin.comments') ? 'active' : '' }}">
                <i class="fas fa-comments w-6 text-lg mr-3"></i>Moderasi Komentar
                @php
                    $pendingCount = \App\Models\Comment::pending()->count();
                @endphp
                @if($pendingCount > 0)
                <span class="ml-auto bg-yellow-500 text-slate-900 text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $pendingCount }}
                </span>
                @endif
            </a>

            <a href="{{ route('admin.feedback') }}" class="nav-admin-link {{ request()->routeIs('admin.feedback') ? 'active' : '' }}">
                <i class="fas fa-comment-dots w-6 text-lg mr-3"></i>Umpan Balik
                @php
                    $feedbackCount = \App\Models\Feedback::count();
                @endphp
                @if($feedbackCount > 0)
                <span class="ml-auto bg-blue-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                    {{ $feedbackCount }}
                </span>
                @endif
            </a>
            

            <!-- Quick Actions Panel in Sidebar -->
            <div class="pt-6 mt-6 border-t border-slate-800">
                <div class="px-6 mb-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Quick Actions</div>
                <div class="px-4 space-y-2">
                    <a href="{{ route('articles.create') }}" class="flex items-center justify-center space-x-2 py-2.5 px-4 bg-red-700 hover:bg-red-800 text-white text-xs font-bold rounded-lg transition shadow-md w-full">
                        <i class="fas fa-plus"></i>
                        <span>TULIS ARTIKEL</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- User Footer info -->
        <div class="p-4 border-t border-slate-800 bg-slate-950 flex items-center space-x-3">
            <div class="flex-shrink-0">
                <i class="fas fa-user-shield text-2xl text-red-500"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-400 truncate">Administrator</p>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Top Header -->
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-30">
            <!-- Sidebar toggle button for mobile -->
            <div class="flex items-center">
                <button onclick="toggleMobileSidebar()" class="text-slate-600 hover:text-slate-900 focus:outline-none lg:hidden mr-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-lg font-bold text-slate-800 hidden sm:block">Panel Kontrol Admin</h2>
            </div>

            <!-- Right utilities -->
            <div class="flex items-center space-x-6">
                <!-- Return to website link -->
                <a href="{{ route('home') }}" class="text-slate-600 hover:text-slate-900 flex items-center space-x-2 text-sm font-semibold">
                    <i class="fas fa-globe text-base"></i>
                    <span class="hidden md:inline">Lihat Website</span>
                </a>

                <!-- User Dropdown Menu -->
                <div class="relative admin-dropdown-menu">
                    <button class="flex items-center space-x-2 text-slate-700 hover:text-slate-900 focus:outline-none" onclick="toggleAdminDropdown()">
                        <i class="fas fa-user-circle text-2xl" style="color: var(--primary-red);"></i>
                        <span class="font-medium text-sm hidden sm:inline">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down text-xs text-slate-400"></i>
                    </button>

                    <div id="adminDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 border">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2 text-slate-400"></i>Profile Saya
                        </a>
                        <div class="border-t my-1"></div>
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Body -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 bg-slate-50">
            @yield('content')
        </main>
    </div>

    <!-- Layout Scripts -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }

        function toggleAdminDropdown() {
            const dropdown = document.getElementById('adminDropdownMenu');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('adminDropdownMenu');
            if (!event.target.closest('.admin-dropdown-menu')) {
                dropdown?.classList.add('hidden');
            }
        });

        // Auto-hide alert messages
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
