<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * GET /api/categories
     * Récupérer toutes les catégories
     */
    public function index(): JsonResponse
    {
        $categories = Categorie::withCount('produits')
            ->orderBy('nom_categorie')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
            'message' => 'Liste des catégories récupérée avec succès'
        ]);
    }

    /**
     * POST /api/categories
     * Créer une nouvelle catégorie
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nom_categorie' => 'required|string|max:255|unique:categories,nom_categorie',
                'description' => 'nullable|string|max:1000'
            ]);

            $categorie = Categorie::create($validated);

            return response()->json([
                'success' => true,
                'data' => $categorie,
                'message' => 'Catégorie créée avec succès'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * GET /api/categories/{id}
     * Afficher une catégorie spécifique
     */
    public function show(Categorie $categorie): JsonResponse
    {
        $categorie->load('produits');

        return response()->json([
            'success' => true,
            'data' => $categorie,
            'message' => 'Catégorie récupérée avec succès'
        ]);
    }

    /**
     * PUT /api/categories/{id}
     * Mettre à jour une catégorie
     */
    public function update(Request $request, Categorie $categorie): JsonResponse
    {
        try {
            $validated = $request->validate([
                'nom_categorie' => 'required|string|max:255|unique:categories,nom_categorie,' . $categorie->id,
                'description' => 'nullable|string|max:1000'
            ]);

            $categorie->update($validated);

            return response()->json([
                'success' => true,
                'data' => $categorie,
                'message' => 'Catégorie mise à jour avec succès'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * DELETE /api/categories/{id}
     * Supprimer une catégorie
     */
    public function destroy(Categorie $categorie): JsonResponse
    {
        // Vérifier s'il y a des produits associés
        if ($categorie->produits()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer cette catégorie car elle contient des produits'
            ], 409);
        }

        $categorie->delete();

        return response()->json([
            'success' => true,
            'message' => 'Catégorie supprimée avec succès'
        ]);
    }

    /**
     * GET /api/categories/{id}/produits

     * Récupérer les produits d'une catégorie
     */
    public function produits(Categorie $categorie): JsonResponse
    {
        $produits = $categorie->produits;

        return response()->json([
            'success' => true,
            'data' => [
                'categorie' => $categorie->only(['id', 'nom_categorie', 'description']),
                'produits' => $produits,
                'total_produits' => $produits->count()
            ],
            'message' => 'Produits de la catégorie récupérés avec succès'
        ]);
    }
      public function findByNom(string $nom_categorie): JsonResponse
    {
        $categorie = Categorie::where('nom_categorie', 'LIKE', '%' . $nom_categorie . '%')
            ->withCount('produits')
            ->first();

        if (!$categorie) {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => "Aucune catégorie trouvée avec le nom_categorie : {$nom_categorie}"
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $categorie,
            'message' => 'Catégorie trouvée avec succès'
        ]);
    }
}
