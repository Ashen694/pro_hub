<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalIssue extends Model
{
    use HasFactory;

    protected $table = 'external_issues';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'Issue_Start_Time',
        'Platform_ID',
        'Reported_By',
        'Description',
        'Criticality',
        'Entered_By',
        'Assigned_To',
        'Assigned_By',
        'Assigned_Time',
        'Status',
        'Issue_Closed_Time',
        'SLAduration',
        'SLAachived',
        'Action_Taken',
    ];
}