<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Etudiant::all(), 200);
        //return Etudiant::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('etudiants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            "tel"  => 'required|number|max:255',
            'email' => 'required|email|unique:etudiants'
        ]);
        $etudiant = Etudiant::create($validated);
        return response()->json($etudiant, 201);
        //return Etudiant::create($request -> all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Etudiant $etudiant)
    {
        return response()->json($etudiant, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etudiant $etudiant)
    {
        return view('etudiants.edit', compact('etudiant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants,email,' . $etudiant->id,
        ]);

        $etudiant->update($validated);

        return response()->json($etudiant, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return response()->json("Suppression reussie", 204);
    }
}
