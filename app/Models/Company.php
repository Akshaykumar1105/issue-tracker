<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Company extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasUuids, Notifiable;

    protected $fillable = [
        'name',
        'is_active',
        'email',
        'city_id',
        'slug',
        'number',
        'address',
        'uuid'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function uniqueIds(): array
    {
        return ['uuid']; 		//your new column name
    }

    public function users(){
        return $this->hasMany(User::class);
    }

    public function issues(){
        return $this->hasMany(Issue::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }
}
