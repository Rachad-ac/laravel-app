<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieController extends Model
{
    use HasFactory;

    protected $fillable = [
        "nom_categorie",
        "description"
    ];

    public function produits(){
        return $this->hasMany(Produit::class , 'categorie_id');
    }
    //
}
