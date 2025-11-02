<x-app-layout>
    @section('title')
    Home
    @endsection
    @section('description')
    Fondazione Marcegaglia Onlus Rwanda(FMO) is a non-profit organization that empowers women and communities in Rwanda.
    @endsection
    <!-- Hero Section -->
    <section
        class="relative bg-gradient-to-br from-red-primary via-red-600 to-red-800 text-white overflow-hidden opacity-85">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 20px 20px;">
            </div>
        </div>

        <div class="container mx-auto max-w-7xl px-4 py-20 lg:py-32 relative">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div class="space-y-8">
                    <div class="space-y-4">
                        <div
                            class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium">
                            <span class="w-2 h-2 bg-ray-500 rounded-full mr-2"></span>
                            Making a difference since 2010
                        </div>
                        <h1 class="text-3xl md:text-4xl lg:text-6xl font-bold leading-tight">
                            Empowering women and communities in Rwanda.

                        </h1>
                        <p class="text-xl text-white leading-relaxed max-w-2xl">
                            Join us in creating sustainable change through education, healthcare, and community
                            development across Rwanda and beyond.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('donate') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gray-500 text-white hover:bg-gray-600 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            Support our cause
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                        <a href="{{ route('projects.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white border-2 border-white/30 hover:bg-white/10 rounded-xl font-semibold transition-all duration-300">
                            Our Projects
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8 pt-8 border-t border-white/20">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gray-400">50K+</div>
                            <div class="text-sm text-red-100">Lives Impacted</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gray-400">120+</div>
                            <div class="text-sm text-red-100">Projects Completed</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-gray-400">25+</div>
                            <div class="text-sm text-red-100">Communities Served</div>
                        </div>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative">
                    <div class="relative aspect-square max-w-lg mx-auto">
                        <!-- Floating Elements -->
                        <div
                            class="absolute -top-4 -left-4 w-20 h-20 bg-gray-400 rounded-full opacity-20 animate-pulse">
                        </div>
                        <div
                            class="absolute -bottom-4 -right-4 w-16 h-16 bg-white rounded-full opacity-20 animate-pulse delay-1000">
                        </div>

                        <img src="{{ asset('images/_DSC8049.jpg') }}" alt="Community volunteers working together"
                            class="w-full h-full object-cover rounded-3xl shadow-2xl">

                        <!-- Overlay Card -->
                        <div
                            class="absolute bottom-6 left-6 right-6 bg-white/95 backdrop-blur-sm rounded-2xl p-4 shadow-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-primary" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Holiday Camp</div>
                                    <div class="text-sm text-gray-600">More than 200 youth attended</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="bg-white py-12 overflow-hidden">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="text-center mb-8">
                <p class="text-gray-600 font-medium">Trusted by Leading Organizations</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-2">Our Partners</h3>
            </div>

            <!-- Partners Carousel -->
            <div class="relative">
                <div class="partners-carousel flex items-center gap-8 animate-scroll">
                    <!-- First set of partners -->
                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/IBTC.jpeg') }}" alt="IBTC"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/LAPALISSE-NYAMATA-HOTEL.png') }}"
                            alt="Lapalisse Nyamata Hotel" class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/maison-shalom.png') }}" alt="Maison Shalom"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/minaloc.png') }}" alt="MINALOC"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/Miracle Corners Rwanda.jpeg') }}"
                            alt="Miracle Corners Rwanda" class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/NCDA.png') }}" alt="NCDA"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/NUDOR.jpg') }}" alt="NUDOR"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/psf-logo.png') }}" alt="PSF"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/RHIH.png') }}" alt="RHIH"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/RNIT.png') }}" alt="RNIT"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/RTB.webp') }}" alt="RTB"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/utb.png') }}" alt="UTB"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <!-- Duplicate set for seamless loop -->
                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/IBTC.jpeg') }}" alt="IBTC"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/LAPALISSE-NYAMATA-HOTEL.png') }}"
                            alt="Lapalisse Nyamata Hotel" class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/maison-shalom.png') }}" alt="Maison Shalom"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/minaloc.png') }}" alt="MINALOC"
                            class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/Miracle Corners Rwanda.jpeg') }}"
                            alt="Miracle Corners Rwanda" class="max-h-full max-w-full object-contain">
                    </div>

                    <div class="flex items-center justify-center h-32 w-52 flex-shrink-0 p-4">
                        <img src="{{ asset('images/partners/NCDA.png') }}" alt="NCDA"
                            class="max-h-full max-w-full object-contain">
                    </div>
                </div>
            </div>
        </div>

        <!-- Custom CSS for carousel animation -->
        <style>
            @keyframes scroll {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            .animate-scroll {
                animation: scroll 30s linear infinite;
            }

            .partners-carousel:hover {
                animation-play-state: paused;
            }
        </style>
    </section>


    <!-- Mission, Vision & Impact -->
    <section class="py-20 bg-white">
        <div class="container mx-auto max-w-7xl px-4">
            <!-- Section Header -->
            <div class="text-justify-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    About <span class="text-red-primary">Our Organization</span>
                </h2>
                <p class="text-md text-gray-600 mx-auto leading-relaxed">
                    Marcegaglia Foundation is the foundation of participation, set up in 2010 by the Marcegaglia family
                    of entrepreneurs: Steno Marcegaglia, his wife Mira, his sons Emma and Antonio with Carolina Toso
                    Marcegaglia, who was entrusted with the presidency.
                    Status
                    The Foundation reflects the spirit that animated the Gazoldo degli Ippoliti steel processing company
                    more than 50 years ago and has now become a Group with 50 factories in the world: entrepreneurship
                    excellence has always been accompanied with discretion and sensitivity to many social instances.
                </p>
            </div>

            <!-- Mission & Vision Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
                <!-- Mission Card -->
                <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-red-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Our Mission</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Supporting women, a driver of growth and development for their families and communities.
                    </p>
                </div>

                <!-- Vision Card -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Our Vision</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Building a world where social inequalities are increasingly reduced and the role of women is
                        valued.
                    </p>
                </div>
                <!-- Intervention Card -->
                <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gray-300 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Intervention</h3>
                    </div>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        Projects of solidarity and cooperation in the field of social and health care in Italy and
                        abroad.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs -->
    <section class="bg-white">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Our <span class="text-red-primary">Programs</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprehensive initiatives designed to address the root causes of poverty and create sustainable
                    development.
                </p>
            </div>

            <div
                class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($projects as $project)
                    <article class="flex flex-col items-start justify-between">
                        <div class="relative w-full">
                            <img src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80"
                                alt="Blog post image"
                                class="aspect-video w-full rounded-2xl bg-gray-800 object-cover sm:aspect-[2/1] lg:aspect-[3/2]" />
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-white/10"></div>
                        </div>
                        <div class="flex max-w-xl grow flex-col justify-between">
                            
                            <div class="group relative grow">
                                <h3 class="mt-3 text-lg font-semibold text-gray-800 group-hover:text-gray-900">
                                    <a href="{{ route('projects.show', $project->slug) }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $project->title }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm text-gray-400">{{$project->description}}</p>
                            </div>
                            
                        </div>
                    </article>
                @endforeach
            </div>


        </div>
    </section>
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-4xl font-semibold tracking-tight text-balance text-gray-800 sm:text-5xl">From the
                    blog</h2>
                <p class="mt-2 text-lg/8 text-gray-400">Our latest stories are here.</p>
            </div>
            <div
                class="mx-auto mt-16 grid max-w-2xl auto-rows-fr grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($posts as $post)
                    <article
                        class="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl bg-gray-800 px-8 pt-80 pb-8 sm:pt-48 lg:pt-80">
                        <img src="/images/post-1.jpg" alt=""
                            class="absolute inset-0 -z-10 size-full object-cover" />
                        <div class="absolute inset-0 -z-10 bg-linear-to-t from-black/80 via-black/40"></div>
                        <div class="absolute inset-0 -z-10 rounded-2xl inset-ring inset-ring-white/10"></div>
                        <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm/6 text-gray-300">
                            <time datetime="{{ $post->created_at }}" class="mr-8">{{ $post->created_at }}</time>
                            <div class="-ml-4 flex items-center gap-x-4">
                                <svg viewBox="0 0 2 2" class="-ml-0.5 size-0.5 flex-none fill-gray-300/50">
                                    <circle cx="1" cy="1" r="1" />
                                </svg>
                                <div class="flex gap-x-2.5">
                                    <img src="/images/author-1.jpg" alt=""
                                        class="size-6 flex-none rounded-full bg-gray-800/10" />
                                    {{ $post->author_name }}
                                </div>
                            </div>
                        </div>
                        <h3 class="mt-3 text-lg/6 font-semibold text-white">
                            <a href="{{ route('blog.show', $post->slug) }}">
                                <span class="absolute inset-0"></span>
                                {{ $post->title }}
                            </a>
                        </h3>
                    </article>
                @endforeach


            </div>
        </div>
    </div>

    <!-- Latest Notices -->
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-4xl font-semibold tracking-tight text-balance text-gray-800 sm:text-5xl">Latest
                    Announcements</h2>
                <p class="mt-2 text-lg/8 text-gray-400">Get the latest communication from our organization.</p>
            </div>

            <div
                class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                @foreach ($notices as $notice)
                    <article class="flex max-w-xl flex-col items-start justify-between">
                        <div class="flex items-center gap-x-4 text-xs">
                            <time datetime="{{ $notice->formatted_date }}"
                                class="text-gray-500">{{ $notice->formatted_date }}</time>
                        </div>
                        <div class="group relative grow">
                            <h3 class="mt-3 text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                                <a href="{{ route('notices.show', $notice->slug) }}">
                                    <span class="absolute inset-0"></span>
                                    {{ $notice->title }}
                                </a>
                            </h3>
                            <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">
                                {!! Str::limit($notice->body, 120) !!}
                            </p>
                        </div>

                    </article>
                @endforeach

            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-r from-red-primary to-red-700 text-white">
        <div class="container mx-auto px-4 text-center">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Ready to Make a Difference?
                </h2>
                <p class="text-xl text-red-100 mb-8 leading-relaxed">
                    Join thousands of supporters who are creating positive change in communities across Rwanda.
                    Every contribution, no matter the size, helps build a brighter future.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a href="{{ route('donate') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-amber-500 text-white hover:bg-amber-600 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Donate Now
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </a>
                    <a href="{{ route('about-us') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white border-2 border-white/30 hover:bg-white/10 rounded-xl font-semibold transition-all duration-300">
                        Become a Volunteer
                    </a>
                </div>

                <!-- Contact Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>

                        </div>
                        <h3 class="font-semibold mb-1">Email Us</h3>
                        <p class="text-red-100">info@fmorwanda.org</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-1">Call Us</h3>
                        <p class="text-red-100">+250 788 123 456</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-1">Location</h3>
                        <p class="text-red-100">Kimaranzara Cell, Rilima Sector, Bugesera District, Eastern Rwanda as
                            FMO Rwanda country office via Giovanni della Casa, 12 – 20151 Milano, Italy</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
