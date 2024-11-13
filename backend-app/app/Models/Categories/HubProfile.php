<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasUid;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class HubProfile extends Model
{
    use HasFactory, HasUid, SoftDeletes;
    protected $fillable = [
        'hub_name',
        'brief',
        'uid',
        'status',
        'total_members',
        'number_female',
        'partnerships',
        'membership_option', // free or paid
        'available_programs', // incubation, acceleration, mentorship , networking events
    ];
    protected $casts = [
        'available_programs' => 'array', // Cast founders as an array
    ];
    public function profile(): MorphOne
    {
        return $this->morphOne(Profile::class, 'profileable');
    }
}
