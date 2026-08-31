<nav class="border-b border-base-300 px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div>
            <a class="text-2xl"
                href="/">
                AMI's GARDEN <3
            </a>
        </div>

        <div class="flex gap-x-4">

            @auth
                <a href="{{ route('photos.index') }}" class="btn btn-ghost">
                    Photos
                </a>
                <form action="/logout" class="btn btn-ghost" method="POST">
                    @csrf
                    <button>Log Out</button>
                </form>
                <a href="{{ route('user.show', auth()->user()) }}" class="btn btn-ghost">
                    My Profile
                </a>
            @endauth

        </div>
    </div>
</nav>


