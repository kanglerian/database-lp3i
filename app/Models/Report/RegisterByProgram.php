<?php

namespace App\Models\Report;

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
        'register_reguler_beasiswa',
        'register_reguler_nonbeasiswa',
        'register_nonreguler'
    ];

    protected $table = 'report_register_by_program';
}
