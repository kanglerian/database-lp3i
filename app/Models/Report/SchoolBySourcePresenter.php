<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolBySourcePresenter extends Model
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
        'identity_user',
        'presenter',
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

    protected $table = 'schools_by_source_presenter';
}
