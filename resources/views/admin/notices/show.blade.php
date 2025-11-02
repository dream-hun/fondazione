@extends('admin.layouts.app')

@section('title', 'View Notice: ' . $notice->title)

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
        <a href="{{ route('admin.notices.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            Notices
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
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $notice->title }}</h1>
                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        @if($notice->status->value === 'Published')
                            bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                        @elseif($notice->status->value === 'Draft')
                            bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                        @else
                            bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                        @endif">
                        <span class="w-2 h-2 mr-1 rounded-full {{ $notice->status->getColor() === 'success' ? 'bg-green-400' : ($notice->status->getColor() === 'danger' ? 'bg-red-400' : 'bg-gray-400') }}"></span>
                        {{ $notice->status->value }}
                    </span>
                    <span>Created: {{ $notice->created_at->format('M j, Y g:i A') }}</span>
                    <span>Updated: {{ $notice->updated_at->format('M j, Y g:i A') }}</span>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('notices.show', $notice) }}" 
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    View Live
                </a>
                <a href="{{ route('admin.notices.edit', $notice) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.notices.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Notices
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Content -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Content</h3>
                <div class="prose prose-lg max-w-none dark:prose-invert">
                    {!! $notice->content !!}
                </div>
            </div>

            <!-- Attachment -->
            @if($notice->hasAttachment())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Attachment</h3>
                    
                    <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <svg class="w-12 h-12 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        <div class="flex-1">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ basename($notice->attachment) }}</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Click to download or view the attachment</p>
                        </div>
                        <a href="{{ asset('storage/' . $notice->attachment) }}" 
                           target="_blank" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Notice Details -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Notice Details</h3>
                
                <div class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">UUID</dt>
                        <dd class="text-sm text-gray-900 dark:text-white font-mono break-all">{{ $notice->uuid }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                        <dd class="text-sm text-gray-900 dark:text-white font-mono">{{ $notice->slug }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $notice->status->value }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $notice->created_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $notice->updated_at->format('M j, Y g:i A') }}</dd>
                    </div>

                    @if($notice->hasAttachment())
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Attachment</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ basename($notice->attachment) }}</dd>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                
                <div class="space-y-2">
                    @if($notice->status->value === 'Draft')
                        <form method="POST" action="{{ route('admin.notices.update', $notice) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Published">
                            <input type="hidden" name="title" value="{{ $notice->title }}">
                            <input type="hidden" name="content" value="{{ $notice->content }}">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                Publish Now
                            </button>
                        </form>
                    @elseif($notice->status->value === 'Published')
                        <form method="POST" action="{{ route('admin.notices.update', $notice) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Unpublished">
                            <input type="hidden" name="title" value="{{ $notice->title }}">
                            <input type="hidden" name="content" value="{{ $notice->content }}">
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                                Unpublish
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.notices.update', $notice) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Published">
                            <input type="hidden" name="title" value="{{ $notice->title }}">
                            <input type="hidden" name="content" value="{{ $notice->content }}">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                Publish
                            </button>
                        </form>
                    @endif
                    
                    @if($notice->status->value !== 'Draft')
                        <form method="POST" action="{{ route('admin.notices.update', $notice) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="Draft">
                            <input type="hidden" name="title" value="{{ $notice->title }}">
                            <input type="hidden" name="content" value="{{ $notice->content }}">
                            <button type="submit" class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                                Move to Draft
                            </button>
                        </form>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.notices.destroy', $notice) }}" 
                          class="w-full" onsubmit="return confirm('Are you sure you want to delete this notice? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            Delete Notice
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection