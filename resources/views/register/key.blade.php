<x-layout>
    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-pink-50/50">
        <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border-4 border-pink-200 relative overflow-hidden">
            {{-- Decorative elements --}}
            <div class="absolute -top-6 -right-6 text-pink-100 opacity-50 rotate-12">
                <x-heroicon-s-sparkles class="w-24 h-24" />
            </div>

            <div class="text-center relative">
                <div class="inline-flex items-center justify-center p-4 bg-pink-100 rounded-full mb-4 shadow-inner">
                    <span class="text-4xl">👑</span>
                </div>
                <h1 class="text-3xl font-extrabold text-pink-600 tracking-tight">
                    Royal Entrance
                </h1>
                <p class="mt-2 text-sm text-pink-400 font-medium">
                    Please enter your secret key to enter the garden.
                </p>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0 text-red-400">
                            <x-heroicon-s-x-circle class="h-5 w-5" />
                        </div>
                        <div class="ml-3 text-red-700 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register.validate-key') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-bold text-pink-700 mb-1 ml-1" for="key">
                        Secret Key
                    </label>
                    <input
                        type="text"
                        id="key"
                        name="key"
                        value="{{ old('key') }}"
                        placeholder="Enter your magic key"
                        class="input input-bordered w-full border-pink-200 focus:border-pink-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50 rounded-2xl bg-pink-50/30 text-center text-lg tracking-widest font-mono"
                        required
                        autofocus
                    >
                    <p class="mt-2 text-xs text-pink-400 text-center italic">
                        You should have received this key personally, little princess.
                    </p>
                </div>

                <button type="submit" class="btn bg-pink-500 hover:bg-pink-600 border-none text-white rounded-2xl shadow-lg shadow-pink-200 w-full py-3 text-lg font-bold">
                    Unlock Garden ✨
                </button>
            </form>

            {{-- Bottom decoration --}}
            <div class="flex justify-center pt-4 border-t border-pink-100">
                <span class="text-pink-300 text-2xl">🐾 🌸 🐾</span>
            </div>
        </div>
    </div>
</x-layout>
