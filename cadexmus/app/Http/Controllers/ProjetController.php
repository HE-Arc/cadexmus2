<?php

namespace App\Http\Controllers;

use App\Version;
use Illuminate\Http\Request;
use App\Projet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projets = Auth::user()->projets;
        return view('projet.index',compact('projets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $projet = Projet::create($request->only('nom'));
        $repr=[
            'tempo' => 120,
            'tracks' => [],
        ];
        $projet->versions()->create(["numero" => 0, "repr" => $repr]);
        $projet->users()->attach(Auth::user());
        return redirect()->route('projet.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projet = Projet::with(['versions' => function($query){
            $query->orderBy('numero', 'desc')->first();
        }])->find($id);

        return view('projet.show', compact('projet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $retard = Version::where('numero','>',$request->version)
            ->where('projet_id',$id)->count();
        if($retard==0){
            $version = Version::create([
                'projet_id' => $id+0,
                'numero' => $request->version+1,
                'repr' => $request->repr
            ]);
            return "nouvelle version sauvegardée";
        }else{
            return "modifications refusées, vous avez $retard versions de retard";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
