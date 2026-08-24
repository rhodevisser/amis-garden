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
                    <span class="text-4xl -ml-2">👑</span>
                </div>
                <h1 class="text-3xl font-extrabold text-pink-600 tracking-tight">
                    Royal Profile
                </h1>
                <p class="mt-2 text-sm text-pink-400 font-medium">
                    Profile details for Princess {{ $user->name }}
                </p>
            </div>

            <div class="space-y-6 relative">
                <div class="bg-pink-50/30 p-6 rounded-2xl border-2 border-pink-100 space-y-4">
                    <div>
                        <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Name</h3>
                        <p class="text-lg font-bold text-pink-700 ml-1">{{ $user->name }}</p>
                    </div>

                    <div class="pt-4 border-t border-pink-100">
                        <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Messenger Pigeon (Email)</h3>
                        <p class="text-lg font-bold text-pink-700 ml-1">{{ $user->email }}</p>
                    </div>

                    <div class="pt-4 border-t border-pink-100">
                        <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Joined the Garden</h3>
                        <p class="text-lg font-bold text-pink-700 ml-1">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <a href="{{ route('user.edit', $user) }}" class="btn bg-pink-500 hover:bg-pink-600 border-none text-white rounded-2xl shadow-lg shadow-pink-200 py-3 text-lg font-bold text-center">
                        Edit Profile ✨
                    </a>

                    <a href="/" class="text-sm font-medium text-pink-400 hover:text-pink-600 transition-colors text-center">
                        Back to the Garden
                    </a>
                </div>
            </div>

            {{-- Bottom decoration --}}
            <div class="flex justify-center pt-4 border-t border-pink-100">
                <span class="text-pink-300 text-2xl">🐾 👑 🐾</span>
            </div>
        </div>
    </div>
</x-layout.layout>
