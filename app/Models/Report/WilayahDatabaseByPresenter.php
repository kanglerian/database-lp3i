<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WilayahDatabaseByPresenter extends Model
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
        'kabtasikmalaya',
        'tasikmalaya',
        'ciamis',
        'banjar',
        'garut',
        'pangandaran',
        'tidakdiketahui',
        'jumlah'
    ];

    protected $table = 'wilayah_database_by_presenter';
}
