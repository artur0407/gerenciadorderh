<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'zip_code', 'city', 'phone', 'salary', 'admission_date'];

    protected $casts = [
        'admission_date' => 'date',
    ];

    /**
     * Mutator to save salary decimal (1234.56).
     */
    protected function salary(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $this->convertToDecimal($value),
            get: fn ($value) => number_format($value, 2, ',', '.')
        );
    }

    public function getSalaryNumericAttribute()
    {
        if ($this->salary === null) return 0;

        // Remove pontos e troca vírgula por ponto
        $value = str_replace('.', '', $this->salary);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

    /**
     * Convert "1.234,56" para "1234.56".
     */
    private function convertToDecimal($value): ?float
    {
        if ($value === null) {
            return null;
        }

        // Remove pontos de milhar e troca vírgula por ponto
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

    public function user()
    {
        // cada usuário tem um(hasone) user_details ou cada user_details pertence(belongsto) a um usuário
        return $this->belongsTo(User::class);
    }
}
