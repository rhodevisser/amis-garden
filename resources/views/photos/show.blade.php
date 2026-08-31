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

                    @canany(['update', 'delete'], $photo)
                        <div class="flex gap-3 mt-6">
                            @can('update', $photo)
                                <a href="{{ route('photos.edit', $photo) }}" class="btn bg-pink-100 hover:bg-pink-200 border-none text-pink-600 rounded-2xl font-bold">
                                    Edit
                                </a>
                            @endcan
                            @can('delete', $photo)
                                <form action="{{ route('photos.destroy', $photo) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this photo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn bg-red-100 hover:bg-red-200 border-none text-red-600 rounded-2xl font-bold">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    @endcanany
                </div>
            </div>
        </div>
    </div>
</x-layout.layout>
