<x-layout-app page-title="Deletar Colaborador">
    <div class="w-25 p-4">
        <h3>Deletar colaborador</h3>
        <hr>
        <p>Deseja realmente deletar este colaborador?</p>
        <div class="text-center">
            <h3 class="my-5">{{ $colaborator->name }}</h3>
            <p>{{ $colaborator->email }}</p>
            <a href="{{ route('rh.management.home') }}" class="btn btn-secondary px-5">Não</a>
            <a href="{{ route('rh.management.delete-confirm', ['id' => $colaborator->id]) }}" class="btn btn-danger px-5">Sim</a>
        </div>
    </div>
</x-layout-app>