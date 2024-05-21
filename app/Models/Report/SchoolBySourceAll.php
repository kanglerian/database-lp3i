<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolBySourceAll extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pmb',
        'id',
        'wilayah',
        'nama',
        'presentasi',
        'grab',
        'website',
        'mgm',
        'sosmed',
        'sekolah',
        'jadwaldatang',
        'gurubk',
        'psikotes',
        'daftaronline',
        'beasiswa',
        'valid',
        'nonvalid',
        'kelas',
        'jumlah'
    ];

    protected $table = 'schools_by_source_all';
}
