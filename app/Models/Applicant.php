<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'school',
        'year',
        'source',
        'status',
        'nik_user',
        'program',
        'isread',
    ];

    public function presenter(){
        return $this->belongsTo(User::class,'nik_user','nik');
    }
}
