@extends('admin.layouts.app')

@section('title', 'View Project: ' . $project->title)

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            Dashboard
        </a>
    </li>
    <li class="inline-flex items-center">
        <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
        <a href="{{ route('admin.projects.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            Projects
        </a>
    </li>
    <li class="inline-flex items-center">
        <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ Str::limit($project->title, 30) }}</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $project->title }}</h1>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        {{ $project->status === 'published' 
                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                            : ($project->status === 'archived' 
                                ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200') }}">
                        {{ ucfirst($project->status) }}
                    </span>
                    @if($project->is_featured)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            Featured
                        </span>
                    @endif
                </div>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Project details and information</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('projects.show', $project) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Preview
                </a>
                <a href="{{ route('admin.projects.edit', $project) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.projects.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Projects
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Project Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Project Description</h3>
                <div class="prose prose-gray dark:prose-invert max-w-none">
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $project->description }}</p>
                    <div class="text-gray-700 dark:text-gray-300">
                        {!! $project->content !!}
                    </div>
                </div>
            </div>

            <!-- Gallery Images -->
            @if($project->gallery_image_urls && count($project->gallery_image_urls) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Project Gallery</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($project->gallery_image_urls as $image)
                            <div class="aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                <img src="{{ $image }}" 
                                     alt="Project gallery image" 
                                     class="w-full h-full object-cover hover:scale-105 transition-transform cursor-pointer"
                                     onclick="openImageModal('{{ $image }}')">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Featured Image -->
            @if($project->featured_image_url)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Featured Image</h3>
                    <div class="aspect-video rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                        <img src="{{ $project->featured_image_url }}" 
                             alt="{{ $project->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
            @endif

            <!-- Project Details -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Project Details</h3>
                <div class="space-y-4">
                    <!-- Location -->
                    @if($project->location)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $project->location }}</dd>
                        </div>
                    @endif

                    <!-- Budget -->
                    @if($project->budget)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Budget</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">${{ number_format($project->budget, 2) }}</dd>
                        </div>
                    @endif

                    <!-- Duration -->
                    @if($project->start_date || $project->end_date)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                @if($project->start_date && $project->end_date)
                                    {{ $project->start_date->format('M j, Y') }} - {{ $project->end_date->format('M j, Y') }}
                                @elseif($project->start_date)
                                    Started {{ $project->start_date->format('M j, Y') }}
                                @elseif($project->end_date)
                                    Ends {{ $project->end_date->format('M j, Y') }}
                                @endif
                            </dd>
                        </div>
                    @endif

                    <!-- Beneficiaries -->
                    @if($project->beneficiaries_count)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Beneficiaries</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ number_format($project->beneficiaries_count) }} people</dd>
                        </div>
                    @endif

                    <!-- Slug -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                        <dd class="text-sm text-gray-900 dark:text-white font-mono">{{ $project->slug }}</dd>
                    </div>

                    <!-- Created Date -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $project->created_at->format('M j, Y g:i A') }}</dd>
                    </div>

                    <!-- Updated Date -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $project->updated_at->format('M j, Y g:i A') }}</dd>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    @if($project->status === 'draft')
                        <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="w-full">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="published">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                Publish Project
                            </button>
                        </form>
                    @elseif($project->status === 'published')
                        <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="w-full">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="draft">
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                                Unpublish Project
                            </button>
                        </form>
                    @endif

                    @if(!$project->is_featured)
                        <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="w-full">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="is_featured" value="1">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                Mark as Featured
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.projects.update', $project) }}" class="w-full">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="is_featured" value="0">
                            <button type="submit" class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                                Remove from Featured
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" 
                          class="w-full" onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            Delete Project
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain">
        <button onclick="closeImageModal()" 
                class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl font-bold">
            ×
        </button>
    </div>
</div>

@push('scripts')
<script>
    function openImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
@endpush
@endsection