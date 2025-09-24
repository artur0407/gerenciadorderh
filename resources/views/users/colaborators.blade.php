<x-layout-app page-title="Colaboradores">

    <div class="w-100 p-4">

        <h3>Listagem de Colaboradores</h3>

        <hr>

        @if ($colaborators->count() === 0)
            <div class="text-center my-5">
                <p>Nenhum colaborador encontrado</p>
                <a href="{{ route('users.colaborators.new') }}" class="btn btn-primary">Criar um novo colaborador</a>
            </div>
        @else
            <div class="mb-3">
               <a href="{{ route('users.colaborators.new') }}" class="btn btn-primary">Criar um novo colaborador</a>
            </div>
            <table class="table" id="table">
                <thead class="table-dark">
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ativo</th>
                    <th>Departamento</th>
                    <th>Perfil</th>
                    <th>Admissão</th>
                    <th>Salário</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($colaborators as $colaborator)
                        <tr>
                            <td>{{ $colaborator->name }}</td>
                            <td>{{ $colaborator->email }}</td>
                            <td>
                                @empty($colaborator->email_verified_at)
                                    <span class="badge bg-danger">Não</span>
                                @else
                                    <span class="badge bg-success">Sim</span>
                        @endif
                        </td>
                        <td>{{ $colaborator->department->name ?? "Sem departamento" }}</td>
                        <td>{{ $colaborator->name }}</td>
                        <td>{{ $colaborator->detail->admission_date->format('d/m/Y') }}</td>
                        <td>{{ "R$ " . $colaborator->detail->salary }}</td>
                        <td>
                            <div class="d-flex gap-3 justify-content-end">

                                @if (empty($colaborator->deleted_at))
                                    <a href="{{ route('users.colaborators.details', ['id' => $colaborator->id]) }}"
                                        class="btn btn-sm btn-outline-dark">
                                        <i class="fas fa-eye me-2"></i>
                                        Detalhes
                                    </a>
                                    <a href="{{ route('users.colaborators.edit', ['id' => $colaborator->id]) }}"
                                        class="btn btn-sm btn-outline-dark">
                                        <i class="fa-regular fa-edit me-2"></i>
                                        Editar
                                    </a>
                                    <a href="{{ route('users.colaborators.delete', ['id' => $colaborator->id]) }}"
                                        class="btn btn-sm btn-outline-dark">
                                        <i class="fa-regular fa-trash-can me-2"></i>
                                        Deletar
                                    </a>
                                @else
                                    <a href="{{ route('users.colaborators.restore', ['id' => $colaborator->id]) }}"
                                        class="btn btn-sm btn-outline-dark">
                                     <i class="fa-solid fa-trash-arrow-up me-2"></i>
                                        Restaurar
                                    </a>
                                @endif

                            </div>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-layout-app>
