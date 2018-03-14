<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IndiceDeBase;

class IndiceDeBaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('isadmin');
        $this->middleware('auth');
    }
    public function index()
    {
        $indice_de_base = IndiceDeBase::all();

        return view('indicedebase.index', compact('indice_de_base'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('indicedebase.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Enregistre le formulaire de création



        $this->validate($request, [

            'indice' => 'required',
            'valeur' => 'required'
        ],
            [
                'indice.required' => 'Indice de base obligatoire',
                'valeur.required' => 'Valeur de l\'indice de base obligatoire',

            ]);

        $indice_de_base = new IndiceDeBase;
        $input = $request->input();


        $indice_de_base->fill($input)->save();



        return redirect()
            ->route('indicedebase.index');
        /*->with('success', 'L\'indice de base à bien été modifié);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Afficher un article
        $indice_de_base = IndiceDeBase::findOrFail($id);
        return view('indicedebase.show', compact('indice_de_base'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $indice_de_base = IndiceDeBase::findOrFail($id);
        //Afficher le formulaire d'édition d'un article
        return view('indicedebase.edit', compact('indice_de_base'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $indice_de_base = IndiceDeBase::findOrFail($id);
        $input = $request->input();

        $indice_de_base->fill($input)->save();


        return redirect()
            ->route('indicedebase.index');
        /*->with('success', 'event mis à jour');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $indice_de_base = IndiceDeBase::findOrFail($id);
        $indice_de_base->delete();
        return redirect()
            ->route('indicedebase.index');
        /* ->with('success', 'Suppression de l\'indice');*/
    }
}
