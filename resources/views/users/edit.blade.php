<x-layout.layout>
    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-pink-50/50">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border-4 border-pink-200 relative overflow-hidden">
            {{-- Decorative elements --}}
            <div class="absolute -top-6 -right-6 text-pink-100 opacity-50 rotate-12">
                <x-heroicon-s-sparkles class="w-24 h-24" />
            </div>
            <div class="absolute -bottom-6 -left-6 text-pink-100 opacity-50 -rotate-12">
                <x-heroicon-s-heart class="w-24 h-24" />
            </div>

            <div class="text-center relative">
                <div class="inline-flex items-center justify-center p-4 bg-pink-100 rounded-full mb-4 shadow-inner">
                    <span class="text-4xl">🐱</span>
                    <span class="text-4xl -ml-2">✍️</span>
                </div>
                <h1 class="text-3xl font-extrabold text-pink-600 tracking-tight">
                    Edit Profile
                </h1>
                <p class="mt-2 text-sm text-pink-400 font-medium">
                    Update your royal details
                </p>
            </div>

            {{-- Show validation errors --}}
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0 text-red-400">
                            <x-heroicon-s-x-circle class="h-5 w-5" />
                        </div>
                        <div class="ml-3 text-red-700 text-sm">
                            <ul class="list-disc space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('user.update', $user) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="space-y-4">
                    {{-- Name field --}}
                    <div>
                        <label class="block text-sm font-bold text-pink-700 mb-1 ml-1" for="name">
                            Royal Name
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            class="input input-bordered w-full border-pink-200 focus:border-pink-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50 rounded-2xl bg-pink-50/30"
                            required
                        >
                    </div>

                    {{-- Email field --}}
                    <div>
                        <label class="block text-sm font-bold text-pink-700 mb-1 ml-1" for="email">
                            Messenger Pigeon (Email)
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            class="input input-bordered w-full border-pink-200 focus:border-pink-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50 rounded-2xl bg-pink-50/30"
                            required
                        >
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="btn bg-pink-500 hover:bg-pink-600 border-none text-white rounded-2xl shadow-lg shadow-pink-200 py-3 text-lg font-bold">
                        Save Changes ✨
                    </button>

                    <a href="{{ route('user.show', $user) }}" class="text-sm font-medium text-pink-400 hover:text-pink-600 transition-colors text-center">
                        Cancel
                    </a>
                </div>
            </form>

            {{-- Bottom decoration --}}
            <div class="flex justify-center pt-4 border-t border-pink-100">
                <span class="text-pink-300 text-2xl">🐾 👑 🐾</span>
            </div>
        </div>
    </div>
</x-layout.layout>
