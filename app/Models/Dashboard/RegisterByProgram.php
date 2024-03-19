<?php

namespace App\Models\Dashboard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterByProgram extends Model
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
        'program',
        'register_reguler',
        'register_nonreguler'
    ];

    protected $table = 'dashboard_register_by_program';
}
