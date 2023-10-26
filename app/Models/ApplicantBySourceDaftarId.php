<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantBySourceDaftarId extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'source_daftar_id',
        'total',
    ];


    protected $table = 'applicants_by_source_daftar_id';

    public function sourceDaftarSetting()
    {
        return $this->belongsTo(SourceSetting::class, 'source_daftar_id', 'id');
    }
}
