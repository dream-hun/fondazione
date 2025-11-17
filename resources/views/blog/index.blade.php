<x-app-layout>
    <!-- Hero Section - Minimal -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center z-0"
            style="background-image: url('{{ asset('images/mvtc/Mvtc students in ICT skills.avif') }}');">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
        </div>

        <div class="container max-w-7xl mx-auto px-4 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-block mb-6">
                    <span class="text-red-primary font-bold text-lg tracking-wider">Our Stories</span>
                </div>
                <h1 class="text-6xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    Blog
                </h1>
                <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                    Our stories across our communities
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
                            placeholder="Search articles..."
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
                            <a href="{{ route('blog.index') }}"
                                class="text-gray-500 hover:text-gray-900 underline">Clear</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Stories -->
    @if (!$isFiltering && isset($featuredBlogs) && $featuredBlogs->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-6 max-w-6xl">
                <h2 class="text-3xl font-light text-gray-900 mb-8">Featured Stories</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach ($featuredBlogs as $featuredBlog)
                        <article class="group">
                            @if ($featuredBlog->featured_image_url)
                                <a href="{{ route('blog.show', $featuredBlog) }}" class="block mb-4 overflow-hidden">
                                    <img src="{{ $featuredBlog->featured_image_url }}" alt="{{ $featuredBlog->title }}"
                                        class="w-full aspect-[4/3] object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                </a>
                            @endif
                            <h3 class="text-xl font-light text-gray-900 mb-2">
                                <a href="{{ route('blog.show', $featuredBlog) }}"
                                    class="hover:text-gray-600 transition-colors">
                                    {{ $featuredBlog->title }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-500 mb-3">
                                {{ $featuredBlog->published_at->format('M j, Y') }} · {{ $featuredBlog->reading_time }}
                                min
                            </p>
                            @if ($featuredBlog->excerpt)
                                <p class="text-gray-600 text-sm line-clamp-2">{{ $featuredBlog->excerpt }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- All Blog Posts -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6 max-w-6xl">
            @if ($blogs->total() > 0)
                <div class="mb-12">
                    <p class="text-sm text-gray-500">
                        {{ $blogs->total() }} {{ Str::plural('article', $blogs->total()) }}
                    </p>
                </div>
            @endif

            @if ($blogs->count() > 0)
                <div class="space-y-16">
                    @foreach ($blogs as $blog)
                        <article class="group grid md:grid-cols-3 gap-8 pb-16 border-b border-gray-200 last:border-0">
                            @if ($blog->featured_image_url)
                                <a href="{{ route('blog.show', $blog) }}" class="md:col-span-1 overflow-hidden">
                                    <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}"
                                        class="w-full aspect-[4/3] object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                </a>
                            @endif

                            <div class="{{ $blog->featured_image_url ? 'md:col-span-2' : 'md:col-span-3' }}">
                                <div
                                    class="flex items-center gap-3 mb-3 text-xs uppercase tracking-wider text-gray-500">
                                    <span>{{ $blog->published_at->format('M j, Y') }}</span>
                                    <span>·</span>
                                    <span>{{ $blog->reading_time }} min</span>
                                </div>

                                <h3 class="text-3xl font-light text-gray-900 mb-4 leading-snug">
                                    <a href="{{ route('blog.show', $blog) }}"
                                        class="hover:text-gray-600 transition-colors">
                                        {{ $blog->title }}
                                    </a>
                                </h3>

                                <p class="text-gray-600 mb-6 leading-relaxed">
                                    {{ $blog->excerpt }}
                                </p>

                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-gray-900">{{ $blog->author_name }}</p>
                                    <a href="{{ route('blog.show', $blog) }}"
                                        class="text-sm text-gray-900 hover:text-gray-600 transition-colors">
                                        Read article →
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($blogs->hasPages())
                    <div class="mt-16 flex justify-center">
                        {{ $blogs->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-20">
                    <h3 class="text-2xl font-light text-gray-900 mb-3">No articles found</h3>
                    <p class="text-gray-600 mb-8">
                        @if (request('search'))
                            Try adjusting your search criteria
                        @else
                            Check back soon for new stories
                        @endif
                    </p>
                    @if (request('search'))
                        <a href="{{ route('blog.index') }}"
                            class="inline-block px-8 py-3 border border-gray-900 text-gray-900 hover:bg-gray-900 hover:text-white transition-colors text-sm uppercase tracking-wider">
                            View All Articles
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
