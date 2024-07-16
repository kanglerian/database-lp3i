<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status',
        'region',
        'type',
        'lat',
        'lng'
    ];


    protected $table = 'schools';
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function applicant(){
        return $this->hasMany(Applicant::class, 'school');
    }

    public function recommendation(){
        return $this->hasMany(Recommendation::class, 'school_id');
    }
}
