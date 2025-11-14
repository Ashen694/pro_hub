<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectActivity extends Model
{
    use HasFactory;

    protected $table = 'Project_Activities';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Platform_ID',
        'Solution_ID',
        'Description',
        'Created_By',
        'Assigned_To',
        'Target_Date',
        'Status',
        'Updated_By',
        'Updated_Date'
    ];
    

    public function platform()
    {
        return $this->belongsTo(MainPlatform::class, 'Platform_ID', 'ID');
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'Created_By', 'id');
    }

    public function assignee()
    {
        return $this->belongsTo(Employee::class, 'Assigned_To', 'Emp_ID');
    }

    public function updater()
    {
        return $this->belongsTo(\App\Models\User::class, 'Updated_By', 'id');
    }

    public function comments()
    {
        return $this->hasMany(ProjectComment::class, 'Activity_ID', 'ID');
    }

    public function internalSolution()
    {
        return $this->belongsTo(InternalPlatform::class, 'Solution_ID', 'ID');
    }

    /**
     * Get the external solution associated with the project activity.
     */
    public function externalSolution()
    {
        return $this->belongsTo(ExternalPlatform::class, 'Solution_ID', 'platform_id');
    }
}