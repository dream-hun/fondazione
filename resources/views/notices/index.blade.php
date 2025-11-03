<x-app-layout>
    <!-- Hero Section - Minimal -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center z-0"
            style="background-image: url('https://images.unsplash.com/photo-1586339949916-3e9457bef6d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
        </div>

        <div class="container max-w-7xl mx-auto px-4 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-block mb-6">
                    <span class="text-red-primary font-bold text-lg tracking-wider">Stay Informed</span>
                </div>
                <h1 class="text-6xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    Notices
                </h1>
                <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                    Important announcements and updates from our organization
                </p>
            </div>
        </div>
    </section>


    <!-- Search Section -->
    <section class="py-8 border-y border-gray-200 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="flex justify-center">
                <div class="w-full max-w-2xl">
                    <form method="GET" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search notices..."
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-none focus:ring-1 focus:ring-gray-900 focus:border-gray-900 text-sm">
                        <svg class="absolute right-4 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>

                    <!-- Active Search -->
                    @if (request('search'))
                        <div class="mt-4 flex items-center justify-center gap-3 text-sm">
                            <span class="text-gray-700">
                                Searching: <span class="font-medium">"{{ request('search') }}"</span>
                            </span>
                            <a href="{{ route('notices.index') }}"
                                class="text-gray-500 hover:text-gray-900 underline">Clear</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>


    <!-- All Notices -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-7xl">

            @if ($notices->count() > 0)
                <div class="space-y-16 gap-8 divide-y divide-gray-200">
                    @foreach ($notices as $notice)
                        <article class="flex max-w-full flex-col items-start justify-between py-4">
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
                                    {!! Str::limit($notice->body, 200) !!}
                                </p>
                            </div>

                        </article>
                    @endforeach
                </div>


                <!-- Pagination -->
                @if ($notices->hasPages())
                    <div class="mt-16 flex justify-center">
                        {{ $notices->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-20">
                    <h3 class="text-2xl font-light text-gray-900 mb-3">No notices found</h3>
                    <p class="text-gray-600 mb-8">
                        @if (request('search'))
                            Try adjusting your search criteria
                        @else
                            Check back soon for important announcements
                        @endif
                    </p>
                    @if (request('search'))
                        <a href="{{ route('notices.index') }}"
                            class="inline-block px-8 py-3 border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white transition-colors text-sm uppercase tracking-wider">
                            View All Notices
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
