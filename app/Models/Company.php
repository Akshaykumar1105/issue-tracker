<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory, SoftDeletes, Sluggable, HasUuids;

    protected $fillable = [
        'name',
        'is_active',
        'email',
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

    

}
