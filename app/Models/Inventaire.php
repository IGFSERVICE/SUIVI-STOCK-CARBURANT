<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventaire extends Model
{
    use HasFactory;
    public $timestamps = false;
    // public $timestamp = false;
    protected $fillable = ['ancienne_quantite', 'nouvelle_quantite', 'difference', 'date_ajustement', 'type_operation',];
    
}
