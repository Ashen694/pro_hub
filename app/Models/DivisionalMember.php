<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionalMember extends Model
{
    protected $fillable = [
        'name',
        'division',
        'email',
        'position',
    ];
}
