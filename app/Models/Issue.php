<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Issue extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

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


    public function scopeFilter($query, $request)
    {
        if ($request->filter) {
            $query->where('priority', $request->filter);
        }
        if ($request->duedate) {
            $query->where('due_date', $request->duedate);
        }
        if ($request->company) {
            $query->where('company_id', $request->company);
        }
    }

    public function manager(){
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function hr(){
        return $this->belongsTo(User::class, 'hr_id');
    }
    
    public function company(){
        return $this->belongsTo(Company::class);
    }
    
    
}
