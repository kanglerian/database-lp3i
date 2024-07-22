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
        'plan',
        'income_parent',
        'address',
        'parent_phone',
        'parent_job',
        'reference',
        'source_id',
        'status',
    ];


    public function user(){
        return $this->belongsTo(User::class,'identity_user','identity_user');
    }

    public function applicant(){
        return $this->belongsTo(Applicant::class,'identity_user','identity');
    }

    public function sourceSetting()
    {
        return $this->belongsTo(SourceSetting::class, 'source_id', 'id');
    }
    
    public function SchoolApplicant()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
}
