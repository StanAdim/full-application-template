<?php

namespace App\Models\Categories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Traits\HasUid;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory , HasUid;
    protected $fillable = [
        'uid',
        'status',
        'phone_number',
        'email',
        'region',
        'date_establishment',
        'logo_path'
    ];
    // Define polymorphic relationship
    public function profileable(): MorphTo
    {
        return $this->morphTo();
    }
    // Define relationship to User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

