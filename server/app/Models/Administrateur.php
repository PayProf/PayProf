<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;
    protected $fillable = [
        'PPR',
        'nom',
        'prenom',
        'etablissement_id',
        'user_id',
        'email_perso',

    ];
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
