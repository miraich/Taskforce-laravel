<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    public function tasks(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
