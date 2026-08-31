<x-layout.layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 bg-pink-50/50 min-h-[80vh]">
        <div class="max-w-2xl mx-auto space-y-6">
            <a href="{{ route('photos.show', $photo) }}" class="text-sm font-medium text-pink-400 hover:text-pink-600 transition-colors">
                &larr; Back to photo
            </a>

            <div class="bg-white p-8 rounded-3xl shadow-xl border-4 border-pink-200">
                <h2 class="text-lg font-bold text-pink-600 mb-4">Edit photo</h2>
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-500">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('photos.update', $photo) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="text-xs font-bold text-pink-300 uppercase tracking-widest">Title</label>
                        <input type="text" name="title" value="{{ old('title', $photo->title) }}" class="input input-bordered w-full rounded-2xl" />
                    </div>
                    <div>
                        <label class="text-xs font-bold text-pink-300 uppercase tracking-widest">Alt text</label>
                        <input type="text" name="alt" value="{{ old('alt', $photo->alt) }}" class="input input-bordered w-full rounded-2xl" />
                    </div>
                    <div>
                        <label class="text-xs font-bold text-pink-300 uppercase tracking-widest">Description</label>
                        <textarea name="description" class="textarea textarea-bordered w-full rounded-2xl">{{ old('description', $photo->description) }}</textarea>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-pink-300 uppercase tracking-widest">Photo</label>
                        <input type="file" name="photo" accept="image/*" class="file-input file-input-bordered w-full rounded-2xl" />
                    </div>
                    <button type="submit" class="btn bg-pink-500 hover:bg-pink-600 border-none text-white rounded-2xl shadow-lg shadow-pink-200 py-3 text-lg font-bold w-full">
                        Save changes 🐾
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout.layout>
