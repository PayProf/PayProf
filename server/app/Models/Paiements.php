<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiements extends Model
{
    use HasFactory;
    protected $fillable = [
        'enseignant_id',
        'etablissement_id',
        'VH',
        'Taux_H',
        'Brut',
        'IR',
        'Net',
        'Annee_univ',
        'Semestre',
    ];

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class);
    }
    public function intervention()
    {
        return $this->hasOne(Intervention::class);
    }
}
