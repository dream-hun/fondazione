<x-app-layout>
    @section('title')
    Our Projects
    @endsection
    @section('description')
    Fondazione Marcegaglia Onlus Rwanda(FMO) is a non-profit organization that empowers women and communities in Rwanda. We have a range of projects that we are working on to help the community.
    @endsection
    <!-- Hero Section -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <img src="{{ asset('images/_DSC8103.jpg') }}"
             alt="About us"
             class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0  bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>

        <div class="container mx-auto max-w-7xl px-4 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-block mb-6">
                    <span class="text-red-primary font-bold text-lg tracking-wider">Our Projects</span>
                </div>
                <h1 class="text-6xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    Our Programs
                </h1>
                <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                    For over a decade, we've been partnering with communities across Rwanda to create sustainable change through education, healthcare, and empowerment.
                </p>

            </div>
        </div>

    </section>

    <!-- Projects Grid -->
    <section class="py-24 bg-white">
        <div class="container mx-auto max-w-7xl px-4">
            @if($projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($projects as $project)
                    <article class="flex flex-col items-start justify-between">
                        <div class="relative w-full">
                            <img src="{{ $project->featured_image_url }}"
                                alt="Blog post image"
                                class="aspect-video w-full rounded-2xl bg-gray-800 object-cover sm:aspect-[2/1] lg:aspect-[3/2]" />
                            <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-white/10"></div>
                        </div>
                        <div class="flex max-w-xl grow flex-col justify-between">
                            
                            <div class="group relative grow">
                                <h3 class="mt-3 text-lg font-semibold text-gray-800 group-hover:text-gray-900">
                                    <a href="{{ route('projects.show', $project->slug) }}">
                                        <span class="absolute inset-0"></span>
                                        {{ $project->title }}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm text-gray-400">{{$project->description}}</p>
                            </div>
                            
                        </div>
                    </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h6"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No projects found</h3>
                    <p class="text-gray-600 mb-6">Try adjusting your search criteria or check back later for new projects.</p>
                    <a href="{{ route('projects.index') }}"
                       class="inline-flex items-center px-6 py-3 bg-red-primary text-white rounded-lg hover:bg-red-700 transition-colors">
                        View all projects
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
