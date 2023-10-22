<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CommentUpvotes extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'comment_upvotes';

    protected $fillable = [
        'comment_id',
        'user_id',
    ];
    
    public function comment(){
        return $this->belongsTo(Comment::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
