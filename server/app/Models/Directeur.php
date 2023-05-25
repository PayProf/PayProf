<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directeur extends Model
{
    use HasFactory;

    protected $fillable =[
        'PPR',
        'nom',
        'prenom',
        'date_naissance',
        'etablissement_id',
        'user_id',
        'image',
        'email_perso'

    ];

public function user()
{
    return $this->belongsTo(User::class);
}
public function etablissement()
{
    return $this->belongsTo(Etablissement::class);
  
}

// public function etablissement()
// {
//     return $this->belongsTo(Etablissement::class);
// }

}
