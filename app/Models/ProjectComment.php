<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectComment extends Model
{
    use HasFactory;

    protected $table = 'Project_Comments';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'Activity_ID',
        'Comment',
        'Updated_By',
    ];

    // Relationships
    public function activity()
    {
        return $this->belongsTo(ProjectActivity::class, 'Activity_ID', 'ID');
    }

    public function updater()
    {
        
        return $this->belongsTo(\App\Models\User::class, 'Updated_By', 'id');
    }
}