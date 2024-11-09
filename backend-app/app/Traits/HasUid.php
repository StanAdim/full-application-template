<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

trait HasUid
{
    public static function bootHasUid(): void
    {
        static::creating(function ($model) {
            // Check if the model has a 'uid' column
            if (Schema::hasColumn($model->getTable(), 'uid')) {
                // If the 'uid' column exists and is null, generate a new UUID
                if ($model->uid === null) {
                    $model->uid = Str::uuid();
                }
            }
        });
    }
}
