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
        $samples = Sample::take(2)->get();
        $repr=[
            'tempo' => 120,
            'tracks' =>[
                [
                    "sample"=> [
                        "url" => $samples[0]->url,
                        "name" => $samples[0]->nom
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
                        "url" => $samples[1]->url,
                        "name" => $samples[1]->nom
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

        $projet2 = Projet::create(["nom"=>"Yolo"]);
        $projet2->users()->attach(User::all());
        $projet2->versions()->create(["numero" => 0, "repr" => ['tempo'=>90]]);
    }
}
