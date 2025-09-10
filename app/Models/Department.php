<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function users()
    {
        // cada departamento pode ter multiplos usuários
        return $this->belongsToMany(User::class);
    }
}
