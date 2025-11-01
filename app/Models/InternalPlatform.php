<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalPlatform extends Model
{
    use HasFactory;

    protected $table = 'Internal_Platforms';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'App_Name', 'Developed_By', 'Developed_Team', 'StartDate', 'TargetDate',
        'BitBucket', 'BIT_bucket_repo', 'SDLCPhase', 'PercentageDone', 'Status',
        'StatusDate', 'Bus_Owner', 'App_Category', 'Scope', 'App_IP', 'App_URL',
        'App_Users', 'UATDate', 'Integrated_apps', 'DR', 'LaunchedDate', 'VADate',
        'WAF', 'APP_OP_Owner', 'APP_BUSINESS_Owner', 'Price', 'EndUserType',
        'RequestNo', 'ParentProjectID', 'SLA', 'BackupOfficer_1', 'BackupOfficer_2',
        'MainAppID', 'SSLCertificateExpDate', 'UserSpecificSection'
    ];

    /**
     * Get the parent project (application group).
     */
    public function parentProject()
    {
        return $this->belongsTo(ParentProject::class, 'ParentProjectID', 'ParentProjectID');
    }

    /**
     * Get the parent "Main Application" for a "Change Request".
     */
     public function mainApplicationParent()
    {
        return $this->belongsTo(InternalPlatform::class, 'MainAppID', 'ID');
    }

    /**
     * Get all of the Change Requests for a Main Application.
     */
    public function changeRequests()
    {
        // A Main Application (ID) has many Change Requests (linked by MainAppID)
        return $this->hasMany(InternalPlatform::class, 'MainAppID', 'ID');
    }

    public function comments()
    {
        return $this->hasMany(InternalProjectComment::class, 'Solution_ID', 'ID')->latest('Updated_Time');
    }

    public function documents()
    {
        return $this->hasMany(\App\Models\Document::class, 'Solution_ID', 'ID');
    }
}