<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;

    protected $table = 'trainees';
    protected $primaryKey = 'Trainee_ID';

    protected $fillable = [
        'Trainee_Name',
        'Trainee_Phone',
        'Trainee_NIC',
        'Trainee_Email',
        'Training_StartDate',
        'Training_EndDate',
        'Institute',
        'Languages_known',
        'Supervisor',
        'Target_Date',
        'Trainee_HomeAddress',
        'AssignedWork_Description',
        'field_of_specialization',
        'payment_start_date',
        'payment_end_date',
        'requested_payment_date',
        'absent_Count',
        'terminated_date',
        'terminated_reason',
        'status'
    ];

    protected $casts = [
        'Training_StartDate' => 'date',
        'Training_EndDate' => 'date',
        'Target_Date' => 'date',
        'payment_start_date' => 'date',
        'payment_end_date' => 'date',
        'requested_payment_date' => 'date',
        'terminated_date' => 'date',
        'absent_Count' => 'integer',
    ];

    /**
     * Scope for active trainees
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for inactive trainees
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope for paid trainees
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
