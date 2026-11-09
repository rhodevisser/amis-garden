<x-layout.layout>
    <div class="min-h-[80vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-pink-50/50">
        <div class="max-w-2xl w-full space-y-8 bg-white p-10 rounded-3xl shadow-xl border-4 border-pink-200 relative overflow-hidden">
            {{-- Decorative elements --}}
            <div class="absolute -top-6 -right-6 text-pink-100 opacity-50 rotate-12">
                <x-heroicon-s-sparkles class="w-24 h-24" />
            </div>
            <div class="absolute -bottom-6 -left-6 text-pink-100 opacity-50 -rotate-12">
                <x-heroicon-s-heart class="w-24 h-24" />
            </div>

            <div class="text-center relative">
                <div class="inline-flex items-center justify-center p-4 bg-pink-100 rounded-full mb-4 shadow-inner">
                    <span class="text-4xl">🐾</span>
                </div>
                <h1 class="text-3xl font-extrabold text-pink-600 tracking-tight">
                    {{ $pet->name }}'s Profile
                </h1>
                <p class="mt-2 text-sm text-pink-400 font-medium">
                    Meet your furry friend
                </p>
            </div>

            <div class="space-y-6 relative">
                {{-- Pet Photo --}}
                <div class="rounded-2xl overflow-hidden border-4 border-pink-200 shadow-lg">
                    <img src="{{ Storage::url($pet->image) }}" alt="{{ $pet->name }}" class="w-full h-64 object-cover" />
                </div>

                {{-- Pet Details --}}
                <div class="bg-pink-50/30 p-6 rounded-2xl border-2 border-pink-100 space-y-4">
                    <div>
                        <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Name</h3>
                        <p class="text-lg font-bold text-pink-700 ml-1">{{ $pet->name }}</p>
                    </div>

                    <div class="pt-4 border-t border-pink-100">
                        <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Species</h3>
                        <p class="text-lg font-bold text-pink-700 ml-1">{{ $pet->species }}</p>
                    </div>

                    <div class="pt-4 border-t border-pink-100">
                        <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Breed</h3>
                        <p class="text-lg font-bold text-pink-700 ml-1">{{ $pet->breed }}</p>
                    </div>

                    <div class="pt-4 border-t border-pink-100">
                        <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Age</h3>
                        <p class="text-lg font-bold text-pink-700 ml-1">{{ $pet->age }} year{{ $pet->age !== 1 ? 's' : '' }}</p>
                    </div>

                    <div class="pt-4 border-t border-pink-100">
                        <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Gender</h3>
                        <p class="text-lg font-bold text-pink-700 ml-1">{{ $pet->gender ? 'Male' : 'Female' }}</p>
                    </div>

                    <div class="pt-4 border-t border-pink-100">
                        <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Description</h3>
                        <p class="text-lg text-pink-700 ml-1">{{ $pet->description }}</p>
                    </div>

                    <div class="pt-4 border-t border-pink-100">
                        <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Owner</h3>
                        <p class="text-lg font-bold text-pink-700 ml-1">
                            <a href="{{ route('user.show', $pet->owner) }}" class="hover:text-pink-500 transition-colors">
                                {{ $pet->owner->name }}
                            </a>
                        </p>
                    </div>

                    @if ($pet->coOwners->isNotEmpty())
                        <div class="pt-4 border-t border-pink-100">
                            <h3 class="text-xs font-bold text-pink-300 uppercase tracking-widest ml-1 mb-1">Co-Owners</h3>
                            <p class="text-lg text-pink-700 ml-1">
                                {{ $pet->coOwners->pluck('name')->join(', ') }}
                            </p>
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-3">
                    @if (auth()->id() === $pet->user_id)
                        <div class="flex gap-3">
                            <a href="{{ route('pets.edit', $pet) }}" class="btn bg-pink-500 hover:bg-pink-600 border-none text-white rounded-2xl shadow-lg shadow-pink-200 py-3 text-lg font-bold flex-1">
                                Edit Pet ✨
                            </a>
                            <form action="{{ route('pets.destroy', $pet) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn bg-red-500 hover:bg-red-600 border-none text-white rounded-2xl shadow-lg shadow-red-200 py-3 text-lg font-bold w-full"
                                    onclick="return confirm('Are you sure you want to remove this pet?')">
                                    Remove Pet
                                </button>
                            </form>
                        </div>
                    @endif

                    <a href="{{ route('user.show', $pet->owner) }}" class="text-sm font-medium text-pink-400 hover:text-pink-600 transition-colors text-center">
                        Back to Profile
                    </a>
                </div>
            </div>

            {{-- Bottom decoration --}}
            <div class="flex justify-center pt-4 border-t border-pink-100">
                <span class="text-pink-300 text-2xl">🐾 ✨ 🐾</span>
            </div>
        </div>
    </div>
</x-layout.layout>
