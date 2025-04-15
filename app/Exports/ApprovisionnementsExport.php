<?php

namespace App\Exports;

use App\Models\Approvisionnement;
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApprovisionnementsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $Livraisons;

    public function __construct($Livraisons)
    {
        $this->Livraisons = $Livraisons;
    }

    public function collection()
    {
        return $this->Livraisons;
    }

    public function map($Livraisons): array
    {
        return [
            $Livraisons->id,
            $Livraisons->vehicule->matricule,
            $Livraisons->vehicule->type,
            $Livraisons->chauffeur->nom,
            $Livraisons->destination->nom,
            $Livraisons->quantite,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Véhicule',
            'Type',
            'Chauffeur',
            'Destination',
            'Quantité (L)',
        ];
    }
}
