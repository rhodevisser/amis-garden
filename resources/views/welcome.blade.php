<x-layout.layout>
    @if (session('success'))
        <div id="success-message" class="fixed bottom-4 right-4 z-50 animate-bounce">
            <div class="bg-pink-100 border-2 border-pink-300 text-pink-700 px-4 py-2 rounded-2xl shadow-lg">
                {{ session('success') }} ✨
            </div>
        </div>

        <script>
            setTimeout(() => {
                const message = document.getElementById('success-message');
                if (message) {
                    message.style.transition = 'opacity 0.5s ease';
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 500);
                }
            }, 5000);
        </script>
    @endif

    @auth
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
                        <span class="text-4xl -ml-2">✨</span>
                    </div>
                    <h1 class="text-3xl font-extrabold text-pink-600 tracking-tight">
                        Welkom in Amis garden!
                    </h1>
                    <p class="mt-2 text-sm text-pink-400 font-medium">
                        Welcome back, {{ auth()->user()->name }}! ✨
                    </p>
                </div>

                <div class="flex justify-center pt-4 border-t border-pink-100">
                    <span class="text-pink-300 text-2xl">🐾 👑 🐾</span>
                </div>
            </div>
        </div>
    @else
        <div class="min-h-[80vh] flex items-center justify-center">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-pink-600 mb-4">Ami's Garden</h1>
                <p class="text-pink-400 italic">Een magische plek voor kleine prinsessen...</p>
                <div class="mt-8 space-x-4">
                    <a href="/login" class="btn bg-pink-500 hover:bg-pink-600 border-none text-white rounded-2xl px-8">Login</a>
                    <a href="/register" class="btn btn-outline border-pink-500 text-pink-500 hover:bg-pink-50 hover:border-pink-600 rounded-2xl px-8">Register</a>
                </div>
            </div>
        </div>
    @endauth
</x-layout.layout>
