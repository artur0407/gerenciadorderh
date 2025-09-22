<div class="col card border p-4">
    <div class="mb-3">
        <label for="Address" class="form-label">Endereço</label>
        <input type="text" class="form-control" id="address" name="address"
            value="{{ old('address', $colaborator?->detail->address) }}">
        @error('address')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="zip_code" class="form-label">CEP</label>
                <input type="text" class="form-control" id="zip_code" name="zip_code"
                    value="{{ old('zip_code', $colaborator?->detail->zip_code) }}">
                @error('zip_code')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="city" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="city" name="city"
                    value="{{ old('city', $colaborator?->detail->city) }}">
                @error('city')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="phone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="phone" name="phone"
                    value="{{ old('phone', $colaborator?->detail->phone) }}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="salary" class="form-label">Salário</label>
                <input type="number" class="form-control" id="salary" name="salary"
                    step=".01" placeholder="0,00" value="{{ old('salary', $colaborator?->detail->salary) }}">
                @error('salary')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="admission_date" class="form-label">Data de Admissão</label>
                <input type="text" class="form-control" id="admission_date" name="admission_date"
                    placeholder="YYYY-mm-dd" value="{{ old('admission_date', $colaborator?->detail->admission_date) }}">
                @error('admission_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
