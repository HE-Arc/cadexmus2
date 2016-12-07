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



       public function sendMessage($id)
    {
        $username = Auth::user()->name;
        $text = Input::get('text');
        $text = htmlentities($text);

        $message = new Message();
        $message->user_id = Auth::user()->id;
        $message->projet_id = $id;
        $message->body = $text;
        $message->save();
    }

    public function isTyping($id)
    {

        $tabTyping = DB::table('users')
        ->select('projet_user.user_id','projet_user.projet_id','projet_user.isTyping')
        ->join('projet_user','projet_user.user_id', '=', 'users.id')
        ->join('projets','projets.id', '=', 'projet_user.projet_id')
        ->where('projets.id', '=', $id)
        ->where('users.name','=',Auth::user()->name)
        ->where('projet_user.isTyping','=',false)
        ->update(['projet_user.isTyping' => true]);

     //  return "isTyping";

    }


    public function notTyping($id)
    {
        $tabTyping = DB::table('users')
        ->select('projet_user.user_id','projet_user.projet_id','projet_user.isTyping')
        ->join('projet_user','projet_user.user_id', '=', 'users.id')
        ->join('projets','projets.id', '=', 'projet_user.projet_id')
        ->where('projets.id', '=', $id)
        ->where('users.name','=',Auth::user()->name)
        ->where('projet_user.isTyping','=',true)
        ->update(['projet_user.isTyping' => false]);

     //   return "notTyping";
    }

    public function retrieveChatMessages($id)
    {

         $messages = DB::table('messages')
        ->select('messages.body','users.name')
        ->join('users','users.id', '=', 'messages.user_id')
        ->where('messages.projet_id', '=', $id)->get();

        //$messages = Message::where('projet_id','=',$id)->get();

        return $messages;
    }

    public function retrieveTypingStatus($id)
    {

         $tabTyping = DB::table('users')
        ->select('users.name')
        ->join('projet_user','projet_user.user_id', '=', 'users.id')
        ->join('projets','projets.id', '=', 'projet_user.projet_id')
        ->where('projets.id', '=', $id)
        ->where('projet_user.isTyping','=',true)
        ->get();

        return $tabTyping;


    }

    public function getUserName()
    {
     //return json_encode(Auth::user->name);
        return Auth::user()->name;
    }
}
