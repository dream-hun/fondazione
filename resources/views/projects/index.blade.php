<x-app-layout>
    <!-- Hero Section -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/_DSC8103.jpg') }}"
             alt="About us"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0  bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>

        <div class="container mx-auto max-w-7xl px-4 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-block mb-6">
                    <span class="text-red-primary font-bold text-lg tracking-wider">Our Projects</span>
                </div>
                <h1 class="text-6xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    Our Programs
                </h1>
                <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                    For over a decade, we've been partnering with communities across Rwanda to create sustainable change through education, healthcare, and empowerment.
                </p>

            </div>
        </div>

    </section>

    <!-- Projects Grid -->
    <section class="py-24 bg-white">
        <div class="container mx-auto max-w-7xl px-4">
            @if($projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($projects as $project)
                        <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-600 relative overflow-hidden">
                                @if($project->featured_image_url)
                                    <img src="{{ $project->featured_image_url }}"
                                         alt="{{ $project->title }}"
                                         class="w-full h-full object-cover">
                                @endif
                                <div class="absolute inset-0 bg-black/20"></div>
                                <div class="absolute top-4 right-4">
                                    @if($project->is_featured)
                                        <span class="px-3 py-1 bg-amber-500 text-white text-sm font-medium rounded-full">
                                            Featured
                                        </span>
                                    @endif
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-3">
                                    @if($project->location)
                                        <span class="inline-flex items-center px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            </svg>
                                            {{ $project->location }}
                                        </span>
                                    @endif
                                    <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-600 text-xs rounded-full">
                                        {{ $project->status_label }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $project->title }}</h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">{{ $project->description }}</p>

                                @if($project->beneficiaries_count)
                                    <div class="flex items-center gap-2 mb-4 text-sm text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        {{ number_format($project->beneficiaries_count) }} beneficiaries
                                    </div>
                                @endif

                                <div class="flex items-center justify-between">
                                    <a href="{{ route('projects.show', $project) }}"
                                       class="inline-flex items-center text-red-primary hover:text-red-700 font-medium text-sm">
                                        Learn more
                                        <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                    @if($project->budget)
                                        <span class="text-sm font-semibold text-gray-900">
                                            ${{ number_format($project->budget) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No projects found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search criteria or check back later for new projects.</p>
                    <a href="{{ route('projects.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-red-primary text-white rounded-lg hover:bg-red-700 transition-colors">
                        View all projects
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
