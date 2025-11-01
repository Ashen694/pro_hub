<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
   use HasFactory;

protected $fillable = ['freelancer_id','task_name','specification','payment','delivery_due_date','status','paid'];

    public function freelancer(){
        return $this->belongsTo(Freelancer::class);
    }
   
}
