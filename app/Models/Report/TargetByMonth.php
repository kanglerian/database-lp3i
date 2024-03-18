<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetByMonth extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */

    protected $fillable = [
        'date_volume',
        'date_revenue',
        'pmb_volume',
        'pmb_revenue',
        'session_volume',
        'session_revenue',
        'target_volume',
        'target_revenue',
        'realization_volume',
        'realization_revenue',
    ];

    protected $table = 'view_report_target_by_month';
}
