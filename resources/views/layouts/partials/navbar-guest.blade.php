<!-- menu para user visitante não logado -->
<nav class="bg-cinza1 shadow-md flex justify-between items-center px-4">

    <div>
        <a href="{{ url('/') }}">
            <img src="{{ asset('/images/logo.png') }}" class="w-40 h-auto">
        </a>
    </div>


    <div class="flex gap-4 items-center">
        <a href="{{ url('/') }}" class="link-menu">Início</a>
        <a href="{{ url('/sobre') }}" class="link-menu">Sobre</a>
        <a href="{{ route('login') }}" class="link-menu">Entrar</a>
        <a href="{{ route('register') }}" class="link-menu">Cadastrar</a>
    </div>
</nav>
