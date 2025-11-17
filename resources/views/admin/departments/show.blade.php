@extends('admin.layouts.app')

@section('title', 'View Department: ' . $department->name)

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
        <a href="{{ route('admin.departments.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            Departments
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
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $department->name }}</h1>
                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600 dark:text-gray-400">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        {{ $department->is_active 
                            ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' 
                            : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                        {{ $department->status_label }}
                    </span>
                    <span>Created: {{ $department->created_at->format('M j, Y g:i A') }}</span>
                    <span>Last Updated: {{ $department->updated_at->format('M j, Y g:i A') }}</span>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.departments.edit', $department) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.departments.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Departments
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            @if($department->description)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Description</h3>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $department->description }}</p>
                </div>
            @endif

            <!-- Mission -->
            @if($department->mission)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Mission</h3>
                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">{{ $department->mission }}</p>
                </div>
            @endif

            <!-- Key Responsibilities -->
            @if($department->key_responsibilities && count($department->key_responsibilities) > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Key Responsibilities</h3>
                    <ul class="space-y-2">
                        @foreach($department->key_responsibilities as $responsibility)
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-2 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-600 dark:text-gray-400">{{ $responsibility }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Department Details -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Department Details</h3>
                
                <div class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Slug</dt>
                        <dd class="text-sm text-gray-900 dark:text-white font-mono">{{ $department->slug }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $department->status_label }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Display Order</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $department->display_order }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $department->created_at->format('M j, Y g:i A') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $department->updated_at->format('M j, Y g:i A') }}</dd>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            @if($department->email || $department->phone || $department->location || $department->head_of_department)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Contact Information</h3>
                    
                    <div class="space-y-3">
                        @if($department->email)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $department->email }}</dd>
                            </div>
                        @endif
                        
                        @if($department->phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $department->phone }}</dd>
                            </div>
                        @endif
                        
                        @if($department->location)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $department->location }}</dd>
                            </div>
                        @endif
                        
                        @if($department->head_of_department)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Head of Department</dt>
                                <dd class="text-sm text-gray-900 dark:text-white">{{ $department->head_of_department }}</dd>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Quick Actions</h3>
                
                <div class="space-y-2">
                    @if($department->is_active)
                        <form method="POST" action="{{ route('admin.departments.update', $department) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $department->name }}">
                            <input type="hidden" name="is_active" value="0">
                            <button type="submit" class="w-full px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition-colors">
                                Deactivate
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.departments.update', $department) }}" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="name" value="{{ $department->name }}">
                            <input type="hidden" name="is_active" value="1">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                                Activate
                            </button>
                        </form>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.departments.destroy', $department) }}" 
                          class="w-full" onsubmit="return confirm('Are you sure you want to delete this department? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            Delete Department
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

