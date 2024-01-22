<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserUpload extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'users_upload';
    protected $fillable = [
        'identity_user',
        'fileupload_id',
        'typefile'
    ];

    public function userupload(){
        return $this->belongsTo(User::class,'identity_user','identity');
    }

    public function applicant(){
        return $this->belongsTo(Applicant::class,'identity_user','identity');
    }

    public function fileupload(){
        return $this->belongsTo(FileUpload::class,'fileupload_id','id');
    }
}
