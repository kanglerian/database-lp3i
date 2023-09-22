<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantFamily extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identity_user',
        'name',
        'job',
        'phone',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'education',
        'address',
    ];


    protected $table = 'applicants_family';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function father(){
        return $this->belongsTo(Applicant::class,'identity_user','identity')->where('gender', 1);
    }

    public function mother(){
        return $this->belongsTo(Applicant::class,'identity_user','identity')->where('gender', 0);
    }

}
