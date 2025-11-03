<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; 

class Document extends Model
{
    use HasFactory;

    protected $table = 'Document';

    protected $primaryKey = 'ID';


    public $timestamps = false;

 
    protected $fillable = [
        'Platform_ID',
        'Solution_ID',
        'Doc_Name',
        'Created_Time',
        'Created_By',
        'Doc_Type',
        'Doc_classification',
        'Doc_URL',
        'Tags',
        'Confidential',
    ];


    public function internalSolution()
    {
        return $this->belongsTo(InternalPlatform::class, 'Solution_ID');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'Created_By');
    }
}