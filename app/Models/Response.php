<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'commentary',
        'budget',
    ];

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
