<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantBySourceId extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'source_id',
        'total',
    ];


    protected $table = 'applicants_by_source_id';

    public function sourceSetting()
    {
        return $this->belongsTo(SourceSetting::class, 'source_id', 'id');
    }
}
