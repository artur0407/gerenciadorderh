<x-layout-app page-title="Colaborator details">

    <div class="w-100 p-4">

        <h3>Detalhes colaborador </h3>

        <hr>

        <div class="container-fluid">
            <div class="row mb-3">

                <div class="col">

                    <p>Name: <strong>{{ $colaborator->name }}</strong></p>
                    <p>Email: <strong>{{ $colaborator->email }}</strong></p>
                    <p>Role: <strong>{{ $colaborator->role }}</strong></p>
                    <p>Permissões: </p>

                    @php
                        $permissions = json_decode($colaborator->permissions)
                    @endphp
                    <ul>
                        @foreach ($permissions as $permission)
                            <li> {{ $permission }}</li>
                        @endforeach
                    </ul>

                    <p>Departamento: <strong>{{ $colaborator->department->name ?? "Sem departamento" }}</strong></p>
                    <p>Ativo: 
                        @empty($colaborator->email_verified_at)
                            <span class="badge bg-danger">No</span>
                        @else
                            <span class="badge bg-success">Yes</span>
                        @endif
                    </p>
                </div>

                <div class="col">
                    <p>Endereço: <strong>{{ $colaborator->detail->address }}</strong></p>
                    <p>CEP: <strong>{{ $colaborator->detail->zip_code }}</strong></p>
                    <p>Cidade: <strong>{{ $colaborator->detail->city }}</strong></p>
                    <p>Telefone: <strong>{{ $colaborator->detail->phone }}</strong></p>
                    <p>Data de Admissão: <strong>{{ $colaborator->detail->admission_date->format('d/m/Y') }}</strong></p>
                    <p>Salário: <strong>{{ "R$ " . $colaborator->detail->salary }}</strong></p>
                </div>
            </div>
        </div>

        @php
            $previousUrl = url()->previous();
            $backUrl = Str::contains($previousUrl, route('login')) ? route('user.profile') : $previousUrl;
            $backText = Str::contains($previousUrl, route('login')) ? 'Perfil' : 'Voltar';
        @endphp

        <a href="{{ $backUrl }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left me-2"></i>{{ $backText }}</a>

    </div>

</x-layout-app>