<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{

    use HasFactory;
     protected $fillable = [
        "nom_produit",
        "description",
        "prix_unitaire",
        "stock",
        "categorie_id"
    ];

    public function categorie(){
        return $this->belongsTo(Categorie::class , 'categorie_id');
    }
}
