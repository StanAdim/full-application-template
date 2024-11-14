<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasUid;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrassrootProgramProfile extends Model
{
    use HasFactory, HasUid, SoftDeletes;
    protected $fillable = [
        'uid',
        'grassroot_name',
        'brief_description',
        'status',
        'focus_area',
    ];
    protected $casts = [
        'focus_area' => 'array', // Cast founders as an array
    ];
    public function profile(): MorphOne
    {
        return $this->morphOne(Profile::class, 'profileable');
    }
}
