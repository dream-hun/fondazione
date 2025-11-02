<x-app-layout>
    <!-- Hero Section -->
    <section class="pt-32 pb-16 bg-white border-b border-gray-200">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="max-w-4xl">

                <!-- Notice Badge -->
                <span class="inline-block px-3 py-1 bg-red-primary/10 text-red-primary rounded text-xs uppercase tracking-wider mb-6">
                    Official Notice
                </span>

                <!-- Title -->
                <h1 class="text-4xl md:text-6xl font-light text-gray-900 mb-6 leading-tight">
                    {{ $notice->title }}
                </h1>

                <!-- Meta Information -->
                <div class="flex items-center gap-6 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ $notice->formatted_date }}</span>
                    </div>

                    @if($notice->hasAttachment())
                        <span>·</span>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                            </svg>
                            <span>Attachment Available</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6 max-w-7xl">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Notice Content -->
                    <article class="prose prose-lg prose-gray max-w-none mb-12">
                        {{-- Option 1: Strip all HTML tags --}}
                        {{-- {!! str($notice->body)->stripTags() !!} --}}
                        
                        {{-- Option 2: Allow specific safe HTML tags --}}
                        {!! str($notice->body)->stripTags('<p><br><strong><em><ul><ol><li><h1><h2><h3><h4><h5><h6>') !!}
                        
                        {{-- Option 3: For proper HTML sanitization, install mews/purifier package --}}
                        {{-- composer require mews/purifier --}}
                        {{-- {!! clean($notice->body) !!} --}}
                    </article>

                    <!-- Attachment Section -->
                    @if($notice->hasAttachment())
                        <div class="p-6 bg-gray-50 border border-gray-200 rounded mb-12">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-red-primary/10 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">Attachment</h3>
                                    <p class="text-sm text-gray-600 mb-4">Download the attached document for more details</p>
                                    <a href="{{ asset('storage/' . $notice->attachment) }}"
                                       download
                                       class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white hover:bg-gray-700 transition-colors text-sm uppercase tracking-wider">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Download Attachment
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Share Section -->
                    <div class="pt-12 border-t border-gray-200">
                        <h3 class="text-sm uppercase tracking-wider text-gray-500 mb-4">Share this notice</h3>
                        <div class="flex gap-3">
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($notice->title) }}&url={{ urlencode(request()->url()) }}"
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

                            <button onclick="copyToClipboard()"
                                    class="px-4 py-2 border border-gray-300 hover:border-gray-900 text-gray-700 hover:text-gray-900 rounded text-sm transition-colors">
                                Copy Link
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-8 space-y-8">
                        <!-- Important Notice Box -->
                        <div class="p-6 bg-red-primary/5 border border-red-primary/20 rounded">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-primary flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 mb-1">Important Notice</h3>
                                    <p class="text-xs text-gray-600 leading-relaxed">
                                        Please read this notice carefully. For any questions or clarifications, contact our office.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div>
                            <h3 class="text-sm uppercase tracking-wider text-gray-500 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                @if($notice->hasAttachment())
                                    <a href="{{ asset('storage/' . $notice->attachment) }}"
                                       download
                                       class="flex items-center gap-3 p-3 border border-gray-200 hover:border-gray-900 rounded text-sm text-gray-700 hover:text-gray-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Download
                                    </a>
                                @endif

                                <button onclick="window.print()"
                                        class="flex items-center gap-3 p-3 border border-gray-200 hover:border-gray-900 rounded text-sm text-gray-700 hover:text-gray-900 transition-colors w-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                    Print Notice
                                </button>
                            </div>
                        </div>

                        <!-- Back to All Notices -->
                        <div class="pt-8 border-t border-gray-200">
                            <a href="{{ route('notices.index') }}"
                               class="block w-full px-6 py-3 border border-gray-900 text-center text-gray-900 hover:bg-gray-900 hover:text-white text-sm uppercase tracking-wider transition-colors">
                                View All Notices
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Copy to Clipboard Script -->
    <script>
        function copyToClipboard() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Link copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
</x-app-layout>
