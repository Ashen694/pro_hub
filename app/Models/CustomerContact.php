<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model
{
    protected $fillable = [
        'company_id',
        'external_platform_id',
        'title',
        'name',
        'email',
        'phone',
        'role',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function externalPlatform()
    {
        return $this->belongsTo(ExternalPlatform::class, 'external_platform_id', 'platform_id');
    }
}
