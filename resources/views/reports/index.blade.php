<x-app-layout>
    @section('title')
        Reports
    @endsection
    @section('description')
        Download our latest reports and publications
    @endsection

    <!-- Hero Section -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center z-0"
            style="background-image: url('https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
        </div>

        <div class="container max-w-7xl mx-auto px-4 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-block mb-6">
                    <span class="text-red-primary font-bold text-lg tracking-wider">Publications</span>
                </div>
                <h1 class="text-6xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    Reports
                </h1>
                <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                    Download our latest reports and publications
                </p>
            </div>
        </div>
    </section>

    <!-- Reports Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6 max-w-6xl">
            @if($reports->isEmpty())
                <div class="text-center py-16">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No reports available</h3>
                    <p class="text-gray-500">Check back soon for our latest publications.</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($reports as $report)
                        <div class="bg-white border border-gray-200 rounded-lg p-6 flex items-center justify-between hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $report->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $report->created_at->format('M j, Y') }}</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($report->file_path) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
