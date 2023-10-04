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
        'status'
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'comment_user', 'comment_id', 'user_id' );
    }

    public function commentUpvotes(){
        return $this->hasMany(CommentUpvotes::class);
    }
}
