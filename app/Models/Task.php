<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{

    protected $fillable = [
        'client_id',
        'executor_id',
        'status_id',
        'category_id',
        'city_id',
        'title',
        'description',
        'budget',
        'address',
        'lat',
        'long',
    ];

    use HasFactory;

    public function files(): HasMany
    {
        return $this->HasMany(File::class);
    }

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id'); // тут тоже
    }

    public function city(): HasOne
    {
        return $this->hasOne(City::class, 'id', 'city_id'); // тут тоже
    }

    public function category(): HasOne
    {

        return $this->hasOne(Category::class, 'id', 'category_id'); //вопрос, почему пришлось явно указывать
    }

    public function responses(): BelongsToMany
    {
        return $this->belongsToMany(Response::class, 'tasks_responses', 'task_id',
            'response_id');
    }

//    через аксессор не сработало(
//    protected function createdAt(): Attribute
//    {
//        $now = Carbon::now();
//
//        return Attribute::make(
//            get: fn($date) => $now->diffForHumans($date),
//        );
//    }


}
