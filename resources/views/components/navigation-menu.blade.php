<!-- Navigation -->
<nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200/50 shadow-sm">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="relative">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Fondazione Marcegaglia Onlus Rwanda"
                         class="h-12 w-auto transition-transform duration-300 group-hover:scale-105">

                    <div
                        class="hidden h-12 w-12 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                </div>

            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ route('home') }}"
                   class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'text-primary' : 'text-gray-700 hover:text-primary' }}">
                    Home
                </a>
                <a href="{{ route('about-us') }}"
                   class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ request()->routeIs('about-us') ? 'text-primary' : 'text-gray-700 hover:text-primary' }}">
                    About us
                </a>
                <a href="{{ route('projects.index') }}"
                   class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ request()->routeIs('projects.index') ? 'text-primary' : 'text-gray-700 hover:text-primary' }}">
                    Programs
                </a>
                <a href="{{ route('tvet') }}"
                   class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ request()->routeIs('tvet') ? 'text-primary' : 'text-gray-700 hover:text-primary' }}">
                    TVET Training
                </a>

                <a href="{{ route('blog.index') }}"
                   class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ request()->routeIs('blog*') ? 'text-primary' : 'text-gray-700 hover:text-primary' }}">
                    Blog
                </a>
                <a href="{{ route('notices.index') }}"
                   class="px-4 py-2 text-sm font-medium transition-all duration-200 {{ request()->routeIs('notices*') ? 'text-primary' : 'text-gray-700 hover:text-primary' }}">
                    Announcements
                </a>

            </div>

            <!-- CTA Button & Mobile Menu -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('donate') }}"
                   class="hidden md:inline-flex items-center px-6 py-2.5 bg-primary text-white hover:bg-secondary rounded-md font-semibold text-sm transition-all duration-300 shadow-md hover:shadow-xl transform hover:-translate-y-0.5 opacity-85">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Donate Now
                </a>

                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()"
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors"
                        aria-label="Toggle menu">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-gray-200">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}"
                   class="block px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('home') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    Home
                </a>
                <a href="{{ route('about-us') }}"
                   class="block px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('about-us') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    About us
                </a>
                <a href="{{ route('projects.index') }}"
                   class="block px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('projects.index') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    Programs
                </a>
                <a href="{{ route('tvet') }}"
                   class="block px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('tvet') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    TVET Training
                </a>
                <a href="{{ route('blog.index') }}"
                   class="block px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('blog*') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    Blog
                </a>
                <a href="{{ route('notices.index') }}"
                   class="block px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('notices*') ? 'bg-primary/10 text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                    Announcements
                </a>
                <a href="{{ route('donate') }}"
                   class="flex items-center justify-center px-6 py-3 bg-primary text-white hover:bg-secondary rounded-lg font-semibold text-sm transition-all duration-300 shadow-md">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Donate Now
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const button = document.querySelector('[aria-label="Toggle menu"]');
        const icon = button.querySelector('svg');

        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            menu.classList.add('animate-fade-in-down');
            // Change to close icon
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        } else {
            menu.classList.add('hidden');
            menu.classList.remove('animate-fade-in-down');
            // Change back to menu icon
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
        }
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function (event) {
        const menu = document.getElementById('mobile-menu');
        const button = document.querySelector('[aria-label="Toggle menu"]');

        if (!menu.contains(event.target) && !button.contains(event.target)) {
            if (!menu.classList.contains('hidden')) {
                toggleMobileMenu();
            }
        }
    });
</script>
