@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <li class="inline-flex items-center">
        <span class="text-gray-500 dark:text-gray-400">Dashboard</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Welcome to the admin panel. Here's an overview of your content.</p>
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Last updated: {{ now()->format('M j, Y g:i A') }}
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        <!-- Total Blogs -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totals']['blogs'] }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Blogs</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">{{ $stats['published']['blogs'] }} published</p>
                </div>
            </div>
        </div>

        <!-- Total Projects -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totals']['projects'] }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Projects</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">{{ $stats['published']['projects'] }} published</p>
                </div>
            </div>
        </div>

        <!-- Total Notices -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totals']['notices'] }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Notices</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">{{ $stats['published']['notices'] }} published</p>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totals']['users'] }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Users</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $stats['recent_activity']['users']->where('is_admin', true)->count() }} admins</p>
                </div>
            </div>
        </div>

        <!-- Total Departments -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totals']['departments'] }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Departments</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">{{ $stats['active']['departments'] }} active</p>
                </div>
            </div>
        </div>

        <!-- Total Teams -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-pink-100 dark:bg-pink-900">
                    <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totals']['teams'] }}</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Team Members</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Total members</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends Chart -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Content Creation Trends ({{ now()->year }})</h3>
        </div>
        <div class="h-64 flex items-end gap-2">
            @foreach($stats['monthly_trends'] as $month)
                <div class="flex-1 flex flex-col items-center gap-2">
                    <div class="w-full flex flex-col gap-1 justify-end" style="height: 200px;">
                        @php
                            $maxValue = max(
                                max(array_column($stats['monthly_trends'], 'blogs')),
                                max(array_column($stats['monthly_trends'], 'projects')),
                                max(array_column($stats['monthly_trends'], 'notices'))
                            );
                            $blogsHeight = $maxValue > 0 ? ($month['blogs'] / $maxValue) * 100 : 0;
                            $projectsHeight = $maxValue > 0 ? ($month['projects'] / $maxValue) * 100 : 0;
                            $noticesHeight = $maxValue > 0 ? ($month['notices'] / $maxValue) * 100 : 0;
                        @endphp
                        <div class="w-full bg-blue-500 rounded-t hover:bg-blue-600 transition-colors" style="height: {{ $blogsHeight }}%;" title="Blogs: {{ $month['blogs'] }}"></div>
                        <div class="w-full bg-green-500 hover:bg-green-600 transition-colors" style="height: {{ $projectsHeight }}%;" title="Projects: {{ $month['projects'] }}"></div>
                        <div class="w-full bg-yellow-500 rounded-b hover:bg-yellow-600 transition-colors" style="height: {{ $noticesHeight }}%;" title="Notices: {{ $month['notices'] }}"></div>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400 font-medium">{{ $month['month'] }}</span>
                </div>
            @endforeach
        </div>
        <div class="flex items-center justify-center gap-6 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-blue-500 rounded"></div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Blogs</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-green-500 rounded"></div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Projects</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 bg-yellow-500 rounded"></div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Notices</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Blogs -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Blogs</h3>
                <a href="{{ route('admin.blogs.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">View All</a>
            </div>
            <div class="p-6">
                @if($stats['recent_activity']['blogs']->count() > 0)
                    <div class="space-y-3">
                        @foreach($stats['recent_activity']['blogs'] as $blog)
                            <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 dark:text-white truncate">{{ $blog->title }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $blog->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full ml-3 flex-shrink-0 {{ $blog->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                    {{ ucfirst($blog->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No blogs yet.</p>
                @endif
            </div>
        </div>

        <!-- Recent Projects -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Projects</h3>
                <a href="{{ route('admin.projects.index') }}" class="text-sm text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium">View All</a>
            </div>
            <div class="p-6">
                @if($stats['recent_activity']['projects']->count() > 0)
                    <div class="space-y-3">
                        @foreach($stats['recent_activity']['projects'] as $project)
                            <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 dark:text-white truncate">{{ $project->title }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $project->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full ml-3 flex-shrink-0 {{ $project->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No projects yet.</p>
                @endif
            </div>
        </div>

        <!-- Recent Notices -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Notices</h3>
                <a href="{{ route('admin.notices.index') }}" class="text-sm text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 font-medium">View All</a>
            </div>
            <div class="p-6">
                @if($stats['recent_activity']['notices']->count() > 0)
                    <div class="space-y-3">
                        @foreach($stats['recent_activity']['notices'] as $notice)
                            <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 dark:text-white truncate">{{ $notice->title }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $notice->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full ml-3 flex-shrink-0 {{ $notice->status === \App\Enum\Notices\Status::Published ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200' }}">
                                    {{ ucfirst($notice->status->value) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No notices yet.</p>
                @endif
            </div>
        </div>

        <!-- Recent Users -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Users</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium">View All</a>
            </div>
            <div class="p-6">
                @if($stats['recent_activity']['users']->count() > 0)
                    <div class="space-y-3">
                        @foreach($stats['recent_activity']['users'] as $user)
                            <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium text-gray-900 dark:text-white truncate">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                                @if($user->is_admin)
                                    <span class="px-2 py-1 text-xs rounded-full ml-3 flex-shrink-0 bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                        Admin
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">No users yet.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
            <a href="{{ route('admin.blogs.create') }}" class="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-900 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-blue-700 dark:text-blue-300 font-medium text-sm text-center">New Blog</span>
            </a>
            
            <a href="{{ route('admin.projects.create') }}" class="flex flex-col items-center p-4 bg-green-50 dark:bg-green-900 rounded-lg hover:bg-green-100 dark:hover:bg-green-800 transition-colors">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-green-700 dark:text-green-300 font-medium text-sm text-center">New Project</span>
            </a>
            
            <a href="{{ route('admin.notices.create') }}" class="flex flex-col items-center p-4 bg-yellow-50 dark:bg-yellow-900 rounded-lg hover:bg-yellow-100 dark:hover:bg-yellow-800 transition-colors">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-yellow-700 dark:text-yellow-300 font-medium text-sm text-center">New Notice</span>
            </a>
            
            <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center p-4 bg-purple-50 dark:bg-purple-900 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-800 transition-colors">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-purple-700 dark:text-purple-300 font-medium text-sm text-center">New User</span>
            </a>

            <a href="{{ route('admin.departments.create') }}" class="flex flex-col items-center p-4 bg-indigo-50 dark:bg-indigo-900 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-800 transition-colors">
                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-indigo-700 dark:text-indigo-300 font-medium text-sm text-center">New Department</span>
            </a>

            <a href="{{ route('admin.teams.create') }}" class="flex flex-col items-center p-4 bg-pink-50 dark:bg-pink-900 rounded-lg hover:bg-pink-100 dark:hover:bg-pink-800 transition-colors">
                <svg class="w-6 h-6 text-pink-600 dark:text-pink-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span class="text-pink-700 dark:text-pink-300 font-medium text-sm text-center">New Team Member</span>
            </a>
        </div>
    </div>
</div>
@endsection
