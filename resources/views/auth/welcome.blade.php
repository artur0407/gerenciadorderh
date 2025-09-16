<x-layout-guest page-title="Bem vindo!">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">
                {{-- logo --}}
                <div class="text-center mb-5">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" title="Logo" width="200px">
                </div>

                {{-- welcome message --}}
                <div class="text-center card p-5">
                    <p>Bem vindo, <strong>{{ $user->name }}</strong>!</p>
                    <p>Sua conta foi criada com sucesso!</p>
                    <p>Você pode realizar <a href="{{ route('login') }}">login</a> na sua conta.</p>
                </div>
            </div>
        </div>
    </div>
</x-layout-guest>