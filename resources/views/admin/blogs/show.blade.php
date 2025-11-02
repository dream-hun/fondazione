@extends('admin.layouts.app')

@section('title', 'View Blog: ' . $blog->title)

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
        <a href="{{ route('admin.blogs.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            Blogs
        </a>
    </li>
    <li class="inline-flex items-center">
        <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
        <span class="text-gray-500 dark:text-gray-400">View</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $blog->title }}</h1>
                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        {{ $blog->status === 'published' 
                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                            : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                        {{ ucfirst($blog->status) }}
                    </span>
                    @if($blog->is_featured)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                            Featured
                        </span>
                    @endif
                    <span>Created: {{ $blog->created_at->format('M j, Y g:i A') }}</span>
                    @if($blog->published_at)
                        <span>Published: {{ $blog->published_at->format('M j, Y g:i A') }}</span>
                    @endif
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('blog.show', $blog) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    View Live
                </a>
                <a href="{{ route('admin.blogs.edit', $blog) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.blogs.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Blogs
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Featured Image -->
            @if($blog->featured_image_url)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                    <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}" 
                         class="w-full h-64 object-cover">
                </div>
            @endif

            <!-- Excerpt -->
            @if($blog->excerpt)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Excerpt</h3>
                    <p class="text-gray-600 dark:text-gray-400 italic">{{ $blog->excerpt }}</p>
                </div>
            @endif

            <!-- Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Content</h3>
                <div class="prose prose-lg max-w-none dark:prose-invert">
                    {!! $blog->content !!}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Blog Details -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Blog Details</h3>
                
                <div class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                        <dd class="text-sm text-gray-900 dark:text-white font-mono">{{ $blog->slug }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ ucfirst($blog->status) }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Reading Time</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $blog->reading_time }} min read</dd>
                    </div>
                    
                    @if($blog->published_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Published</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $blog->published_at->format('M j, Y g:i A') }}</dd>
                        </div>
                    @endif
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $blog->created_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $blog->updated_at->format('M j, Y g:i A') }}</dd>
                    </div>
                </div>
            </div>

            <!-- Author Information -->
            @if($blog->author_name || $blog->author_email)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Author</h3>
                    
                    <div class="space-y-2">
                        @if($blog->author_name)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $blog->author_name }}</dd>
                            </div>
                        @endif
                        
                        @if($blog->author_email)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $blog->author_email }}</dd>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Tags -->
            @if($blog->tags)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Tags</h3>
                    
                    <div class="flex flex-wrap gap-2">
                        @foreach($blog->tags_array as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                
                <div class="space-y-2">
                    @if($blog->status === 'draft')
                        <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="published">
                            <input type="hidden" name="title" value="{{ $blog->title }}">
                            <input type="hidden" name="content" value="{{ $blog->content }}">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                Publish Now
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="draft">
                            <input type="hidden" name="title" value="{{ $blog->title }}">
                            <input type="hidden" name="content" value="{{ $blog->content }}">
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                                Unpublish
                            </button>
                        </form>
                    @endif
                    
                    @if(!$blog->is_featured)
                        <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_featured" value="1">
                            <input type="hidden" name="title" value="{{ $blog->title }}">
                            <input type="hidden" name="content" value="{{ $blog->content }}">
                            <input type="hidden" name="status" value="{{ $blog->status }}">
                            <button type="submit" class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors">
                                Mark as Featured
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.blogs.update', $blog) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_featured" value="0">
                            <input type="hidden" name="title" value="{{ $blog->title }}">
                            <input type="hidden" name="content" value="{{ $blog->content }}">
                            <input type="hidden" name="status" value="{{ $blog->status }}">
                            <button type="submit" class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                                Remove Featured
                            </button>
                        </form>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" 
                          class="w-full" onsubmit="return confirm('Are you sure you want to delete this blog? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            Delete Blog
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection