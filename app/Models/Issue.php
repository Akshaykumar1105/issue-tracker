<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'email',
        'excerpt',
        'description',
        'company_id',
        'priority',
        'due_date',
        'status',
        'slug',
        'hr_id',
        'manager_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'manager_id');
    }
    
    public function company(){
        return $this->belongsTo(Company::class);
    }
    
    
}
