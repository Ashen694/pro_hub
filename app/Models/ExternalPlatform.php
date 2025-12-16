<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalPlatform extends Model
{
    protected $table = 'external_platforms';
    protected $primaryKey = 'platform_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'platform_name','platform_type','start_date','target_date','developed_by',
        'developed_team','bitbucket','bit_bucket_repo','sdlc_stage','percentage_done',
        'status','status_date','integrated_apps','dr','company_id','sales_team_id',
        'sales_am','sales_manager','sales_engineer','uat_date','va_date','launched_date',
        'platform_owner','app_op_owner','platform_otc','platform_mrc','contract_period',
        'incentive_earned','incentive_share','billing_date','proposal_upload','sla',
        'software_value','backup_officer_1','backup_officer_2','ssl_certificate_exp_date',
        'dpo_handover'
    ];

    protected $casts = [
        'start_date'               => 'date',
        'target_date'              => 'date',
        'status_date'              => 'date',
        'uat_date'                 => 'date',
        'va_date'                  => 'date',
        'launched_date'            => 'date',
        'billing_date'             => 'date',
        'ssl_certificate_exp_date' => 'date',
        'software_value'           => 'decimal:2',
        'percentage_done'          => 'integer',
    ];

    /**
     * Many-to-many WeeklyPlan (table: workplans) via external_platform_workplan.
     */
    public function weeklyPlans()
    {
        return $this->belongsToMany(
            WeeklyPlan::class,            // your model class
            'external_platform_workplan', // pivot table
            'external_platform_id',       // FK on pivot pointing to THIS model
            'workplan_id',                // FK on pivot pointing to WeeklyPlan
            'platform_id',                // THIS model's PK
            'id'                          // WeeklyPlan's PK (workplans.id)
        )->withTimestamps();
    }

    /**
     * Relationship to Company
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
