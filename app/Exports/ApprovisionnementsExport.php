<?php

namespace App\Exports;

use App\Models\Approvisionnement;
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApprovisionnementsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $approvisionnements;

    public function __construct($approvisionnements)
    {
        $this->approvisionnements = $approvisionnements;
    }

    public function collection()
    {
        return $this->approvisionnements;
    }

    public function map($approvisionnement): array
    {
        return [
            $approvisionnement->id,
            $approvisionnement->vehicule->matricule,
            $approvisionnement->vehicule->type,
            $approvisionnement->chauffeur->nom,
            $approvisionnement->destination->nom,
            $approvisionnement->quantite,
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
