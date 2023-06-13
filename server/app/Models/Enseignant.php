<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Enseignant extends Model
{
    use HasFactory;
    protected $fillable = [
        'PPR',
        'nom',
        'prenom',
        'date_naissance',
        'etablissement_id',
        'grade_id',
        'user_id',
        'image',
        'email_perso'

    ];


    public function IdGrade($designation)
    {
        $grade_id = DB::table('grades')
            ->select('id')
            ->where('designation', $designation)
            ->first();
        return $grade_id->id;
    }
    public function Hours($id)
    {

        $hours = DB::table('interventions')->where('enseignant_id', $id)->sum('Nbr_heures');
        return $hours;
    }



    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function interventions()
    {
        return $this->hasMany(Intervention::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiements::class);
    }

    public function user(): BelongsTo
    {   //to get the user that have the role as enseignant
        return $this->belongsTo(User::class);
    }
}
