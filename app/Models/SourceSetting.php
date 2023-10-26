<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceSetting extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name'
    ];


    protected $table = 'source_setting';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function applicant(){
        return $this->hasMany(Applicant::class, 'source_id');
    }

    public function applicantSourceId(){
        return $this->hasMany(ApplicantBySourceId::class, 'source_id');
    }

    public function applicantSourceDaftarId(){
        return $this->hasMany(ApplicantBySourceId::class, 'source_daftar_id');
    }
}
