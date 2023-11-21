<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "post_text", "user_id", "post_status"
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
