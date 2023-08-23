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
        'religion',
        'address',
        'source_id',
        'note',
        'status_id',
        'programtype_id',
        'pmb',
        'identity_user',
        'program',
        'isread',
    ];


    protected $table = 'applicants';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    public function presenter(){
        return $this->belongsTo(User::class,'identity_user', 'identity');
    }

    public function sourceSetting(){
        return $this->belongsTo(SourceSetting::class, 'source_id', 'id');
    }

    public function programType(){
        return $this->belongsTo(ProgramType::class, 'programtype_id', 'id');
    }

    public function applicantStatus(){
        return $this->belongsTo(ApplicantStatus::class, 'status_id', 'id');
    }

    public function histories(){
        return $this->belongsTo(ApplicantHistory::class,'identity_user', 'identity');
    }
}
