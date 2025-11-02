<x-app-layout>
    <!-- Hero Section with Overlay -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/_DSC8103.jpg') }}"
             alt="About us"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>

        <div class="container mx-auto px-4 max-w-7xl relative z-10">
            <div class="max-w-3xl">
                <div class="inline-block mb-6">
                    <span class="text-red-primary font-bold text-lg tracking-wider">WHO WE ARE</span>
                </div>
                <h1 class="text-6xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    Building Hope.<br>
                    Transforming Lives.
                </h1>
                <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                    For over a decade, we've been partnering with communities across Rwanda to create sustainable change through education, healthcare, and empowerment.
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('projects.index') }}" class="px-8 py-4 bg-red-primary hover:bg-red-700 text-white font-semibold rounded-lg transition-all shadow-lg hover:shadow-xl">
                        Our Work
                    </a>
                    <a href="#story" class="px-8 py-4 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-semibold rounded-lg transition-all border border-white/30">
                        Our Story
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Stats Bar -->
    <section class="bg-red-primary text-white py-12">
        <div class="container mx-auto max-w-7xl px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-5xl font-bold mb-2">15+</div>
                    <div class="text-red-100 uppercase text-sm tracking-wide">Years of Impact</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold mb-2">50K+</div>
                    <div class="text-red-100 uppercase text-sm tracking-wide">Lives Changed</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold mb-2">25+</div>
                    <div class="text-red-100 uppercase text-sm tracking-wide">Active Projects</div>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold mb-2">15+</div>
                    <div class="text-red-100 uppercase text-sm tracking-wide">Partner Orgs</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section id="story" class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-16 items-center">
                    <div>
                        <span class="text-red-primary font-bold text-sm tracking-wider uppercase">Our Story</span>
                        <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-4 mb-6">
                            A Journey of Compassion and Change
                        </h2>
                        <div class="space-y-4 text-gray-700 text-lg leading-relaxed">
                            <p>
                                Fondazione Marcegaglia Onlus Rwanda was founded in 2010 with a simple but powerful vision: to create lasting positive change in the lives of Rwandan communities.
                            </p>
                            <p>
                                What began as a small initiative has grown into a comprehensive development organization, touching thousands of lives through education, healthcare, and sustainable community programs.
                            </p>
                            <p>
                                Our approach is rooted in partnership and respect. We work alongside local communities, listening to their needs and empowering them to build their own solutions.
                            </p>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="aspect-square rounded-2xl overflow-hidden shadow-2xl">
                            <img src="https://images.unsplash.com/photo-1497375628654-29454c732e46?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                 alt="Our story"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -bottom-8 -left-8 w-64 h-64 bg-red-primary/10 rounded-2xl -z-10"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Mission -->
                    <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-red-primary/10 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-red-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h3>
                        <p class="text-gray-700 text-lg leading-relaxed">
                            To empower communities in Rwanda through sustainable development programs that provide access to quality education, healthcare, and economic opportunities, fostering self-reliance and lasting change.
                        </p>
                    </div>

                    <!-- Vision -->
                    <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-secondary/10 rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Our Vision</h3>
                        <p class="text-gray-700 text-lg leading-relaxed">
                            A thriving Rwanda where every individual has the opportunity to reach their full potential, and communities are equipped with the resources and knowledge to build prosperous, sustainable futures.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-red-primary font-bold text-sm tracking-wider uppercase">What Drives Us</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-4 mb-6">Our Core Values</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        These principles guide every decision we make and every action we take.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="group">
                        <div class="bg-gray-50 group-hover:bg-red-primary/5 p-8 rounded-xl transition-all h-full">
                            <div class="w-14 h-14 bg-red-primary rounded-lg flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Compassion</h3>
                            <p class="text-gray-600 leading-relaxed">
                                We approach every interaction with empathy, treating each person with dignity and understanding their unique circumstances.
                            </p>
                        </div>
                    </div>

                    <div class="group">
                        <div class="bg-gray-50 group-hover:bg-red-primary/5 p-8 rounded-xl transition-all h-full">
                            <div class="w-14 h-14 bg-red-primary rounded-lg flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Partnership</h3>
                            <p class="text-gray-600 leading-relaxed">
                                We work alongside communities, not for them. True change comes from collaboration and mutual respect.
                            </p>
                        </div>
                    </div>

                    <div class="group">
                        <div class="bg-gray-50 group-hover:bg-red-primary/5 p-8 rounded-xl transition-all h-full">
                            <div class="w-14 h-14 bg-red-primary rounded-lg flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Integrity</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Transparency and accountability are at the heart of everything we do. We honor the trust placed in us.
                            </p>
                        </div>
                    </div>

                    <div class="group">
                        <div class="bg-gray-50 group-hover:bg-red-primary/5 p-8 rounded-xl transition-all h-full">
                            <div class="w-14 h-14 bg-red-primary rounded-lg flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Sustainability</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Every program is designed to create lasting impact, building systems that endure long after we leave.
                            </p>
                        </div>
                    </div>

                    <div class="group">
                        <div class="bg-gray-50 group-hover:bg-red-primary/5 p-8 rounded-xl transition-all h-full">
                            <div class="w-14 h-14 bg-red-primary rounded-lg flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Empowerment</h3>
                            <p class="text-gray-600 leading-relaxed">
                                We equip individuals with knowledge, skills, and resources to create their own opportunities.
                            </p>
                        </div>
                    </div>

                    <div class="group">
                        <div class="bg-gray-50 group-hover:bg-red-primary/5 p-8 rounded-xl transition-all h-full">
                            <div class="w-14 h-14 bg-red-primary rounded-lg flex items-center justify-center mb-6">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Innovation</h3>
                            <p class="text-gray-600 leading-relaxed">
                                We embrace creative solutions while respecting local traditions and cultural values.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-24 bg-white-900 text-black">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-red-primary font-bold text-sm tracking-wider uppercase">Meet The Team</span>
                    <h2 class="text-4xl md:text-5xl font-bold mt-4 mb-6">The People Behind Our Mission</h2>
                    <p class="text-xl text-gray-400 max-w-3xl mx-auto">
                        Dedicated professionals working every day to create positive change in Rwanda.
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="group">
                        <div class="aspect-square rounded-xl overflow-hidden mb-4 relative">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=8&w=400&h=400&q=80"
                                 alt="Maria Rossi"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <h3 class="text-xl font-bold mb-1">Maria Rossi</h3>
                        <p class="text-red-primary font-semibold mb-1">Executive Director</p>
                        <p class="text-gray-400 text-sm">Kigali, Rwanda</p>
                    </div>

                    <div class="group">
                        <div class="aspect-square rounded-xl overflow-hidden mb-4 relative">
                            <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=8&w=400&h=400&q=80"
                                 alt="Jean Claude Mugabo"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <h3 class="text-xl font-bold mb-1">Jean Claude Mugabo</h3>
                        <p class="text-red-primary font-semibold mb-1">Program Director</p>
                        <p class="text-gray-400 text-sm">Kigali, Rwanda</p>
                    </div>

                    <div class="group">
                        <div class="aspect-square rounded-xl overflow-hidden mb-4 relative">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=8&w=400&h=400&q=80"
                                 alt="Diane Uwase"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <h3 class="text-xl font-bold mb-1">Diane Uwase</h3>
                        <p class="text-red-primary font-semibold mb-1">Community Coordinator</p>
                        <p class="text-gray-400 text-sm">Kigali, Rwanda</p>
                    </div>

                    <div class="group">
                        <div class="aspect-square rounded-xl overflow-hidden mb-4 relative">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=8&w=400&h=400&q=80"
                                 alt="Giuseppe Bianchi"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                        <h3 class="text-xl font-bold mb-1">Giuseppe Bianchi</h3>
                        <p class="text-red-primary font-semibold mb-1">Operations Manager</p>
                        <p class="text-gray-400 text-sm">Kigali, Rwanda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-br from-red-primary to-red-700 text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">Join Us in Making a Difference</h2>
                <p class="text-xl text-red-50 mb-10 leading-relaxed">
                    Whether through donations, volunteering, or partnerships, there are many ways you can contribute to transforming lives in Rwanda.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    <a href="#" class="px-8 py-4 bg-white text-red-primary hover:bg-gray-100 font-bold rounded-lg transition-all shadow-xl">
                        Make a Donation
                    </a>
                    <a href="#" class="px-8 py-4 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-bold rounded-lg transition-all border-2 border-white">
                        Get Involved
                    </a>
                </div>

                <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6 text-left">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-white flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-red-50">Financial support</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-white flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-red-50">Volunteer opportunities</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-white flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-red-50">Corporate partnerships</span>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-white flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-red-50">Project sponsorship</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
