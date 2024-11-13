<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Programme extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'funding',
        'owner',
        'eligibility',
        'applicantGroups',
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    protected function applicantGroups() :Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
    protected function eligibility() :Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value, true),
            set: fn ($value) => json_encode($value),
        );
    }
}
