<x-layout-app page-title="New RH User">

    <div class="w-100 p-4">

        <h3>Editar Colaborator RH</h3>

        <hr>

        <form action="{{ route('colaborators.rh-update') }}" method="post">

            @csrf

            <div class="d-flex gap-5">
                <p>Nome: <strong>{{ $colaborator->name }}</strong></p>
                <p>Email: <strong>{{ $colaborator->email }}</strong></p>
            </div>

            <hr>

            <input type="hidden" name="user_id" value="{{ $colaborator->id }}">

            <div class="container-fluid">
                <div class="row gap-3">

                    {{-- user --}}
                    <div class="col border border-black p-4">

                        <div class="col">
                            <div class="mb-3">
                                <label for="select_department">Department</label>
                                <select class="form-select" id="select_department" name="select_department">
                                    @foreach ($departments as $department)
                                        @if ($department->id === 2)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('select_department')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label for="admission_date" class="form-label">Admission Date</label>
                                <input type="text" class="form-control" id="admission_date" name="admission_date"
                                    placeholder="YYYY-mm-dd"
                                    value="{{ old('admission_date', $colaborator->detail->admission_date) }}">
                                @error('admission_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <p class="mb-3">Perfil: <strong>Human Resources</strong></p>

                    </div>

                </div>

                <div class="mt-3">
                    <a href="{{ route('colaborators.rh') }}" class="btn btn-outline-danger me-3">Cancel</a>
                    <button type="submit" class="btn btn-primary">Atualizar colaborador</button>
                </div>

            </div>

        </form>

    </div>

</x-layout-app>
