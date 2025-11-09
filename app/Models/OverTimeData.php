<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OverTimeData extends Model
{
    use HasFactory;

    protected $table = 'OverTime_Data';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'Created_By',
        'Date',
        'No_Of_Hours',
        'Work_Description',
        'Approval_For',
        'Comment',
        'Approved_By',
        'Approved_Date',
    ];

    protected $casts = [
        'Created_Date' => 'datetime',
        'Date' => 'date',
        'Approved_Date' => 'datetime',
        'No_Of_Hours' => 'decimal:2',
    ];

    // --- UPDATED ELOQUENT RELATIONSHIPS ---

    /** Get the user who created the record (from 'users' table). */
    public function creator()
    {
        // This relationship now points to the default User model
        return $this->belongsTo(User::class, 'Created_By', 'id');
    }

    /** Get the employee for whom approval is requested (from 'Employee' table). */
    public function approvalForUser()
    {
        return $this->belongsTo(Employee::class, 'Approval_For', 'Emp_ID');
    }

    /** Get the employee who approved the record (from 'Employee' table). */
    public function approver()
    {
        return $this->belongsTo(Employee::class, 'Approved_By', 'Emp_ID');
    }
}