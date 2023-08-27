<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable=[
        "title",
        "description",
        "target_amount",
        "link",
        "created_at"
    ];
    public $timestamps = false;

    function contributor(){
        return $this->hasMany(Contributor::class);
    }
}
