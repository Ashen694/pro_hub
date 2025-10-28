<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetEndUser extends Model
{
    use HasFactory;
    protected $table = 'TargetEndUser';
    protected $primaryKey = 'ID';
    protected $fillable = ['EndUserType'];
}