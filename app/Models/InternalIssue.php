<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalIssue extends Model
{
    use HasFactory;

    protected $table = 'internal_issues';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'Issue_Start_Time',
        'Internal_APP_ID',  
        'Reported_By',
        'Description',
        'Entered_By',
        'Assigned_To',
        'Assigned_By',
        'Assigned_Time',
        'Status',
        'Issue_Closed_Time',
        'Action_Taken',
        'Reporting_Person_ContactNo',  
        'Criticality',
    ];
}