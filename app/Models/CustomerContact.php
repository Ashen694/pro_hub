<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'role',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
