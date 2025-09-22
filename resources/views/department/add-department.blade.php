<x-layout-app page-title="Novo Departamento">

    <div class="w-50 p-4">

        <h3>Novo Departamento</h3>

        <hr>
        <div class="col card p-4">
            <form action="{{ route('departments.create') }}" method="post">

                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" name="name">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('departments') }}" class="btn btn-outline-danger me-3">Cancelar</a>
                        <button type="submit" class="btn btn-outline-primary">Criar</button>
                    </div>
                </div>

            </form>
        </div>

    </div>
</x-layout-app>
