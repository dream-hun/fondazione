<x-guest-layout>
    <div class="bg-gray-50">
        <div class="min-h-screen flex flex-col items-center justify-center py-6 px-4">
            <div class="max-w-[480px] w-full">
                <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="FMO Rwanda"
                        class="w-40 mb-8 mx-auto block" />
                </a>

                <div class="p-6 sm:p-8 rounded-2xl bg-white border border-gray-200 shadow-sm">
                    <h1 class="text-slate-900 text-center text-3xl font-semibold">Sign in</h1>
                    <form class="mt-12 space-y-6" method="POST" action="{{ route('login.store') }}">
                        @csrf
                        <div>
                            <x-input-label for="email" value="Email" required />
                            <x-input name="email" type="email" placeholder="Enter your email" required />
                            <x-input-error for="email" />
                        </div>
                        <div>
                            <x-input-label for="password" value="Password" required />
                            <x-input name="password" type="password" placeholder="Enter password" required />
                            <x-input-error for="password" />
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <x-checkbox id="remember" name="remember">Remember me</x-checkbox>
                            <div class="text-sm">
                                <a href="#" class="text-primary hover:underline font-semibold">
                                    Forgot your password?
                                </a>
                            </div>
                        </div>

                        <div class="!mt-12">
                            <x-button type="submit" class="w-full">Sign in</x-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
