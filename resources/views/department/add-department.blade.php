<x-layout-app page-title="Novo Departamento">

    <div class="w-25 p-4">

        <h3>Novo departmento</h3>

        <hr>

        <form action="{{ route('departments.create') }}" method="post">

            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome do departamento</label>
                <input type="text" class="form-control" id="name" name="name">
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="d-flex gap-3 justify-content-end">
                    <a href="{{ route('departments') }}" class="btn btn-outline-danger me-3">Cancelar</a>
                    <button type="submit" class="btn btn-outline-primary">Criar departamento</button>
                </div>
            </div>

        </form>

    </div>
</x-layout-app>
