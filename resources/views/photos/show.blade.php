<x-layout.layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-pink-50/50 min-h-[80vh]">
        <div class="max-w-2xl mx-auto space-y-6">
            <a href="{{ route('photos.index') }}" class="text-sm font-medium text-pink-400 hover:text-pink-600 transition-colors">
                &larr; Back to all photos
            </a>

            <div class="bg-white rounded-3xl shadow-xl border-4 border-pink-200 overflow-hidden">
                <img src="{{ Storage::url($photo->src) }}" alt="{{ $photo->alt }}" class="w-full max-h-[70vh] object-cover" />
                <div class="p-6">
                    <h1 class="text-2xl font-extrabold text-pink-700">{{ $photo->title }}</h1>
                    <p class="text-sm text-pink-400 mt-2">{{ $photo->description }}</p>
                    <p class="text-xs text-pink-300 mt-4">Posted by {{ $photo->user->name }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layout.layout>
