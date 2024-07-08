<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'recommendations';

    protected $fillable = [
        'identity_user',
        'name',
        'phone',
        'school_id',
        'class',
        'year',
        'income_parent',
        'address',
        'status',
    ];


    public function user(){
        return $this->belongsTo(User::class,'identity_user','identity_user');
    }

    public function applicant(){
        return $this->belongsTo(Applicant::class,'identity_user','identity');
    }

    public function SchoolApplicant()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
}
