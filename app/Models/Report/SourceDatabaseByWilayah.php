<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceDatabaseByWilayah extends Model
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
        'presenter',
        'wilayah',
        'presentasi',
        'grab',
        'website',
        'mgm',
        'sosmed',
        'sekolah',
        'jadwaldatang',
        'gurubk',
        'daftaronline',
        'beasiswa',
        'valid',
        'nonvalid',
        'kelas',
        'jumlah'
    ];

    protected $table = 'source_database_by_wilayah';
}
