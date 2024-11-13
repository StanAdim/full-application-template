<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\UUID;

class Project extends Model
{
    use UUID;
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = [
        'user_id',
        'category',
        'title',
        'year',
        'brief',
        'comment',
        'verify'
    ];
    protected   $casts = [
        'category' => 'array'
    ];

    protected function category() :Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }

    //relationships
    public function user(){
        return $this->belongsTo(User::class);
    }
    //Accessor
 
}
