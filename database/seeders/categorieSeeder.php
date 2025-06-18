<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class categorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        // Exemple : lier les produits à une catégorie déjà existante
        $categorie = Categorie::where('nom', 'Électronique')->first();

        if ($categorie) {
            Produit::create([
                'nom' => 'Casque Bluetooth',
                'description' => 'Casque sans fil avec réduction de bruit',
                'prix' => 49999.99,
            
                'categorie_id' => $categorie->id,
            ]);

            Produit::create([
                'nom' => 'Smartwatch',
                'description' => 'Montre connectée waterproof',
                'prix' => 119999.99,
                'categorie_id' => $categorie->id,
            ]);
        }
    }
}
