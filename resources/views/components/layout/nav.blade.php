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
                <form action="/api/logout" method="POST">
                    @csrf
                    <button>Log Out</button>
                </form>
            @endauth

            @guest
                <a href="/login" class="btn btn-ghost">Sign In</a>
                <a href="/register/key" class="btn btn-accent">Register</a>
            @endguest
        </div>
    </div>
</nav>


