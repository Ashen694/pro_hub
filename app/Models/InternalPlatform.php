<?php
// app/Models/InternalPlatform.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalPlatform extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Internal_Platforms';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'App_Name',
        'Developed_By',
        'Developed_Team',
        'StartDate',
        'TargetDate',
        'BIT_bucket_repo',
        'SDLCPhase',
        'PercentageDone',
        'Status',
        'Bus_Owner',
        'App_Category', // This is 'application_group' in the form
        'App_IP',
        'App_URL',
        'App_Users',
        'UATDate',
        'Integrated_apps',
        'DR',
        'LaunchedDate',
        'VADate',
        'WAF',
        'Price', // This is 'solution_value' in the form
        'EndUserType',
        'ParentProjectID',
        'SLA', // This is 'support_availability' in the form
        'UserSpecificSection', // This is 'user_specific_section' in the form
        // Add other fields from the database table here if you want to save them via the form
    ];
}
