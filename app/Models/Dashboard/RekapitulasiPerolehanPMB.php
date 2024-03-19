<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapitulasiPerolehanPMB extends Model
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
        'pmb_applicant',
        'pmb_enrollment',
        'pmb_registration',
        'applicant',
        'enrollment',
        'registration',
        'omzet'
    ];

    protected $table = 'dashboard_rekap_perolehan_pmb';
}
