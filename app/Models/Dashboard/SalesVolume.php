<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesVolume extends Model
{
    use HasFactory;

    protected $fillable = [
        'pmb',
        'identity_user',
        'name',
        'target',
        'realization',
    ];

    protected $table = 'dashboard_sales_volume';
}