<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];
    public $timestamps = false;

    // public function approvisionnements()
    // {
    //     return $this->hasMany(Approvisionnement::class);
    // }
}
