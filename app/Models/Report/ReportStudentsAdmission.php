<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportStudentsAdmission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pmb',
        'month_number',
        'tanggal_aplikan',
        'session_aplikan',
        'tanggal_daftar',
        'session_daftar',
        'identity_user',
        'programtype_id',
        'presenter',
        'aplikan',
        'daftar',
        'register_regular',
        'register_nonreguler',
        'omset_reguler',
        'omset_nonreguler',
        'total',
    ];

    protected $table = 'report_students_admission';
}
