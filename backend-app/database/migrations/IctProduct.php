<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IctProduct extends Model
{
    use UUID;
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'brief',
        'verify'
    ];
    // protected   $casts = [
    //     'category' => 'array'
    // ];

    // protected function category() :Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => json_decode($value, true),
    //         set: fn ($value) => json_encode($value),
    //     );
    // }

    //relationships
    public function user(){
        return $this->belongsTo(User::class);
    }
    //Accessor
 
}
