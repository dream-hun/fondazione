<x-app-layout>
    <!-- Hero Section with Featured Image -->
    @if($blog->featured_image_url)
        <section class="relative h-[70vh] flex items-end overflow-hidden">
            <img src="{{ $blog->featured_image_url }}"
                 alt="{{ $blog->title }}"
                 class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>

            <div class="container mx-auto px-6 max-w-7xl relative z-10 pb-16">
                <div class="max-w-4xl">
                    @if($blog->is_featured)
                        <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur-sm text-white rounded text-xs uppercase tracking-wider mb-4">
                            Featured
                        </span>
                    @endif

                    <h1 class="text-4xl md:text-6xl font-light text-white mb-6 leading-tight">
                        {{ $blog->title }}
                    </h1>

                    <div class="flex items-center gap-6 text-sm text-white/80">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr($blog->author_name, 0, 1) }}</span>
                            </div>
                            <span>{{ $blog->author_name }}</span>
                        </div>
                        <span>·</span>
                        <span>{{ $blog->published_at->format('M j, Y') }}</span>
                        <span>·</span>
                        <span>{{ $blog->reading_time }} min read</span>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="pt-32 pb-16 bg-white">
            <div class="container mx-auto px-6 max-w-7xl">
                <div class="max-w-4xl">
                    @if($blog->is_featured)
                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-900 rounded text-xs uppercase tracking-wider mb-4">
                            Featured
                        </span>
                    @endif

                    <h1 class="text-4xl md:text-6xl font-light text-gray-900 mb-6 leading-tight">
                        {{ $blog->title }}
                    </h1>

                    <div class="flex items-center gap-6 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                <span class="text-sm font-medium text-gray-900">{{ substr($blog->author_name, 0, 1) }}</span>
                            </div>
                            <span>{{ $blog->author_name }}</span>
                        </div>
                        <span>·</span>
                        <span>{{ $blog->published_at->format('M j, Y') }}</span>
                        <span>·</span>
                        <span>{{ $blog->reading_time }} min read</span>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Main Content with Sidebar -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Article Content -->
                    <article class="prose prose-lg prose-gray max-w-none mb-12 text-pretty">
                        {!! nl2br($blog->content) !!}
                    </article>

                    <!-- Share Section -->
                    <div class="pt-12 border-t border-gray-200">
                        <h3 class="text-sm uppercase tracking-wider text-gray-500 mb-4">Share this article</h3>
                        <div class="flex gap-3">
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(request()->url()) }}"
                               target="_blank"
                               class="px-4 py-2 border border-gray-300 hover:border-gray-900 text-gray-700 hover:text-gray-900 rounded text-sm transition-colors">
                                Twitter
                            </a>

                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                               target="_blank"
                               class="px-4 py-2 border border-gray-300 hover:border-gray-900 text-gray-700 hover:text-gray-900 rounded text-sm transition-colors">
                                Facebook
                            </a>

                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                               target="_blank"
                               class="px-4 py-2 border border-gray-300 hover:border-gray-900 text-gray-700 hover:text-gray-900 rounded text-sm transition-colors">
                                LinkedIn
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-8 space-y-12">
                        <!-- Tags -->
                        @if($blog->tags_array && count($blog->tags_array) > 0)
                            <div>
                                <h3 class="text-sm uppercase tracking-wider text-gray-500 mb-4">Tags</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($blog->tags_array as $tag)
                                        <a href="{{ route('blog.index') }}"
                                           class="px-3 py-1 bg-gray-100 hover:bg-gray-900 hover:text-white text-gray-700 text-xs uppercase tracking-wider transition-colors">
                                            {{ $tag }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Related Posts -->
                        @if($relatedBlogs->count() > 0)
                            <div>
                                <h3 class="text-sm uppercase tracking-wider text-gray-500 mb-6">Related Articles</h3>
                                <div class="space-y-6">
                                    @foreach($relatedBlogs as $relatedBlog)
                                        <article class="group">
                                            @if($relatedBlog->featured_image_url)
                                                <a href="{{ route('blog.show', $relatedBlog) }}" class="block mb-3 overflow-hidden">
                                                    <img src="{{ $relatedBlog->featured_image_url }}"
                                                         alt="{{ $relatedBlog->title }}"
                                                         class="w-full aspect-video object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                                </a>
                                            @endif

                                            <div class="text-xs uppercase tracking-wider text-gray-500 mb-2">
                                                {{ $relatedBlog->published_at->format('M j, Y') }}
                                            </div>

                                            <h4 class="text-base font-light text-gray-900 mb-2 leading-snug">
                                                <a href="{{ route('blog.show', $relatedBlog) }}"
                                                   class="hover:text-gray-600 transition-colors">
                                                    {{ $relatedBlog->title }}
                                                </a>
                                            </h4>

                                            <a href="{{ route('blog.show', $relatedBlog) }}"
                                               class="text-xs text-gray-600 hover:text-gray-900 transition-colors">
                                                Read article →
                                            </a>
                                        </article>
                                    @endforeach
                                </div>

                                <div class="mt-8 pt-8 border-t border-gray-200">
                                    <a href="{{ route('blog.index') }}"
                                       class="block w-full px-6 py-3 border border-gray-900 text-center text-gray-900 hover:bg-gray-900 hover:text-white text-sm uppercase tracking-wider transition-colors">
                                        View All Articles
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-app-layout>
