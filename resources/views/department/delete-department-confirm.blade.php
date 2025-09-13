<x-layout-app page-title="Deletar Departmento">
    <div class="w-25 p-4">
        <h3>Deletar departamento</h3>
        <hr>
        <p>Deseja realmente deletar este departmento?</p>
        <div class="text-center">
            <h3 class="my-5">{{ $department->name }}</h3>
            <a href="{{ route('departments') }}" class="btn btn-secondary px-5">No</a>
            <a href="{{ route('departments.delete-confirm', ['id' => $department->id]) }}" class="btn btn-danger px-5">Yes</a>
        </div>
    </div>
</x-layout-app>