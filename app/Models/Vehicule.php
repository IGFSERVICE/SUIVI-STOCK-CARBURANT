<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $fillable = ['matricule', 'type'];
    public $timestamps = false;

    public function chauffeur()
    {
        
        // return $this->belongsTo(Chauffeur::class);
    }
}

