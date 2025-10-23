<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_name',
        'contact_person_title',
        'contact_person_name',
        'contact_person_phone_1',
        'contact_person_phone_2',
        'contact_person_email',
        'contact_person_designation',
    ];
}
