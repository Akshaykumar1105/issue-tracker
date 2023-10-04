<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentUpvotes extends Model
{
    use HasFactory;
    
    protected $table = 'comment_upvotes'; // Set the table name if it's different

    protected $fillable = [
        'comment_id',
        'user_id',
    ];
    
}
