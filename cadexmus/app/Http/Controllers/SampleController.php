<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sample;

class SampleController extends Controller
{
    public function index()
    {
        return view('sample.index');
    }

    public function create()
    {
        return view('sample.create');
    }

    public function store(Request $request)
    {
        if ($request->hasFile('url')) {
            if ($request->url->isValid()) {
                $mime=$request->url->getMimeType();
                if($mime=="audio/mpeg"||$mime=="audio/x-wav"){
                    $nom = $request->nom;
                    $url = $request->url->storeAs("samples/$request->type", $request->nom . "_" . time());
                    echo("stocké dans : $url");
                    $s = Sample::create(array_merge(['url'=>$url], $request->only('nom', 'type')));
                    return redirect()->route('sample.show', $s->id);
                }
            }
        }
    }

    public function show($sample) {
        dd(Sample::where('id', $sample)->get());
    }
}
