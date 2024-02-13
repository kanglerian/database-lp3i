<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterBySchoolYear extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */

    protected $fillable = [
        'pmb',
        'year',
        'identity_user',
        'register',
        'name',
    ];

    protected $table = 'report_register_by_school_year';
}
