<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function getIdEtablissement($etablissement)
{
    $etablissement_id = DB::table('etablissements')
    ->select('id')
    ->where('nom', $etablissement)
    ->first();
        
    return  $etablissement_id->id;
}
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
