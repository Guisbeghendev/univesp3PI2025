@extends($layout) <!-- Usa o layout dinâmico passado -->

@section('title', 'Página Inicial')

@section('content')

{{-- flexbox para centralizar o conteudo --}}
<div class="w-full flex justify-center items-center py-10">

    {{--container que encapsula o conteudo --}}
    <div class="container">

        <div class="flex flex-col lg:flex-row gap-3">
            <!-- Coluna 1 - Texto com Card -->
            <div class=" w-full lg:w-1/2 flex items-center justify-center">
                <!-- Card com classe reutilizável -->
                <div class="card-box">
                    <div class="w-full flex items-center justify-center flex-col">
                        <h2 class="text-xl text-verde font-bold">Bem-vindo à Treine & Nutre!</h2>
                        <p>Aqui você encontra profissionais qualificados para atingir seus objetivos e conquistar o desempenho físico que sempre quis!
                        </p>
                    </div>

                    <!-- Espaço entre o texto e os botões -->
                    <div class="w-full flex items-center justify-center gap-5 mt-5">
                        <a href="{{ route('register') }}" class="btn-padrao">
                            Cadastre-se já!
                        </a>
                        <a href="{{ route('login') }}" class="btn-padrao">
                            Faça login!
                        </a>
                    </div>

                </div>
            </div>

            <!-- Coluna 2 - Carrossel -->
            <div class="w-full lg:w-1/2 flex justify-center">
                <!-- Carrossel -->
                <div class="relative w-full sm:w-[350px] md:w-[400px] lg:w-[500px] overflow-hidden rounded-lg">
                    <div class="slides flex transition-transform duration-500 ease-in-out w-full">
                        <!-- Slide 1 -->
                        <div class="slide w-full h-[180px] sm:h-[200px] md:h-[220px] lg:h-[250px] flex-shrink-0">
                            <img src="{{ asset('images/BANNER/1.png') }}" class="w-full h-full object-contain" alt="Banner 1">
                        </div>
                        <!-- Slide 2 -->
                        <div class="slide w-full h-[180px] sm:h-[200px] md:h-[220px] lg:h-[250px] flex-shrink-0">
                            <img src="{{ asset('images/BANNER/2.png') }}" class="w-full h-full object-contain" alt="Banner 2">
                        </div>
                        <!-- Slide 3 -->
                        <div class="slide w-full h-[180px] sm:h-[200px] md:h-[220px] lg:h-[250px] flex-shrink-0">
                            <img src="{{ asset('images/BANNER/3.png') }}" class="w-full h-full object-contain" alt="Banner 3">
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const slides = document.querySelectorAll('.slide'); // Seleciona todas as imagens
        let currentIndex = 0;

        // Esconde todas as imagens, exceto a atual
        function showSlide(index) {
            slides.forEach((slide, i) => {
                if (i === index) {
                    slide.style.display = "block"; // Exibe a imagem atual
                } else {
                    slide.style.display = "none"; // Oculta as outras imagens
                }
            });
        }

        // Função para avançar para o próximo slide
        function showNextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex);
        }

        // Inicializa o carrossel
        showSlide(currentIndex);

        // Altera a imagem a cada 3 segundos
        setInterval(showNextSlide, 3000);
    });
</script>
@endpush
