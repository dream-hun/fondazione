@extends('admin.layouts.app')

@section('title', 'View Report')

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
        <a href="{{ route('admin.reports.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            Reports
        </a>
    </li>
    <li class="inline-flex items-center">
        <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
        <span class="text-gray-500 dark:text-gray-400">{{ Str::limit($report->title, 40) }}</span>
    </li>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $report->title }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Report details</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.reports.edit', $report) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.reports.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</dt>
                    <dd class="mt-1 text-base text-gray-900 dark:text-white">{{ $report->title }}</dd>
                </div>

                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">PDF File</dt>
                    <dd class="mt-1 flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ basename($report->file_path) }}
                    </dd>
                </div>

                <div class="pt-4">
                    <a href="{{ Storage::url($report->file_path) }}" target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Report
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Status</h3>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($report->status->value === 'Published')
                        bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($report->status->value === 'Draft')
                        bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                    @else
                        bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @endif">
                    <span class="w-2 h-2 mr-2 rounded-full {{ $report->status->value === 'Published' ? 'bg-green-400' : ($report->status->value === 'Unpublished' ? 'bg-red-400' : 'bg-gray-400') }}"></span>
                    {{ $report->status->value }}
                </span>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Timestamps</h3>
                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <div><span class="font-medium">Created:</span> {{ $report->created_at->format('M j, Y g:i A') }}</div>
                    <div><span class="font-medium">Updated:</span> {{ $report->updated_at->format('M j, Y g:i A') }}</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form method="POST" action="{{ route('admin.reports.destroy', $report) }}"
                      onsubmit="return confirm('Are you sure you want to delete this report?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        Delete Report
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
