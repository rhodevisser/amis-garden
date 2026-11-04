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
                    <span class="text-4xl">🐾</span>
                </div>
                <h1 class="text-3xl font-extrabold text-pink-600 tracking-tight">
                    Add a New Pet
                </h1>
                <p class="mt-2 text-sm text-pink-400 font-medium">
                    Tell us about your furry friend
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

            <form method="POST" action="{{ route('pets.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    {{-- Name field --}}
                    <div>
                        <label class="block text-sm font-bold text-pink-700 mb-1 ml-1" for="name">
                            Pet Name
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            class="input input-bordered w-full border-pink-200 focus:border-pink-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50 rounded-2xl bg-pink-50/30"
                            required
                        >
                    </div>

                    {{-- Species field --}}
                    <div>
                        <label class="block text-sm font-bold text-pink-700 mb-1 ml-1" for="species">
                            Species
                        </label>
                        <input
                            type="text"
                            id="species"
                            name="species"
                            value="{{ old('species') }}"
                            placeholder="e.g. Dog, Cat, Bird"
                            class="input input-bordered w-full border-pink-200 focus:border-pink-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50 rounded-2xl bg-pink-50/30"
                            required
                        >
                    </div>

                    {{-- Breed field --}}
                    <div>
                        <label class="block text-sm font-bold text-pink-700 mb-1 ml-1" for="breed">
                            Breed
                        </label>
                        <input
                            type="text"
                            id="breed"
                            name="breed"
                            value="{{ old('breed') }}"
                            class="input input-bordered w-full border-pink-200 focus:border-pink-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50 rounded-2xl bg-pink-50/30"
                            required
                        >
                    </div>

                    {{-- Age field --}}
                    <div>
                        <label class="block text-sm font-bold text-pink-700 mb-1 ml-1" for="age">
                            Age (years)
                        </label>
                        <input
                            type="number"
                            id="age"
                            name="age"
                            value="{{ old('age') }}"
                            min="0"
                            max="30"
                            class="input input-bordered w-full border-pink-200 focus:border-pink-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50 rounded-2xl bg-pink-50/30"
                            required
                        >
                    </div>

                    {{-- Gender field --}}
                    <div>
                        <label class="block text-sm font-bold text-pink-700 mb-1 ml-1">
                            Gender
                        </label>
                        <div class="flex gap-4 ml-1">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="gender" value="1" {{ old('gender') == 1 ? 'checked' : '' }} class="radio radio-pink" required>
                                <span class="text-pink-700">Male</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="gender" value="0" {{ old('gender') == 0 ? 'checked' : '' }} class="radio radio-pink">
                                <span class="text-pink-700">Female</span>
                            </label>
                        </div>
                    </div>

                    {{-- Description field --}}
                    <div>
                        <label class="block text-sm font-bold text-pink-700 mb-1 ml-1" for="description">
                            Description
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="3"
                            class="textarea textarea-bordered w-full border-pink-200 focus:border-pink-400 focus:ring focus:ring-pink-200 focus:ring-opacity-50 rounded-2xl bg-pink-50/30"
                            required
                        >{{ old('description') }}</textarea>
                    </div>

                    {{-- Image field --}}
                    <div>
                        <label class="block text-sm font-bold text-pink-700 mb-1 ml-1" for="image">
                            Photo
                        </label>
                        <input
                            type="file"
                            id="image"
                            name="image"
                            accept="image/*"
                            class="file-input file-input-bordered w-full rounded-2xl"
                            required
                        >
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" class="btn bg-pink-500 hover:bg-pink-600 border-none text-white rounded-2xl shadow-lg shadow-pink-200 py-3 text-lg font-bold">
                        Add Pet 🐾
                    </button>

                    <a href="{{ route('user.show', auth()->user()) }}" class="text-sm font-medium text-pink-400 hover:text-pink-600 transition-colors text-center">
                        Cancel
                    </a>
                </div>
            </form>

            {{-- Bottom decoration --}}
            <div class="flex justify-center pt-4 border-t border-pink-100">
                <span class="text-pink-300 text-2xl">🐾 ✨ 🐾</span>
            </div>
        </div>
    </div>
</x-layout.layout>
