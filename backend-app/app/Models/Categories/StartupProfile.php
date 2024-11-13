<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUid;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class StartupProfile extends Model
{
    use HasFactory, HasUid, SoftDeletes;
    protected $fillable = [
        'startup_name',
        'industry',
        'uid',
        'description',
        'funding_stage' ,
        'team_size',
        'founders',
        'website',
    ];
    protected $casts = [
        'founders' => 'array', // Cast founders as an array
    ];
    public function profile(): MorphOne
    {
        return $this->morphOne(Profile::class, 'profileable');
    }
}
