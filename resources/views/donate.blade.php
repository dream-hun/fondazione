<x-app-layout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-red-primary via-red-600 to-red-800 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0"
                 style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 20px 20px;"></div>
        </div>

        <div class="container mx-auto max-w-7xl px-4 py-20 lg:py-32 relative">
            <div class="max-w-4xl mx-auto text-center">
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm font-medium mb-6">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    Make a Difference Today
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Your Donation Changes Lives
                </h1>

                <p class="text-xl text-white/90 leading-relaxed mb-8 max-w-3xl mx-auto">
                    Every contribution helps us empower women, educate children, and build stronger communities across Rwanda. Join us in creating lasting change.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#donate-now"
                       class="inline-flex items-center justify-center px-8 py-4 bg-amber-500 text-white hover:bg-amber-600 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Donate Now
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                    <a href="#impact"
                       class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white border-2 border-white/30 hover:bg-white/10 rounded-xl font-semibold transition-all duration-300">
                        See Our Impact
                    </a>
                </div>
            </div>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-white to-transparent"></div>
    </section>


    <!-- Impact Statistics -->
    <section id="impact" class="py-20 bg-white">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Your Impact in <span class="text-red-primary">Numbers</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    See how donations like yours are transforming lives across Rwanda
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">50,000+</div>
                    <div class="text-sm text-gray-600 uppercase tracking-wide">Lives Impacted</div>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">120+</div>
                    <div class="text-sm text-gray-600 uppercase tracking-wide">Projects Completed</div>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">25+</div>
                    <div class="text-sm text-gray-600 uppercase tracking-wide">Communities Served</div>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">15+</div>
                    <div class="text-sm text-gray-600 uppercase tracking-wide">Years of Service</div>
                </div>
            </div>
        </div>
    </section>


    <!-- Donation Methods -->
    <section id="donate-now" class="py-20 bg-gray-50">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    How to <span class="text-red-primary">Donate</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Choose the donation method that works best for you
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Bank Transfer -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-red-primary/10 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-red-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Bank Transfer</h3>
                    <p class="text-gray-600 mb-6">Direct bank transfer to our account</p>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Bank Name:</span>
                            <span class="font-semibold text-gray-900">Bank of Kigali</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Account Name:</span>
                            <span class="font-semibold text-gray-900">FMO Rwanda</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Account Number:</span>
                            <span class="font-semibold text-gray-900">00123456789</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Swift Code:</span>
                            <span class="font-semibold text-gray-900">BKIGRWRW</span>
                        </div>
                    </div>
                </div>

                <!-- Mobile Money -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile Money</h3>
                    <p class="text-gray-600 mb-6">Send via MTN or Airtel Money</p>

                    <div class="space-y-4">
                        <div class="p-4 bg-amber-50 rounded-lg">
                            <div class="flex items-center mb-2">
                                <span class="font-semibold text-gray-900">MTN Mobile Money</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Send to: <span class="font-semibold">0788 123 456</span></p>
                            <p class="text-xs text-gray-500">Name: FMO Rwanda</p>
                        </div>

                        <div class="p-4 bg-red-50 rounded-lg">
                            <div class="flex items-center mb-2">
                                <span class="font-semibold text-gray-900">Airtel Money</span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Send to: <span class="font-semibold">0733 123 456</span></p>
                            <p class="text-xs text-gray-500">Name: FMO Rwanda</p>
                        </div>
                    </div>
                </div>

                <!-- International Transfer -->
                <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow md:col-span-2 lg:col-span-1">
                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">International</h3>
                    <p class="text-gray-600 mb-6">For donations from outside Rwanda</p>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Bank:</span>
                            <span class="font-semibold text-gray-900">Bank of Kigali</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">IBAN:</span>
                            <span class="font-semibold text-gray-900">RW12 3456 7890 1234</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600">Swift:</span>
                            <span class="font-semibold text-gray-900">BKIGRWRW</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Currency:</span>
                            <span class="font-semibold text-gray-900">USD, EUR, RWF</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Note -->
            <div class="mt-12 max-w-4xl mx-auto">
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-2">Important Information</h4>
                            <p class="text-gray-700 text-sm leading-relaxed">
                                Please include your name and email in the transfer reference so we can send you a receipt and keep you updated on how your donation is making a difference. For questions about donations, contact us at <a href="mailto:donations@fmorwanda.org" class="text-blue-600 hover:underline">donations@fmorwanda.org</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Impact Stories -->
    <section class="py-20 bg-white">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Where Your <span class="text-red-primary">Donation Goes</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    See the real impact of your generosity in our communities
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Education Impact -->
                <div class="group">
                    <div class="relative overflow-hidden rounded-2xl mb-6 aspect-square">
                        <img src="{{ asset('images/_DSC8049.jpg') }}"
                             alt="Education programs"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="inline-flex items-center px-3 py-1 bg-amber-500 text-white text-sm font-semibold rounded-full mb-3">
                                Education
                            </div>
                            <h3 class="text-2xl font-bold text-white">School Supplies & Scholarships</h3>
                        </div>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Your donation provides school materials, uniforms, and scholarships for children who otherwise couldn't afford education. Last year, we supported over 500 students.
                    </p>
                </div>

                <!-- Healthcare Impact -->
                <div class="group">
                    <div class="relative overflow-hidden rounded-2xl mb-6 aspect-square">
                        <img src="{{ asset('images/_DSC8103.jpg') }}"
                             alt="Healthcare programs"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-sm font-semibold rounded-full mb-3">
                                Healthcare
                            </div>
                            <h3 class="text-2xl font-bold text-white">Medical Care & Nutrition</h3>
                        </div>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Funds support health clinics, nutrition programs, and medical supplies for families in need. We've provided healthcare access to over 10,000 people.
                    </p>
                </div>

                <!-- Women Empowerment Impact -->
                <div class="group">
                    <div class="relative overflow-hidden rounded-2xl mb-6 aspect-square">
                        <img src="{{ asset('images/_DSC8049.jpg') }}"
                             alt="Women empowerment"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="inline-flex items-center px-3 py-1 bg-red-primary text-white text-sm font-semibold rounded-full mb-3">
                                Empowerment
                            </div>
                            <h3 class="text-2xl font-bold text-white">Women's Skills Training</h3>
                        </div>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        Training programs help women start businesses and become financially independent. Over 300 women have launched successful enterprises through our programs.
                    </p>
                </div>
            </div>

            <!-- Donation Impact Examples -->
            <div class="mt-16 grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
                <div class="bg-red-50 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-red-primary mb-2">$50</div>
                    <p class="text-gray-700">Provides school supplies for 5 children for a full year</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-blue-600 mb-2">$100</div>
                    <p class="text-gray-700">Supports a family's healthcare needs for 3 months</p>
                </div>
                <div class="bg-green-50 rounded-xl p-6 text-center">
                    <div class="text-3xl font-bold text-green-600 mb-2">$250</div>
                    <p class="text-gray-700">Funds vocational training for one woman entrepreneur</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Transparency & Trust -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">
                        Your Trust <span class="text-red-primary">Matters</span>
                    </h2>
                    <p class="text-xl text-gray-600">
                        We're committed to transparency and accountability in everything we do
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 mb-12">
                    <!-- Fund Allocation -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-red-primary/10 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-red-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900">How We Use Funds</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-700 font-medium">Programs & Services</span>
                                    <span class="text-gray-900 font-bold">85%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-red-primary h-3 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-700 font-medium">Administration</span>
                                    <span class="text-gray-900 font-bold">10%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-500 h-3 rounded-full" style="width: 10%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-700 font-medium">Fundraising</span>
                                    <span class="text-gray-900 font-bold">5%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-green-500 h-3 rounded-full" style="width: 5%"></div>
                                </div>
                            </div>
                        </div>

                        <p class="text-sm text-gray-600 mt-6">
                            85 cents of every dollar goes directly to programs that change lives.
                        </p>
                    </div>

                    <!-- Certifications & Contact -->
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Registered NGO</h3>
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                Fondazione Marcegaglia Onlus Rwanda is officially registered with the Rwanda Governance Board (RGB) and operates in full compliance with local regulations.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900">Get in Touch</h3>
                            </div>
                            <div class="space-y-3 text-sm">
                                <p class="text-gray-600">
                                    <span class="font-semibold text-gray-900">Email:</span><br>
                                    <a href="mailto:donations@fmorwanda.org" class="text-red-primary hover:underline">donations@fmorwanda.org</a>
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-semibold text-gray-900">Phone:</span><br>
                                    +250 788 123 456
                                </p>
                                <p class="text-gray-600">
                                    <span class="font-semibold text-gray-900">Office:</span><br>
                                    Kimaranzara Cell, Rilima Sector<br>
                                    Bugesera District, Rwanda
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto max-w-4xl px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Frequently Asked <span class="text-red-primary">Questions</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Everything you need to know about donating
                </p>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Is my donation tax-deductible?</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Yes, Fondazione Marcegaglia Onlus Rwanda is a registered NGO. We provide tax receipts for all donations. Please include your email address with your donation so we can send you a receipt.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Can I make a recurring donation?</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Yes! You can set up recurring donations through your bank's standing order feature or mobile money recurring payments. Contact us at donations@fmorwanda.org for assistance setting this up.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">How will I know my donation made a difference?</h3>
                    <p class="text-gray-600 leading-relaxed">
                        We send regular updates to all donors via email, including impact reports, success stories, and photos from our programs. You'll see exactly how your contribution is changing lives.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Can I donate in honor or memory of someone?</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Absolutely. Please include the honoree's name in your transfer reference or email us at donations@fmorwanda.org with the details. We'll send a special acknowledgment card if you provide an address.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">What if I want to support a specific program?</h3>
                    <p class="text-gray-600 leading-relaxed">
                        You can designate your donation for a specific program (education, healthcare, women's empowerment, etc.). Just mention your preference in the transfer reference or contact us directly.
                    </p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Are there other ways to support besides money?</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Yes! We welcome volunteers, in-kind donations, corporate partnerships, and professional services. Visit our <a href="{{ route('about-us') }}" class="text-red-primary hover:underline">About Us</a> page or contact us to learn more about other ways to get involved.
                    </p>
                </div>
            </div>
        </div>
    </section>


    <!-- Final CTA -->
    <section class="py-20 bg-gradient-to-br from-red-primary to-red-700 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="container mx-auto max-w-7xl px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Ready to Make an Impact?
                </h2>
                <p class="text-xl text-red-50 mb-10 leading-relaxed">
                    Your generosity today creates opportunities for tomorrow. Join us in transforming lives across Rwanda.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a href="#donate-now"
                       class="inline-flex items-center justify-center px-8 py-4 bg-amber-500 text-white hover:bg-amber-600 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Donate Now
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </a>
                    <a href="{{ route('about-us') }}"
                       class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white border-2 border-white rounded-xl font-semibold transition-all duration-300">
                        Learn More About Us
                    </a>
                </div>

                <!-- Alternative Support Options -->
                <div class="border-t border-white/20 pt-12">
                    <h3 class="text-2xl font-bold mb-8">Other Ways to Support</h3>
                    <div class="grid sm:grid-cols-3 gap-6 text-left">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-white flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold mb-1">Volunteer</h4>
                                <p class="text-red-100 text-sm">Share your skills and time with our programs</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-white flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold mb-1">Corporate Partnership</h4>
                                <p class="text-red-100 text-sm">Partner with us for greater impact</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-white flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold mb-1">Spread the Word</h4>
                                <p class="text-red-100 text-sm">Share our mission with your network</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mt-12 pt-12 border-t border-white/20">
                    <p class="text-red-100 mb-4">Questions about donating?</p>
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center text-sm">
                        <a href="mailto:donations@fmorwanda.org" class="flex items-center gap-2 hover:text-amber-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            donations@fmorwanda.org
                        </a>
                        <a href="tel:+250788123456" class="flex items-center gap-2 hover:text-amber-300 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            +250 788 123 456
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
