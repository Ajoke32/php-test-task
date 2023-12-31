<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
    use HasFactory;

    protected $fillable=[
        "user_id",
        "collection_id",
        "amount"
    ];

    public $timestamps = false;

    public function user(){
        return $this->hasOne(User::class);
    }

    public function collection(){
        return $this->hasOne(Collection::class);
    }
}
