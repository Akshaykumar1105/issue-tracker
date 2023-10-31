<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'issue_id',
        'body',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issue(){
        return $this->belongsTo(Issue::class, 'issue_id');
    }

    public function commentUpvotes(){
        return $this->hasMany(CommentUpvotes::class);
    }
}
