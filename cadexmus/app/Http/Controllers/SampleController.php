<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sample;

class SampleController extends Controller
{
    public function index()
    {
		$samples = Sample::all();
		/*
		foreach ($samples as $s) {
			echo $s;
		}
		*/
		//dd($samples);


        //return view('sample.index',compact("samples"));
        //return view('sample.index',['samples' => $samples]);
        //return view('sample.index')->with('samples',$samples);
        return view('sample.index')->withSamples($samples);
    }

    public function create()
    {
        return view('sample.create');
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
            echo("stocké dans : $url");
            $s = Sample::create(array_merge(['url'=>$url], $request->only('nom', 'type')));
            //return redirect()->route('sample.show', $s->id);
            return redirect()->route("sample.index");
        }
    }

    public function show($sample) {
        dd(Sample::where('id', $sample)->get());
    }
}
