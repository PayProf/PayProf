<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiements extends Model
{
    use HasFactory;

    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class );
      
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class );
      
    }
}
