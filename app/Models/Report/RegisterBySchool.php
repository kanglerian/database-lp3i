<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterBySchool extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */

    protected $fillable = [
        'pmb',
        'identity_user',
        'register',
        'wilayah',
        'status',
        'tipe'
    ];

    protected $table = 'report_register_by_school';
}
