<div class="space-y-3" data-gallery-uploader>
    <div
        data-gallery-dropzone
        tabindex="0"
        aria-label="Project gallery uploader"
        class="flex flex-col items-center justify-center px-6 py-8 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-center cursor-pointer transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 hover:border-blue-500 hover:bg-blue-50/40 dark:hover:bg-gray-700/40"
    >
        <div class="flex flex-col items-center gap-2 text-gray-600 dark:text-gray-300">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-5-9h2a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h2m4-2v8" />
            </svg>
            <p class="text-sm font-medium">Drag & drop images here</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">or</p>
            <button
                type="button"
                data-gallery-button
                class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Browse files
            </button>
        </div>
    </div>

    <input
        type="file"
        id="gallery_images"
        name="gallery_images[]"
        accept="image/*"
        multiple
        class="hidden"
        data-gallery-input
    >

    <p class="text-xs text-gray-500 dark:text-gray-400">
        Upload multiple images (2MB max each). Supported formats: JPG, PNG, GIF, WebP, AVIF.
    </p>

    <ul
        class="hidden grid grid-cols-2 gap-3 md:grid-cols-3"
        data-gallery-previews
    ></ul>

    @error('gallery_images')
        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror

    @error('gallery_images.*')
        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-gallery-uploader]').forEach((wrapper) => {
                    const dropzone = wrapper.querySelector('[data-gallery-dropzone]');
                    const input = wrapper.querySelector('[data-gallery-input]');
                    const browseButton = wrapper.querySelector('[data-gallery-button]');
                    const previews = wrapper.querySelector('[data-gallery-previews]');

                    if (!dropzone || !input || !previews) {
                        return;
                    }

                    const toggleHighlight = (state) => {
                        dropzone.classList.toggle('border-blue-500', state);
                        dropzone.classList.toggle('bg-blue-50/40', state);
                        dropzone.classList.toggle('dark:bg-gray-700/40', state);
                    };

                    const syncPreviews = () => {
                        previews.innerHTML = '';
                        const files = Array.from(input.files ?? []);

                        if (files.length === 0) {
                            previews.classList.add('hidden');
                            return;
                        }

                        previews.classList.remove('hidden');

                        files.forEach((file, index) => {
                            const item = document.createElement('li');
                            item.className = 'relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800';

                            const imageWrapper = document.createElement('div');
                            imageWrapper.className = 'aspect-square bg-gray-100 dark:bg-gray-900';

                            const img = document.createElement('img');
                            img.alt = `Selected image ${index + 1}`;
                            img.className = 'w-full h-full object-cover';

                            const reader = new FileReader();
                            reader.onload = (event) => {
                                img.src = event.target?.result;
                            };
                            reader.readAsDataURL(file);

                            const removeButton = document.createElement('button');
                            removeButton.type = 'button';
                            removeButton.className = 'absolute top-2 right-2 inline-flex items-center justify-center rounded-full bg-white/90 text-gray-700 hover:bg-red-500 hover:text-white p-1.5 shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500';
                            removeButton.setAttribute('aria-label', `Remove ${file.name}`);
                            removeButton.innerHTML = '<svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>';
                            removeButton.addEventListener('click', (event) => {
                                event.stopPropagation();
                                removeFileAt(index);
                            });

                            imageWrapper.appendChild(img);
                            item.appendChild(imageWrapper);
                            item.appendChild(removeButton);
                            previews.appendChild(item);
                        });
                    };

                    const mergeFiles = (incomingFiles) => {
                        if (incomingFiles.length === 0) {
                            return;
                        }

                        if (typeof DataTransfer === 'undefined') {
                            input.files = incomingFiles;
                            return syncPreviews();
                        }

                        const dataTransfer = new DataTransfer();
                        Array.from(input.files ?? []).forEach((file) => dataTransfer.items.add(file));
                        incomingFiles.forEach((file) => dataTransfer.items.add(file));
                        input.files = dataTransfer.files;
                        syncPreviews();
                    };

                    const removeFileAt = (index) => {
                        if (typeof DataTransfer === 'undefined') {
                            return;
                        }

                        const dataTransfer = new DataTransfer();
                        Array.from(input.files ?? []).forEach((file, currentIndex) => {
                            if (currentIndex !== index) {
                                dataTransfer.items.add(file);
                            }
                        });
                        input.files = dataTransfer.files;
                        syncPreviews();
                    };

                    const handleFiles = (fileList) => {
                        const validFiles = Array.from(fileList ?? []).filter((file) => file.type.startsWith('image/'));
                        mergeFiles(validFiles);
                    };

                    dropzone.addEventListener('click', (event) => {
                        if ((event.target instanceof HTMLElement) && event.target.closest('[data-gallery-button]')) {
                            return;
                        }

                        input.click();
                    });

                    dropzone.addEventListener('keydown', (event) => {
                        if (event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            input.click();
                        }
                    });

                    browseButton?.addEventListener('click', (event) => {
                        event.preventDefault();
                        input.click();
                    });

                    ['dragenter', 'dragover'].forEach((eventName) => {
                        dropzone.addEventListener(eventName, (event) => {
                            event.preventDefault();
                            event.stopPropagation();
                            toggleHighlight(true);
                        });
                    });

                    ['dragleave', 'drop'].forEach((eventName) => {
                        dropzone.addEventListener(eventName, (event) => {
                            event.preventDefault();
                            event.stopPropagation();
                            toggleHighlight(false);
                        });
                    });

                    dropzone.addEventListener('drop', (event) => {
                        if (!(event instanceof DragEvent)) {
                            return;
                        }

                        const files = event.dataTransfer?.files;
                        handleFiles(files);
                    });

                    input.addEventListener('change', () => syncPreviews());
                });
            });
        </script>
    @endpush
@endonce

