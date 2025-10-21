<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalProjectComment extends Model
{
    use HasFactory;
    protected $table = 'Internal_Project_Comments';
    protected $primaryKey = 'ID';
    protected $fillable = ['Solution_ID', 'Comment', 'Updated_By', 'Updated_Time'];
}