<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldOfSpecialization extends Model
{
    protected $fillable = [
        'name',
        'notes',
    ];

    // The table name in migration is `fields_of_specializations`
    protected $table = 'fields_of_specializations';
}
