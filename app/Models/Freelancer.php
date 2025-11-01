<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\HasMany;

class Freelancer extends Model
{
    use HasFactory;

protected $fillable = ['name','nic','project_name','project_scope','total_amount','budget_available','duration','start_date','end_date'];

    public function tasks(){
        return $this->hasMany(Task::class);
    }
}
