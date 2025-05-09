<!-- menu para user logado -->
<nav class="bg-cinza1 shadow-md flex justify-between items-center px-4">


    <div>
        <a href="{{ url('/') }}">
            <img src="{{ asset('/images/logo.png') }}" class="w-40 h-auto">
        </a>
    </div>

    <div class="flex gap-4 items-center">
        <a href="{{ url('/') }}" class="link-menu">Início</a>
        <a href="{{ route('dashboard') }}" class="link-menu">Dashboard</a>
        <a href="{{ url('/sobre') }}" class="link-menu">Sobre</a>
        <a href="{{ route('profile.show') }}" class="link-menu">Perfil</a>

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-red-600 hover:underline">Sair</button>
        </form>
    </div>
</nav>
