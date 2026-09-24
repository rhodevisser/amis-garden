<x-layout.layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-pink-50/50 min-h-[80vh]">
        <div class="max-w-3xl mx-auto space-y-10">
            <div class="flex justify-between items-center">
                <div class="text-left">
                    <h1 class="text-3xl font-extrabold text-pink-600 tracking-tight">Ami's Photos 📸</h1>
                    <p class="mt-1 text-sm text-pink-400 font-medium">Share your favorite moments in the garden</p>
                </div>
                <button onclick="document.getElementById('uploader-section').classList.toggle('hidden')" class="btn btn-circle bg-pink-500 hover:bg-pink-600 border-none text-white shadow-lg shadow-pink-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>

            <div id="uploader-section" class="hidden bg-white p-8 rounded-3xl shadow-xl border-4 border-pink-200">
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

            <div class="space-y-8 max-w-xl mx-auto">
                @forelse ($photos as $photo)
                    <a href="{{ route('photos.show', $photo) }}" class="bg-white rounded-3xl shadow-xl border-4 border-pink-200 overflow-hidden block hover:shadow-2xl transition-shadow">
                        <img src="{{ Storage::url($photo->src) }}" alt="{{ $photo->alt }}" class="w-full aspect-square object-cover" />
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-pink-700">{{ $photo->title }}</h3>
                            <p class="text-pink-500 mt-2">{{ $photo->description }}</p>
                            <div class="flex items-center mt-4 pt-4 border-t border-pink-100">
                                <div class="text-xs text-pink-400">
                                    <span class="font-bold">Posted by {{ $photo->user_id === auth()->id() ? 'you' : $photo->user->name }}</span>
                                    <span class="mx-1">&middot;</span>
                                    <span>{{ $photo->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-center text-pink-400">No photos yet. Be the first to post one!</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layout.layout>
