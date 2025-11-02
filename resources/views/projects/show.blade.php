<x-app-layout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white overflow-hidden">
        @if ($project->featured_image_url)
            <div class="absolute inset-0">
                <img src="{{ $project->featured_image_url }}" alt="{{ $project->title }}"
                    class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-gradient-to-br from-gray-900/80 via-gray-800/80 to-gray-900/80"></div>
            </div>
        @endif

        <div class="container mx-auto px-4 py-24 lg:py-32 relative">
            <div class="max-w-7xl mx-auto space-y-6">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                    {{ $project->title }}
                </h1>

                <p class="text-xl text-gray-300 leading-relaxed">
                    {{ $project->description }}
                </p>

                <!-- Project Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 pt-8 border-t border-white/20">
                    @if ($project->beneficiaries_count)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-primary">
                                {{ number_format($project->beneficiaries_count) }}</div>
                            <div class="text-sm text-gray-300">Beneficiaries</div>
                        </div>
                    @endif

                    @if ($project->budget)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-400">${{ number_format($project->budget) }}</div>
                            <div class="text-sm text-gray-300">Budget</div>
                        </div>
                    @endif

                    @if ($project->location)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-secondary">{{ $project->location }}</div>
                            <div class="text-sm text-gray-300">Location</div>
                        </div>
                    @endif

                    @if ($project->start_date)
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">{{ $project->start_date->format('Y') }}</div>
                            <div class="text-sm text-gray-300">Started</div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button onclick="openDonationModal()"
                        class="inline-flex items-center justify-center px-6 py-4 bg-primary text-white hover:bg-red-600 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Support This Project
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </button>
                    <button onclick="shareProject()"
                        class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white border-2 border-white/30 hover:bg-white/10 rounded-xl font-semibold transition-all duration-300">
                        Share Project
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Content -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Project Description -->
                        <div class="prose prose-lg max-w-none">
                            <h2 class="text-3xl font-bold text-gray-900 mb-6">About This Project</h2>
                            <div class="prose prose-lg prose-gray max-w-none text-gray-600 leading-relaxed">
                                {!! $project->content !!}
                            </div>
                        </div>

                        <!-- Project Gallery -->
                        @if ($project->gallery_image_urls && count($project->gallery_image_urls) > 0)
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Project Gallery</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($project->gallery_image_urls as $imageUrl)
                                        <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition-opacity"
                                            onclick="openImageModal('{{ $imageUrl }}')">
                                            <img src="{{ $imageUrl }}" alt="Project gallery image"
                                                class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-8">
                        <!-- Quick Info -->
                        <div class="bg-gray-50 rounded-2xl p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Project Details</h3>
                            <div class="space-y-4">
                                @if ($project->location)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                        </svg>
                                        <div>
                                            <div class="text-sm text-gray-500">Location</div>
                                            <div class="font-medium text-gray-900">{{ $project->location }}</div>
                                        </div>
                                    </div>
                                @endif

                                @if ($project->start_date)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <div>
                                            <div class="text-sm text-gray-500">Start Date</div>
                                            <div class="font-medium text-gray-900">
                                                {{ $project->start_date->format('F j, Y') }}</div>
                                        </div>
                                    </div>
                                @endif

                                @if ($project->end_date)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <div>
                                            <div class="text-sm text-gray-500">End Date</div>
                                            <div class="font-medium text-gray-900">
                                                {{ $project->end_date->format('F j, Y') }}</div>
                                        </div>
                                    </div>
                                @endif

                                @if ($project->budget)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                            </path>
                                        </svg>
                                        <div>
                                            <div class="text-sm text-gray-500">Budget</div>
                                            <div class="font-medium text-gray-900">
                                                ${{ number_format($project->budget) }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Support This Project -->
                        <div class="bg-red-50 rounded-2xl p-6 border border-red-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Support This Project</h3>
                            <p class="text-gray-600 mb-6">Your contribution can make a real difference in the lives of
                                those we serve.</p>
                            <button onclick="openDonationModal()"
                                class="w-full px-6 py-3 bg-red-primary text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                                Donate Now
                            </button>
                        </div>

                        <!-- Share Project -->
                        <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Share This Project</h3>
                            <p class="text-gray-600 mb-6">Help us spread the word about this important initiative.</p>
                            <div class="flex gap-2">
                                <button onclick="shareOnFacebook()"
                                    class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                    Facebook
                                </button>
                                <button onclick="shareOnTwitter()"
                                    class="flex-1 px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-colors text-sm">
                                    Twitter
                                </button>
                                <button onclick="copyLink()"
                                    class="flex-1 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors text-sm">
                                    Copy Link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Projects -->
    @if ($relatedProjects->count() > 0)
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Related Projects</h2>
                    <p class="text-lg text-gray-600">Discover other impactful initiatives in similar areas</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($relatedProjects as $relatedProject)
                        <div
                            class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="h-48 bg-gradient-to-br from-blue-500 to-blue-600 relative overflow-hidden">
                                @if ($relatedProject->featured_image_url)
                                    <img src="{{ $relatedProject->featured_image_url }}"
                                        alt="{{ $relatedProject->title }}" class="w-full h-full object-cover">
                                @endif
                                <div class="absolute inset-0 bg-black/20"></div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $relatedProject->title }}</h3>
                                <p class="text-gray-600 mb-4 line-clamp-3">{{ $relatedProject->description }}</p>
                                <a href="{{ route('projects.show', $relatedProject) }}"
                                    class="inline-flex items-center text-red-primary hover:text-red-700 font-medium text-sm">
                                    Learn more
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <! -- Donation Modal -->
        <div id="donationModal"
            class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">Support {{ $project->title }}</h3>
                    <button onclick="closeDonationModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <p class="text-gray-600">Choose an amount to donate to this project:</p>

                    <div class="grid grid-cols-3 gap-3">
                        <button onclick="selectAmount(25)"
                            class="donation-amount px-4 py-3 border border-gray-300 rounded-lg hover:border-red-primary hover:bg-red-50 transition-colors text-center">
                            $25
                        </button>
                        <button onclick="selectAmount(50)"
                            class="donation-amount px-4 py-3 border border-gray-300 rounded-lg hover:border-red-primary hover:bg-red-50 transition-colors text-center">
                            $50
                        </button>
                        <button onclick="selectAmount(100)"
                            class="donation-amount px-4 py-3 border border-gray-300 rounded-lg hover:border-red-primary hover:bg-red-50 transition-colors text-center">
                            $100
                        </button>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Custom Amount</label>
                        <input type="number" id="customAmount" placeholder="Enter amount"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-primary focus:border-transparent">
                    </div>

                    <button onclick="processDonation()"
                        class="w-full px-6 py-3 bg-red-primary text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                        Proceed to Payment
                    </button>
                </div>
            </div>
        </div>

        <!-- Image Modal -->
        <div id="imageModal"
            class="fixed inset-0 bg-black bg-opacity-90 hidden z-50 flex items-center justify-center p-4">
            <div class="relative max-w-4xl max-h-full">
                <button onclick="closeImageModal()"
                    class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <img id="modalImage" src="" alt="Project image"
                    class="max-w-full max-h-full object-contain rounded-lg">
            </div>
        </div>

        <script>
            // Donation Modal Functions
            function openDonationModal() {
                document.getElementById('donationModal').classList.remove('hidden');
            }

            function closeDonationModal() {
                document.getElementById('donationModal').classList.add('hidden');
            }

            function selectAmount(amount) {
                // Remove active class from all buttons
                document.querySelectorAll('.donation-amount').forEach(btn => {
                    btn.classList.remove('border-red-primary', 'bg-red-50');
                });

                // Add active class to selected button
                event.target.classList.add('border-red-primary', 'bg-red-50');

                // Clear custom amount
                document.getElementById('customAmount').value = '';

                // Store selected amount
                window.selectedAmount = amount;
            }

            function processDonation() {
                const customAmount = document.getElementById('customAmount').value;
                const amount = customAmount || window.selectedAmount;

                if (!amount) {
                    alert('Please select or enter a donation amount.');
                    return;
                }

                // Here you would integrate with your payment processor
                alert(`Thank you for your donation of $${amount}! Redirecting to payment...`);
                closeDonationModal();
            }

            // Image Modal Functions
            function openImageModal(imageSrc) {
                document.getElementById('modalImage').src = imageSrc;
                document.getElementById('imageModal').classList.remove('hidden');
            }

            function closeImageModal() {
                document.getElementById('imageModal').classList.add('hidden');
            }

            // Share Functions
            function shareProject() {
                if (navigator.share) {
                    navigator.share({
                        title: '{{ $project->title }}',
                        text: '{{ $project->description }}',
                        url: window.location.href
                    });
                } else {
                    copyLink();
                }
            }

            function shareOnFacebook() {
                const url = encodeURIComponent(window.location.href);
                const title = encodeURIComponent('{{ $project->title }}');
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&t=${title}`, '_blank');
            }

            function shareOnTwitter() {
                const url = encodeURIComponent(window.location.href);
                const text = encodeURIComponent('Check out this amazing project: {{ $project->title }}');
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
            }

            function copyLink() {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link copied to clipboard!');
                });
            }

            // Close modals when clicking outside
            document.addEventListener('click', function(event) {
                const donationModal = document.getElementById('donationModal');
                const imageModal = document.getElementById('imageModal');

                if (event.target === donationModal) {
                    closeDonationModal();
                }

                if (event.target === imageModal) {
                    closeImageModal();
                }
            });

            // Close modals with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeDonationModal();
                    closeImageModal();
                }
            });
        </script>
</x-app-layout>
