<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identity',
        'name',
        'religion',
        'email',
        'phone',
        'education',
        'school',
        'major',
        'class',
        'year',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'address',
        'mother_name',
        'mother_place_of_birth',
        'mother_date_of_birth',
        'mother_religion',
        'mother_education',
        'mother_phone',
        'mother_job',
        'father_name',
        'father_place_of_birth',
        'father_date_of_birth',
        'father_religion',
        'father_education',
        'father_phone',
        'father_job',
        'note',
        'source',
        'status',
        'identity_user',
        'program',
        'isread',
    ];

    public function presenter(){
        return $this->belongsTo(User::class,'identity_user','identity');
    }
}
