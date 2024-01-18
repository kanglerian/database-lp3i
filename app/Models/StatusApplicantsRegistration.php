<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusApplicantsRegistration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pmb',
        'identity_user',
        'date',
        'nominal',
        'deal',
        'discount',
        'desc_discount',
        'session',
    ];


    protected $table = 'status_applicants_registration';
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
        return $this->belongsTo(Applicant::class,'identity_user','identity');
    }
}
