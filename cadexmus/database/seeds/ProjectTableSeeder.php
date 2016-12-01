<?php

use App\Projet;
use App\Sample;
use App\Version;
use App\User;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = Projet::create(["nom"=>"Premier Projet"]);
        $project->users()->attach(User::all());
        $sample1=Sample::all()[0];
        $sample2=Sample::all()[1];
        $repr=[
            'tempo' => 120,
            'tracks' =>[
                [
                    "sample"=> [
                        "url" => $sample1->url,
                        "name" => $sample1->nom
                    ],
                    "notes"=>[
                        [
                            "pos"=>0,
                            "len"=>2
                        ],[
                            "pos"=>12,
                            "len"=>4,
                        ]
                    ]
                ],
                [
                    "sample"=> [
                        "url" => $sample2->url,
                        "name" => $sample2->nom
                    ],
                    "notes"=>[
                        [
                            "pos"=>16,
                            "len"=>8
                        ]
                    ],
                ],
            ],
        ];
        $project->versions()->create(["numero" => 0, "repr" => $repr]);
    }
}
