<?php

namespace App\Http\Controllers;

use App\Version;
use Illuminate\Http\Request;
use App\Projet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Message;
use App\User;

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
            'nbMesures' => 1
        ];
        $projet->versions()->create(["numero" => 0, "repr" => $repr]);
        $projet->users()->attach(Auth::user(), array("couleur" => 1));
        return redirect()->route('projet.show',compact('projet'));
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
        }])->with('users')->find($id);

        $userInProject = $projet->users->find(Auth::id());
        if(count($userInProject)){
            // récupération de la couleur de l'user dans ce projet
            $userColor = ($userInProject->pivot->couleur -1)%8;
            return view('projet.show', ['projet'=>$projet,'userColor'=>$userColor]);
        }else{
            return view('projet.show', ['projet'=>$projet, 'asGuest'=>"true"]);
        }
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
            return ["message"=>"nouvelle version sauvegardée","version"=>$version->numero];
        }else{
            return ["message"=>"modifications refusées, vous avez $retard versions de retard"];
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

    public function getChat($projet){
        return view('chat.index')->with('projet',$projet);
    }

    public function getUpdate($idProjet, $numVersion){
        $lastVersion = Version::where('projet_id',$idProjet)->orderBy('numero', 'desc')->first();

        if($lastVersion->numero == $numVersion){
            return 0;
        }else{
            return $lastVersion;
        }
    }


    public function sendMessage($id){
        $username = Auth::user()->name;
        $text = Input::get('text');
        //$text = htmlentities($text);

        $message = new Message();
        $message->user_id = Auth::user()->id;
        $message->projet_id = $id;
        $message->body = $text;
        $message->save();
    }


    public function retrieveChatMessages($id){
        $projet = Projet::find($id);
        $text = $projet->messages()->with('user')->orderBy('messages.created_at','ASC')->get();
        return $text;
    }


    public function invite($id){
        $user = Input::get('userToInvite');
        $isUserExist = User::where('users.name', $user)->get();
        if(empty($isUserExist[0]['name'])) return "User does not exist";

        $nbUserInProjet = User::whereHas('projets', function($q) use ($id)
        {
            $q->where("id",$id);
        })->count();

        $isUserInProjet = User::whereHas('projets', function($q) use ($id)
        {
            $q->where("id",$id);
        })->where("name",$user)->get();

        if(!empty($isUserInProjet[0]['name'])) return "User is already in projet";

        User::find($isUserExist[0]['id'])->projets()->attach($id, array("couleur"=>++$nbUserInProjet));
        return "User added to the projet";

    }
}