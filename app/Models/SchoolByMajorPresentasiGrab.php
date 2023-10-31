<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolByMajorPresentasiGrab extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'wilayah',
        'nama',
        'website',
        'mgm',
        'sosmed',
        'sekolah',
        'jadwaldatang',
        'gurubk',
        'presentasi',
        'daftaronline',
        'grab',
        'kelas',
        'jumlah',
    ];


    protected $table = 'schools_by_major_presentasi_grab';

}
