<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
   */

   protected $fillable = [
       'identity',
       'pmb_volume',
       'pmb_revenue',
       'name',
       'target_volume',
       'realization_volume',
       'target_revenue',
       'realization_revenue'
   ];

   protected $table = 'dashboard_sales';
}
