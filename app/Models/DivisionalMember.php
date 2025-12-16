<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionalMember extends Model
{
    protected $fillable = [
        'name',
        'service_number',
        'email',
        'contact_mobile',
        'group_name',
        'date_of_birth',
        'calling_name',
        'gender',
        'section',
        'member_type',
        'division',
        'position',
    ];
}
