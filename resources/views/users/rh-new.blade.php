<x-layout-app page-title="New RH User">

    <div class="w-100 p-4">

        <h3>Criar Novo Colaborador dos Recursos Humanos</h3>

        <hr>

        <form action="{{ route('users.rh.create') }}" method="post">

            @csrf

            <div class="container-fluid">

                <div class="row gap-3">
                    <x-colaborator-profile :colaborator="$colaborator ?? null" :departments="$departments" />
                    <x-colaborator-detail :colaborator="$colaborator ?? null" />
                </div>

                <div class="mt-3">
                    <a href="{{ route('users.rh') }}" class="btn btn-outline-danger me-3">Cancelar</a>
                    <button type="submit" class="btn btn-outline-primary">Criar</button>
                </div>

            </div>

        </form>

    </div>

</x-layout-app>
