<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sample;

class SampleController extends Controller
{
    public function index()
    {
		$samples = Sample::all();

        //return view('sample.index',compact("samples"));
        //return view('sample.index',['samples' => $samples]);
        //return view('sample.index')->with('samples',$samples);
        return view('sample.index')->withSamples($samples);
    }

    public function create()
    {
        return view('sample.create');
    }

    // méthode appelée par la route get sample/{sample}
    public function show($id)
    {
        return view('sample.show')->withSample(Sample::find($id));
    }


    public function store(Request $request)
    {
        // redirect automatique à la page précédente si la validation échoue
        $this->validate($request, [
            'url' => 'mimetypes:audio/mpeg,audio/x-wav',
            'nom' => 'required',
        ]);

        if ($request->url->isValid()) {
            $url = $request->url->storeAs("samples/users/$request->type", $request->nom . "_" . uniqid() .".". $request->url->extension());
            $s = Sample::create(array_merge(['url'=>$url], $request->only('nom', 'type')));
            return redirect()->route("sample.show",$s->id);
        }
    }

    public function filter($pattern){
        $samples = Sample::where('nom', 'LIKE', "%$pattern%")->get();
        return view('sample.list')->withSamples($samples);
    }

    public function listAll(){
        $samples = Sample::all();
        return view('sample.list')->withSamples($samples);
    }
}
