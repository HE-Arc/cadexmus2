<?php

namespace App\Http\Controllers;

use App\Version;
use Illuminate\Http\Request;
use App\Projet;
use Auth;
use App\Message;
use App\User;
use App\Sample;
use Carbon\Carbon;
use Session;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $myProjects = Auth::user()->projets;

        if($request->simple)
            return view('projet.list', compact('myProjects'));

        $otherProjects = Projet::all();
        return view('projet.index', compact(['myProjects', 'otherProjects']));
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

        $samples = Sample::orderBy('nom')->get();
        $userColor = 7;
        $asGuest = true;

        // FIXME: Faire un count en SQL! -- Yoan
        // non, on a besoin de l'user pour récupérer sa couleur
        $userInProject = $projet->users->find(Auth::id());
        if(count($userInProject)){
            // récupération de la couleur de l'user dans ce projet
            $userColor = ($userInProject->pivot->couleur -1)%8;

            $asGuest = false;
        }

        $asGuest = var_export($asGuest, 1);
        return view('projet.show', compact('projet', 'userColor', 'asGuest', 'samples'));
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
            // Update the model's update timestamp.
            Projet::find($id)->touch();
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


    public function sendMessage(Request $request, $id){
        $username = Auth::user()->name;
        $text = $request->text;
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

    public function retrieveRecentChatMessages($id){

        $projet = Projet::find($id);
        $mytime = Carbon::now()->subSecond(5); //Car le délai de récupération entre les messages est de 5 secondes
        $mytimeStr = $mytime->toDateTimeString();
        $messages = $projet->messages()->with('user')->orderBy('messages.created_at','ASC')->where('messages.created_at','>',$mytimeStr)->get();
        return $messages;

    }

    //TODO:
    // - Handle the case when the form is NOT sent using AJAX.
    // - Handle the case where the inviting user is a guest.
    public function invite(Request $request, $id){
        $user = User::where('name', $request->userToInvite)->first();
        if(!$user) return ['status' => "User $request->userToInvite does not exist"];

        $nbUserInProject = Projet::withCount('users')->find($id)->users_count;
        try{
            $user->projets()->attach($id, ['couleur'=>$nbUserInProject+1]);
        }catch (\Exception $e){
            return ['status' => "User $request->userToInvite already in project"];
        }

        return [
            'status' => "User $request->userToInvite successfully added to the project",
            'user' => [
                'name' => $user->name,
                'color' => $nbUserInProject%8,
                'path' => asset('uploads/picture/profile/' . $user->picture)
            ]
        ];
    }
}
