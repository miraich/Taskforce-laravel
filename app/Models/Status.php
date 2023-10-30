<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function task(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id'); // тут тоже
    }
}
