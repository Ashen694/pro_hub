<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentProject extends Model
{
    use HasFactory;

    protected $table = 'ParentProject';
    protected $primaryKey = 'ParentProjectID';

    public function internalPlatforms()
    {
        return $this->hasMany(InternalPlatform::class, 'ParentProjectID', 'ParentProjectID');
    }
}
