@extends($layout) <!-- Usa o layout dinâmico passado -->

@section('title', 'Sobre nós')

{{-- conteudo da pagina --}}
@section('content')

    {{-- flexbox para centralizar o conteudo --}}
    <div class="w-full flex justify-center items-center py-10">

        {{-- card comum que envolve todas as paginas --}}
        <div class="card-box">

            {{-- titulo da pagina --}}
            <h2 class="titulo-principal">sobre nós</h2>

            {{--container que encapsula o conteudo --}}
            <div class="container">
                <section class="text-justify space-y-4">
                    <p>
                        A Treine & Nutra surgiu em 2025 como um projeto acadêmico. Unindo ideias, valores e objetivos em comum, nossa plataforma tem a proposta de oferecer serviços de nutrição e condicionamento físico, conectando o público que busca mais qualidade de vida ou performance a profissionais qualificados e especializados da área.                    </p>
                    <p>
                        Nosso objetivo é proporcionar aos usuários uma experiência agradável na plataforma, permitindo a escolha de profissionais de acordo com o perfil e os objetivos individuais, com horários flexíveis e superando barreiras geográficas por meio de consultas e orientações online.
                    </p>
                    <p>
                        Já os profissionais da área podem explorar a plataforma como uma vitrine para seus serviços e especializações acadêmicas, além de utilizá-la como um meio de divulgar informações e novos estudos relacionados ao seu trabalho.
                    <p>
                        <strong>Seja você também um membro da Treine & Nutra!</strong>
                    </p>
                    </section>
            </div>

        </div>
    </div>
@endsection
