<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentProject extends Model
{
    use HasFactory;

    protected $table = 'ParentProject';
    protected $primaryKey = 'ParentProjectID';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'ParentProjectGroup',
        'OperationScope',
    ];

    /**
     * Relationship
     */
    public function internalPlatforms()
    {
        return $this->hasMany(InternalPlatform::class, 'ParentProjectID', 'ParentProjectID');
    }



    /**
     * Accessor for 'name' attribute.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->ParentProjectGroup;
    }

    /**
     * Accessor for 'description' attribute.
     *
     * @return string|null
     */
    public function getDescriptionAttribute()
    {
        return $this->OperationScope;
    }
}