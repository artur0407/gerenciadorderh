<x-layout-app page-title="Deletar Colaborador">
    <div class="w-25 p-4">
        <h3>Deletar colaborador</h3>
        <hr>
        <p>Deseja realmente deletar este colaborador de RH?</p>
        <div class="text-center">
            <h3 class="my-5">{{ $colaborator->name }}</h3>
            <a href="{{ route('colaborators.rh') }}" class="btn btn-secondary px-5">No</a>
            <a href="{{ route('colaborators.rh-delete-confirm', ['id' => $colaborator->id]) }}" class="btn btn-danger px-5">Yes</a>
        </div>
    </div>
</x-layout-app>