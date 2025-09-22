<x-layout-app page-title="New RH User">

    <div class="w-100 p-4">

        <h3>Editar Colaborador do RH</h3>

        <hr>

        <form action="{{ route('users.rh.update') }}" method="post">

            @csrf

            <div class="d-flex gap-5">
                <p>Nome: <strong>{{ $colaborator->name }}</strong></p>
                <p>Email: <strong>{{ $colaborator->email }}</strong></p>
            </div>

            <hr>

            <input type="hidden" name="user_id" value="{{ $colaborator->id }}">

            <div class="container-fluid">
                <div class="row gap-3">
                    <x-colaborator-profile :colaborator="$colaborator" :departments="$departments" />
                    <x-colaborator-detail :colaborator="$colaborator" />
                </div>
                <div class="mt-3">
                    <a href="{{ route('users.rh') }}" class="btn btn-outline-danger me-3">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>
            </div>
        </form>
    </div>
</x-layout-app>
