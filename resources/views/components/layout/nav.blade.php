<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between">
        <div>
            <a class="text-2xl"
                href="/">
                AMI's GARDEN <3
            </a>
        </div>

        <div class="flex gap-x-4">

            @auth
                <form action="/logout" method="POST">
                    @csrf
                    <button>Log Out</button>
                </form>
            @endauth

            @guest
                <a href="/login" class="bg-base-100 rounded-t-none p-2">Sign In</a>
                <a href="/register-key" class="btn-accent">Register</a>
            @endguest
        </div>
    </div>
</nav>


