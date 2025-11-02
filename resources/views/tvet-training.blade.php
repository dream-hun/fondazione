<x-app-layout>
    @section('title')Marcegaglia Vocational Training Center
    @endsection
    @section('description')The Marcegaglia Vocational Training Center (MVTC) is a technical school by Fondazione Marcegaglia Onlus (FMO)
        aimed at empowering young individuals and reducing school dropout rates in Rwanda.
    @endsection
    <!-- Hero Section -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/mvtc/Marcegaglia Vocational Training center.avif') }}"
             alt="TVET Training Center"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>

        <div class="container mx-auto max-w-7xl px-4 relative z-10">
            <div class="max-w-4xl mx-auto">
                <div class="inline-block mb-6">
                    <span class="text-red-primary font-bold text-2xl tracking-wider">MARCEGAGLIA VOCATIONAL TRAINING CENTER</span>
                </div>
                <h1 class="text-5xl md:text-6xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                    Empowering Youth Through Technical Skills
                </h1>
                <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                    Located in Rilima, Bugesera District, MVTC provides quality vocational training accredited by Rwanda
                    TVET Board, equipping young people with essential skills for self-employment and national
                    development.
                </p>
            </div>
        </div>
    </section>

    <!-- Introduction Section - Flipped Design -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Image Side -->
                <div class="order-2 md:order-1">
                    <div class="relative">
                        <div class="aspect-[4/3] rounded-2xl overflow-hidden shadow-2xl">
                            <img src="{{ asset('images/mvtc/MVTC.avif') }}"
                                 alt="MVTC Students"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-red-primary/10 rounded-2xl -z-10"></div>
                    </div>
                </div>

                <!-- Content Side -->
                <div class="order-1 md:order-2">
                    <span class="text-red-primary font-bold text-sm tracking-wider uppercase">About MVTC</span>
                    <h2 class="text-4xl font-bold text-gray-900 mt-4 mb-6">
                        Reducing School Dropout & Empowering Youth
                    </h2>
                    <div class="space-y-4 text-gray-700 leading-relaxed">
                        <p>
                            The Marcegaglia Vocational Training Center (MVTC) is a technical school by Fondazione
                            Marcegaglia Onlus (FMO) aimed at empowering young individuals and reducing school dropout
                            rates in Rwanda.
                        </p>
                        <p>
                            Located in the Rilima area of the Bugesera district, MVTC offers training in five essential
                            trades that contribute to self-employment and the country's development, aligning with
                            Rwanda's Vision 2020 and 2050 goals.
                        </p>
                        <p>
                            The MVTC program is part of FMO's Technical and Vocational Educational Training (TVET)
                            initiative, which equips youth from various parts of Bugesera with essential skills. The
                            school is accredited by Rwanda TVET Board (RTB) to provide short courses and certification.
                        </p>
                    </div>

                    <!-- Accreditation Badge -->
                    <div class="mt-8 inline-flex items-center gap-3 bg-white px-6 py-4 rounded-xl shadow-md">
                        <div class="w-12 h-12 bg-red-primary/10 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">RTB Accredited</div>
                            <div class="text-sm text-gray-600">Rwanda TVET Board Certified</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Departments Section -->
    <section class="py-24 bg-white">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Five <span class="text-red-primary">Essential Trades</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    MVTC offers training in five specialized trades, providing youth with practical skills for
                    self-employment and contributing to Rwanda's development goals.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($departments as $department)
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <!-- Department Header with Gradient -->
                        <div class="h-48 relative overflow-hidden
                            @if($department['color'] === 'red') bg-gradient-to-br from-red-primary to-red-700
                            @elseif($department['color'] === 'gray') bg-gradient-to-br from-gray-secondary to-gray-700
                            @elseif($department['color'] === 'amber') bg-gradient-to-br from-amber-500 to-amber-600
                            @elseif($department['color'] === 'blue') bg-gradient-to-br from-blue-500 to-blue-600
                            @elseif($department['color'] === 'green') bg-gradient-to-br from-green-600 to-green-700
                            @elseif($department['color'] === 'rose') bg-gradient-to-br from-rose-500 to-rose-600
                            @endif">
                            <div class="absolute inset-0 bg-black/10"></div>
                            <div class="absolute bottom-4 left-4">
                                <div
                                    class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                    @if($department['icon'] === 'welding')
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    @elseif($department['icon'] === 'scissors')
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"></path>
                                        </svg>
                                    @elseif($department['icon'] === 'needle')
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                        </svg>
                                    @elseif($department['icon'] === 'camera')
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    @elseif($department['icon'] === 'brick')
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Department Content -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $department['name'] }}</h3>
                            <p class="text-gray-600 mb-4 leading-relaxed">{{ $department['description'] }}</p>

                            <!-- Duration and Certification Badges -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $department['duration'] }}
                                </span>
                                <span
                                    class="inline-flex items-center px-3 py-1 bg-red-primary/10 text-red-primary text-sm rounded-full font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                    </svg>
                                    {{ $department['certification'] }}
                                </span>
                            </div>

                            <!-- Features List -->
                            <div class="space-y-2">
                                <p class="text-sm font-semibold text-gray-900 mb-2">Key Features:</p>
                                <ul class="space-y-1">
                                    @foreach($department['features'] as $feature)
                                        <li class="flex items-start text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-red-primary mr-2 mt-0.5 flex-shrink-0" fill="none"
                                                 stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Impact & Statistics Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Our <span class="text-red-primary">Impact</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Transforming lives through quality vocational education and creating pathways to sustainable
                    employment.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach($stats as $stat)
                    <div class="text-center">
                        <div class="text-5xl font-bold text-red-primary mb-2">{{ $stat['value'] }}</div>
                        <div class="text-gray-600 uppercase text-sm tracking-wide">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Facilities Gallery Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Our <span class="text-red-primary">Training Facilities</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    State-of-the-art workshops and classrooms equipped with modern tools and equipment for hands-on
                    learning.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div class="aspect-square rounded-xl overflow-hidden group">
                    <img src="{{ asset('images/_DSC8049.jpg') }}"
                         alt="Training facility"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden group">
                    <img src="{{ asset('images/_DSC8103.jpg') }}"
                         alt="Students in training"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden group">
                    <img src="{{ asset('images/_DSC8049.jpg') }}"
                         alt="Workshop equipment"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden group">
                    <img src="{{ asset('images/_DSC8103.jpg') }}"
                         alt="Practical training"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden group">
                    <img src="{{ asset('images/_DSC8049.jpg') }}"
                         alt="Classroom setting"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden group">
                    <img src="{{ asset('images/_DSC8103.jpg') }}"
                         alt="Graduation ceremony"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden group">
                    <img src="{{ asset('images/_DSC8049.jpg') }}"
                         alt="Training session"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square rounded-xl overflow-hidden group">
                    <img src="{{ asset('images/_DSC8103.jpg') }}"
                         alt="Student achievement"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-gradient-to-r from-red-primary to-red-700 text-white opacity-85">
        <div class="container mx-auto max-w-7xl px-4 text-center">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Transform Your Future with MVTC
                </h2>
                <p class="text-xl text-red-100 mb-8 leading-relaxed">
                    Join the Marcegaglia Vocational Training Center and gain RTB-certified skills that lead to
                    self-employment and career opportunities. Our short courses are designed to equip you with practical
                    knowledge aligned with Rwanda's Vision 2020 and 2050 development goals.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a href="mailto:tvet@fmorwanda.org"
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-red-primary hover:bg-gray-100 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl">
                        Apply Now
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="tel:+250788123456"
                       class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white border-2 border-white/30 hover:bg-white/10 rounded-xl font-semibold transition-all duration-300">
                        Call Us
                    </a>
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-1">Email Us</h3>
                        <p class="text-red-100">tvet@fmorwanda.org</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-1">Call Us</h3>
                        <p class="text-red-100">+250 788 123 456</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-1">Visit Us</h3>
                        <p class="text-red-100">Rilima, Bugesera District, Eastern Rwanda</p>
                    </div>
                </div>

                <!-- Enrollment Information -->
                <div class="mt-12 pt-8 border-t border-white/20">
                    <p class="text-red-100 text-lg">
                        <span class="font-semibold">Next Intake:</span> Applications open quarterly. Contact us for the
                        next enrollment period.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
