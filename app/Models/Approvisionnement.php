<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvisionnement extends Model
{
    use HasFactory;

    protected $fillable = ['vehicule_id', 'chauffeur_id', 'quantite', 'date','destination_id'];
    public $timestamps = false;
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
    public function chauffeur()
    {
        return $this->belongsTo(Chauffeur::class);
    }
    public function destination()
{
    return $this->belongsTo(Destination::class);
}

}

