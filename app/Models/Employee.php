<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'Employee';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'Emp_ID';

    /**
     * The attributes that are mass assignable.
     * We are un-commenting this and adding all the correct column names.
     */
    protected $fillable = [
        'Emp_Name',
        'Emp_Email',
        'Emp_Phone',
        'LastSuccessfulLogin',
        'Locked',
        'GroupID',
        'DOB',
        'Calling_Name',
        'Gender',
        'Section'
    ];
    
    /**
     * Relationship to the work plans created by this employee.
     * This was in the other developer's model.
     */
    public function workPlans()
    {
        return $this->hasMany(WeeklyPlan::class, 'updated_by', 'Emp_ID');
    }
}