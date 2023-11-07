<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userprofile extends Model
{
    use HasFactory;

    protected $fillable = ['bio', 'title'];

    public function user(){
        return $this->hasMany(User::class);
    }
}
