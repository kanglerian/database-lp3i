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
        'source',
        'note',
        'status',
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
        'created_at',
        'updated_at',
    ];

    public function presenter(){
        return $this->belongsTo(User::class,'identity_user', 'identity');
    }

    public function sourceSetting(){
        return $this->belongsTo(SourceSetting::class, 'source', 'id');
    }

    public function histories(){
        return $this->belongsTo(ApplicantHistory::class,'identity_user', 'identity');
    }
}
