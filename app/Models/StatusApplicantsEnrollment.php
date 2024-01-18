<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusApplicantsEnrollment extends Model
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
        'receipt',
        'register',
        'register_end',
        'nominal',
        'repayment',
        'debit',
        'session'
    ];


    protected $table = 'status_applicants_enrollment';
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
