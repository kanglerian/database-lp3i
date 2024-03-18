<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetByPresenter extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */

    protected $fillable = [
        'identity',
        'pmb_volume',
        'pmb_revenue',
        'session_volume',
        'session_revenue',
        'date_volume',
        'date_revenue',
        'name',
        'target_volume',
        'realization_volume',
        'target_revenue',
        'realization_revenue',
    ];

    protected $table = 'view_report_target_by_presenter';
}
