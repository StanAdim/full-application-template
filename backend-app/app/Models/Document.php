<?php

namespace App\Models;

use App\Models\Categories\Profile;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUid;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    //
    use HasUid, HasFactory;
    protected $fillable =[
        'file_name',
        'uid',
        'document_type_id',
        'path',
        'profile_id',
        'user_id',
        'status',
    ];
    protected $keyType = 'string'; // specify the primary key type as string
    public $incrementing = false; // ensure that primary key is not auto-incrementing

    public function profile(){
        return $this->belongsTo(Profile::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
