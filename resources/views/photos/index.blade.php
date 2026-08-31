<x-layout.layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-pink-50/50 min-h-[80vh]">
        <div class="max-w-3xl mx-auto space-y-10">
            <div class="text-center">
                <h1 class="text-3xl font-extrabold text-pink-600 tracking-tight">Ami's Photos 📸</h1>
                <p class="mt-2 text-sm text-pink-400 font-medium">Share your favorite moments in the garden</p>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-xl border-4 border-pink-200">
                <h2 class="text-lg font-bold text-pink-600 mb-4">Post a new photo</h2>
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-500">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-bold text-pink-300 uppercase tracking-widest">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="input input-bordered w-full rounded-2xl" />
                    </div>
                    <div>
                        <label class="text-xs font-bold text-pink-300 uppercase tracking-widest">Alt text</label>
                        <input type="text" name="alt" value="{{ old('alt') }}" class="input input-bordered w-full rounded-2xl" />
                    </div>
                    <div>
                        <label class="text-xs font-bold text-pink-300 uppercase tracking-widest">Description</label>
                        <textarea name="description" class="textarea textarea-bordered w-full rounded-2xl">{{ old('description') }}</textarea>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-pink-300 uppercase tracking-widest">Photo</label>
                        <input type="file" name="photo" accept="image/*" class="file-input file-input-bordered w-full rounded-2xl" />
                    </div>
                    <button type="submit" class="btn bg-pink-500 hover:bg-pink-600 border-none text-white rounded-2xl shadow-lg shadow-pink-200 py-3 text-lg font-bold w-full">
                        Post Photo 🐾
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @forelse ($photos as $photo)
                    <div class="bg-white rounded-3xl shadow-xl border-4 border-pink-200 overflow-hidden">
                        <img src="{{ Storage::url($photo->src) }}" alt="{{ $photo->alt }}" class="w-full h-56 object-cover" />
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-pink-700">{{ $photo->title }}</h3>
                            <p class="text-sm text-pink-400 mt-1">{{ $photo->description }}</p>
                            <p class="text-xs text-pink-300 mt-2">Posted by {{ $photo->user->name }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-pink-400 col-span-2">No photos yet. Be the first to post one!</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layout.layout>
