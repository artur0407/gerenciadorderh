<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    public function user()
    {
        // cada usuário tem um(hasone) user_details ou cada user_details pertence(belongsto) a um usuário
        return $this->belongsTo(User::class);
    }
}
