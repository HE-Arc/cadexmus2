<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sample;
use Validator;

class SampleController extends Controller
{
    public function index()
    {
        $samples = Sample::orderBy('nom')->get();

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
        $validator = Validator::make($request->all(), [
            'url' => 'mimetypes:audio/mpeg,audio/x-wav',
            'nom' => 'required',
        ]);

        if ($validator->fails()) {
            return view("sample.uploaderror")
                ->withErrors($validator);
        }

        if ($request->url->isValid()) {
            $url = $request->url->storeAs("samples/users", $request->nom . "_" . uniqid() .".". $request->url->extension());
            $s = Sample::create(array_merge(['url'=>$url], $request->only('nom', 'type')));
            return redirect()->route("sample.show",$s->id);
        }
        return view("sample.uploaderror")->with('urlError',"L'URL $request->url n'est pas valide");
    }

    public function filter(Request $request) {
        $pattern = $request->pattern;
        $patterns = explode(" ", $pattern);

        // requête de barbare pour un filtrage efficace
        // le nom OU le type contient arg1 ET le nom ou le type contient arg2 ET etc...
        // select * from `samples` where ((`nom` like '%arg1%' or `type` like '%arg1%') and (`nom` like '%arg2%' or `type` like '%arg2%')) order by `nom` asc
        if (!$pattern) {
            $query = Sample::all();
        } else {
            $query = Sample::where(function($q) use ($patterns) {
                foreach ($patterns as $keyword) {
                    $q->where(function($q) use ($keyword){
                        $q->where('nom', 'like', "%$keyword%")
                            ->orWhere('type', 'like', "%$keyword%");
                    })->get();
                }
            });
        }
        $samples = $query->orderBy('nom')->get();

        return view('sample.list')->withSamples($samples);
    }

    public function listAll(){
        $samples = Sample::orderBy('nom')->get();
        return view('sample.list')->withSamples($samples);
    }
}
