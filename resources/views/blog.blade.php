<x-app-layout>
    <!-- Hero Section with Overlay -->
    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center z-0"
             style="background-image: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-transparent"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-block mb-6">
                    <span class="text-red-primary font-bold text-lg tracking-wider">WHO WE ARE</span>
                </div>
                <h1 class="text-6xl md:text-7xl font-bold text-white mb-6 leading-tight">
                    Blog
                </h1>
                <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                    For over a decade, we've been partnering with communities across Rwanda to create sustainable change
                    through education, healthcare, and empowerment.
                </p>
                <div class="flex gap-4">
                    <a href="{{ route('projects.index') }}"
                       class="px-8 py-4 bg-red-primary hover:bg-red-700 text-white font-semibold rounded-lg transition-all shadow-lg hover:shadow-xl">
                        Our Work
                    </a>

                </div>
            </div>
        </div>


    </section>

</x-app-layout>
