<x-layout-app page-title="Colaboradores">

    <div class="w-100 p-4">

        <h3>Todos os colaboradores</h3>

        <hr>

        @if ($colaborators->count() === 0)
            <div class="text-center my-5">
                <p>Nenhum colaborador encontrado</p>
            </div>
        @else
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
                                    <span class="badge bg-danger">No</span>
                                @else
                                    <span class="badge bg-success">Yes</span>
                        @endif
                        </td>
                        <td>{{ $colaborator->department->name ?? "Sem departamento" }}</td>
                        <td>{{ $colaborator->name }}</td>
                        <td>{{ $colaborator->detail->admission_date }}</td>
                        <td>{{ $colaborator->detail->salary }}</td>
                        <td>
                            <div class="d-flex gap-3 justify-content-end">
                               
                                @if (empty($colaborator->deleted_at))
                                    <a href="{{ route('colaborators.details', ['id' => $colaborator->id]) }}"
                                        class="btn btn-sm btn-outline-dark">
                                        <i class="fas fa-eye me-2"></i>
                                        Detalhes
                                    </a>
                                    <a href="{{ route('colaborators.delete', ['id' => $colaborator->id]) }}"
                                        class="btn btn-sm btn-outline-dark">
                                        <i class="fa-regular fa-trash-can me-2"></i>
                                        Delete
                                    </a>
                                @else
                                    <a href="{{ route('colaborators.restore', ['id' => $colaborator->id]) }}"
                                        class="btn btn-sm btn-outline-dark">
                                        <i class="fa-solid fa-trash-arrow-up me-2"></i>
                                        Restore
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
        <!-- table -->
    </x-layout-app>
