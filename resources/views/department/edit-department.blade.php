<x-layout-app page-title="Novo Departamento">

    <div class="card w-25 p-4">

        <h3>Editar departamento</h3>

        <hr>

        <form action="{{ route('departments.update') }}" method="post">

            @csrf
            
            <input type="hidden" name="id" value="{{ $department->id }}">

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $department->name }}">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-3 justify-content-end">
                <a href="{{ route('departments') }}" class="btn btn-outline-danger me-3">Cancelar</a>
                <button type="submit" class="btn btn-outline-primary">Alterar departamento</button>
            </div>
        </form>

    </div>
</x-layout-app>
