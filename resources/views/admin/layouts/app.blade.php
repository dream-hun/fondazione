<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>

    <!-- Inter Font -->
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Additional styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900" x-data="sidebarState()" x-init="init()">
    <div class="min-h-screen flex">
        <!-- Mobile Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden"
             style="display: none;"></div>

        <!-- Sidebar -->
        <aside :class="{
                '-translate-x-full lg:translate-x-0': !mobileMenuOpen && !isDesktop,
                'translate-x-0': mobileMenuOpen || isDesktop,
                'w-20': collapsed && isDesktop,
                'w-64': !collapsed || !isDesktop
            }"
            class="fixed inset-y-0 left-0 z-50 bg-white dark:bg-gray-800 shadow-lg transform transition-all duration-300 ease-in-out flex flex-col">
            
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3 overflow-hidden" :class="{ 'justify-center': collapsed && isDesktop }">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Logo" 
                         class="h-10 w-auto transition-opacity duration-300"
                         :class="{ 'opacity-0 w-0': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white whitespace-nowrap transition-opacity duration-300"
                        :class="{ 'opacity-0 w-0 hidden': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                        Admin
                    </h2>
                </div>
                
                <!-- Collapse Toggle Button (Desktop only) -->
                <button @click="toggleCollapse()" 
                        class="hidden lg:flex items-center justify-center w-8 h-8 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 transition-colors"
                        title="Collapse sidebar">
                    <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': collapsed }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-2">
                <div class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative
                              {{ request()->routeIs('admin.dashboard') 
                                  ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200' 
                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-opacity duration-300"
                              :class="{ 'opacity-0 w-0 hidden': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                            Dashboard
                        </span>
                        @if(request()->routeIs('admin.dashboard'))
                        <span x-show="collapsed && isDesktop"
                              class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-600 dark:bg-blue-400 rounded-r"
                              style="display: none;"></span>
                        @endif
                    </a>

                    <!-- Blogs -->
                    <a href="{{ route('admin.blogs.index') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative
                              {{ request()->routeIs('admin.blogs.*') 
                                  ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200' 
                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-opacity duration-300"
                              :class="{ 'opacity-0 w-0 hidden': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                            Blogs
                        </span>
                        @if(request()->routeIs('admin.blogs.*'))
                        <span x-show="collapsed && isDesktop"
                              class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-600 dark:bg-blue-400 rounded-r"
                              style="display: none;"></span>
                        @endif
                    </a>

                    <!-- Projects -->
                    <a href="{{ route('admin.projects.index') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative
                              {{ request()->routeIs('admin.projects.*') 
                                  ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200' 
                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-opacity duration-300"
                              :class="{ 'opacity-0 w-0 hidden': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                            Projects
                        </span>
                        @if(request()->routeIs('admin.projects.*'))
                        <span x-show="collapsed && isDesktop"
                              class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-600 dark:bg-blue-400 rounded-r"
                              style="display: none;"></span>
                        @endif
                    </a>

                    <!-- Notices -->
                    <a href="{{ route('admin.notices.index') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative
                              {{ request()->routeIs('admin.notices.*') 
                                  ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200' 
                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-opacity duration-300"
                              :class="{ 'opacity-0 w-0 hidden': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                            Notices
                        </span>
                        @if(request()->routeIs('admin.notices.*'))
                        <span x-show="collapsed && isDesktop"
                              class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-600 dark:bg-blue-400 rounded-r"
                              style="display: none;"></span>
                        @endif
                    </a>

                    <!-- Reports -->
                    <a href="{{ route('admin.reports.index') }}"
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative
                              {{ request()->routeIs('admin.reports.*')
                                  ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200'
                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-opacity duration-300"
                              :class="{ 'opacity-0 w-0 hidden': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                            Reports
                        </span>
                        @if(request()->routeIs('admin.reports.*'))
                        <span x-show="collapsed && isDesktop"
                              class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-600 dark:bg-blue-400 rounded-r"
                              style="display: none;"></span>
                        @endif
                    </a>

                    <!-- Departments -->
                    <a href="{{ route('admin.departments.index') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative
                              {{ request()->routeIs('admin.departments.*') 
                                  ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200' 
                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-opacity duration-300"
                              :class="{ 'opacity-0 w-0 hidden': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                            Departments
                        </span>
                        @if(request()->routeIs('admin.departments.*'))
                        <span x-show="collapsed && isDesktop"
                              class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-600 dark:bg-blue-400 rounded-r"
                              style="display: none;"></span>
                        @endif
                    </a>

                    <!-- Team Members -->
                    <a href="{{ route('admin.teams.index') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative
                              {{ request()->routeIs('admin.teams.*') 
                                  ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200' 
                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-opacity duration-300"
                              :class="{ 'opacity-0 w-0 hidden': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                            Team Members
                        </span>
                        @if(request()->routeIs('admin.teams.*'))
                        <span x-show="collapsed && isDesktop"
                              class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-600 dark:bg-blue-400 rounded-r"
                              style="display: none;"></span>
                        @endif
                    </a>

                    <!-- Users -->
                    <a href="{{ route('admin.users.index') }}" 
                       class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 relative
                              {{ request()->routeIs('admin.users.*') 
                                  ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200' 
                                  : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        <span class="ml-3 whitespace-nowrap transition-opacity duration-300"
                              :class="{ 'opacity-0 w-0 hidden': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                            Users
                        </span>
                        @if(request()->routeIs('admin.users.*'))
                        <span x-show="collapsed && isDesktop"
                              class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-blue-600 dark:bg-blue-400 rounded-r"
                              style="display: none;"></span>
                        @endif
                    </a>
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3 overflow-hidden" :class="{ 'justify-center': collapsed && isDesktop }">
                    <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-semibold text-blue-600 dark:text-blue-400">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0 transition-opacity duration-300"
                         :class="{ 'opacity-0 w-0 hidden': collapsed && isDesktop, 'opacity-100': !collapsed || !isDesktop }">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 transition-all duration-300"
             :class="{ 'lg:ml-20': collapsed && isDesktop, 'lg:ml-64': !collapsed || !isDesktop }">
            <!-- Top Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 sticky top-0 z-30">
                <div class="flex items-center justify-between px-4 lg:px-6 py-4">
                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Breadcrumbs -->
                    <nav class="flex-1 flex items-center" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            @yield('breadcrumbs')
                        </ol>
                    </nav>

                    <!-- User menu -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                            <span class="hidden md:block">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 z-50 border border-gray-200 dark:border-gray-700"
                             style="display: none;">
                            <a href="{{ route('home') }}" 
                               class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    View Site
                                </div>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-4 lg:p-6 overflow-x-hidden">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Alpine.js Sidebar State -->
    <script>
        function sidebarState() {
            return {
                collapsed: false,
                mobileMenuOpen: false,
                isDesktop: window.innerWidth >= 1024,
                
                init() {
                    // Load saved state from localStorage (only for desktop)
                    const saved = localStorage.getItem('sidebarCollapsed');
                    if (saved !== null && window.innerWidth >= 1024) {
                        this.collapsed = saved === 'true';
                    }
                    
                    // Update desktop state on resize
                    window.addEventListener('resize', () => {
                        const wasDesktop = this.isDesktop;
                        this.isDesktop = window.innerWidth >= 1024;
                        
                        // Close mobile menu if switching to desktop
                        if (!wasDesktop && this.isDesktop) {
                            this.mobileMenuOpen = false;
                        }
                        
                        // Auto-expand sidebar on mobile
                        if (!this.isDesktop) {
                            this.collapsed = false;
                        }
                    });
                },
                
                toggleCollapse() {
                    // Only allow collapse on desktop
                    if (window.innerWidth >= 1024) {
                        this.collapsed = !this.collapsed;
                        // Save state to localStorage
                        localStorage.setItem('sidebarCollapsed', this.collapsed);
                    }
                },
                
                getSidebarClasses() {
                    if (window.innerWidth < 1024) {
                        return this.mobileMenuOpen ? 'translate-x-0' : '-translate-x-full';
                    }
                    return this.collapsed ? 'w-20' : 'w-64';
                }
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
