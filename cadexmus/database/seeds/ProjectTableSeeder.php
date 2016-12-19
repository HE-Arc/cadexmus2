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
        $users = User::all();
        $i = 1;
        foreach($users as $user)
        {
            $project->users()->attach($user, array('couleur'=> $i));
            $i++;
        }
        //$project->users()->attach(User::all(), array('couleur'=> 1));
        $samples = Sample::take(2)->get();
        $repr=[
            'tempo' => 120,
            'nbMesures' => 2,
            'tracks' =>[
                [
                    "volume" => 0.2,
                    "sample"=> [
                        "url" => $samples[0]->url,
                        "name" => $samples[0]->nom
                    ],
                    "notes"=>[
                        [
                            "pos"=>0,
                            "len"=>2,
                            "color"=>1
                        ],[
                            "pos"=>32,
                            "len"=>4,
                            "color"=>2
                        ]
                    ]
                ],
                [
                    "vulume" => 0.8,
                    "sample"=> [
                        "url" => $samples[1]->url,
                        "name" => $samples[1]->nom
                    ],
                    "notes"=>[
                        [
                            "pos"=>16,
                            "len"=>8,
                            "color"=>0
                        ]
                    ],
                ],
            ],
        ];
        $project->versions()->create(["numero" => 0, "repr" => $repr]);

        $project2 = Projet::create(["nom"=>"Demo"]);
        $users = User::all();
        $i = 1;
        foreach($users as $user)
        {
            $project2->users()->attach($user, array('couleur'=> $i));
            $i++;
        }

        // $project2->users()->attach(User::all(), array('couleur'=> 1));

        $yolorepr = '{"tempo":"110","tracks":[{"sample":{"name":"Eb4","url":"samples\/native\/instrument\/piano\/midi\/Eb4.mp3"},"volume":"0.5","notes":[{"pos":"0","len":"20","color":"0"},{"pos":"24","len":"4","color":"0"}]},{"sample":{"name":"G4","url":"samples\/native\/instrument\/piano\/midi\/G4.mp3"},"volume":"0.5","notes":[{"pos":"0","len":"20","color":"0"},{"pos":"28","len":"4","color":"0"}]},{"sample":{"name":"G3","url":"samples\/native\/instrument\/piano\/midi\/G3.mp3"},"volume":"0.5","notes":[{"pos":"32","len":"20","color":"0"},{"pos":"52","len":"4","color":"0"}]},{"sample":{"name":"Bb3","url":"samples\/native\/instrument\/piano\/midi\/Bb3.mp3"},"volume":"0.5","notes":[{"pos":"32","len":"20","color":"0"},{"pos":"64","len":"20","color":"0"},{"pos":"56","len":"4","color":"0"},{"pos":"84","len":"4","color":"0"}]},{"sample":{"name":"D4","url":"samples\/native\/instrument\/piano\/midi\/D4.mp3"},"volume":"0.5","notes":[{"pos":"32","len":"20","color":"0"},{"pos":"64","len":"20","color":"0"},{"pos":"60","len":"4","color":"0"},{"pos":"88","len":"4","color":"0"}]},{"sample":{"name":"F4","url":"samples\/native\/instrument\/piano\/midi\/F4.mp3"},"volume":"0.5","notes":[{"pos":"64","len":"20","color":"0"},{"pos":"92","len":"4","color":"0"}]},{"sample":{"name":"F3","url":"samples\/native\/instrument\/piano\/midi\/F3.mp3"},"volume":"0.5","notes":[{"pos":"96","len":"20","color":"0"},{"pos":"116","len":"4","color":"0"}]},{"sample":{"name":"Ab3","url":"samples\/native\/instrument\/piano\/midi\/Ab3.mp3"},"volume":"0.5","notes":[{"pos":"96","len":"20","color":"0"},{"pos":"120","len":"4","color":"0"}]},{"sample":{"name":"C4","url":"samples\/native\/instrument\/piano\/midi\/C4.mp3"},"volume":"0.5","notes":[{"pos":"0","len":"20","color":"0"},{"pos":"96","len":"20","color":"0"},{"pos":"20","len":"4","color":"0"},{"pos":"124","len":"4","color":"0"}]},{"sample":{"name":"hat2","url":"samples\/native\/drums\/hit-hat\/open\/hat2.wav"},"volume":"0.5","notes":[{"pos":"0","len":"8","color":"0"},{"pos":"8","len":"8","color":"0"},{"pos":"16","len":"8","color":"0"},{"pos":"24","len":"8","color":"0"},{"pos":"32","len":"8","color":"0"},{"pos":"40","len":"8","color":"0"},{"pos":"48","len":"8","color":"0"},{"pos":"64","len":"8","color":"0"},{"pos":"72","len":"8","color":"0"},{"pos":"80","len":"8","color":"0"},{"pos":"88","len":"8","color":"0"},{"pos":"96","len":"8","color":"0"},{"pos":"104","len":"8","color":"0"},{"pos":"56","len":"4","color":"0"},{"pos":"112","len":"4","color":"0"},{"pos":"120","len":"4","color":"0"}]},{"sample":{"name":"hat1","url":"samples\/native\/drums\/hit-hat\/closed\/hat1.wav"},"volume":"0.5","notes":[{"pos":"60","len":"2","color":"0"},{"pos":"62","len":"2","color":"0"},{"pos":"116","len":"4","color":"0"},{"pos":"124","len":"4","color":"0"}]},{"sample":{"name":"kick2","url":"samples\/native\/drums\/kick\/acoustic\/kick2.wav"},"volume":"0.5","notes":[{"pos":"0","len":"8","color":"0"},{"pos":"8","len":"8","color":"0"},{"pos":"16","len":"8","color":"0"},{"pos":"28","len":"4","color":"0"},{"pos":"32","len":"8","color":"0"},{"pos":"40","len":"8","color":"0"},{"pos":"48","len":"8","color":"0"},{"pos":"62","len":"2","color":"0"},{"pos":"64","len":"8","color":"0"},{"pos":"72","len":"8","color":"0"},{"pos":"80","len":"8","color":"0"},{"pos":"92","len":"4","color":"0"},{"pos":"96","len":"8","color":"0"},{"pos":"104","len":"8","color":"0"},{"pos":"112","len":"8","color":"0"},{"pos":"126","len":"2","color":"0"}]},{"sample":{"name":"snare1","url":"samples\/native\/drums\/snare\/electro\/snare1.wav"},"volume":"0.5","notes":[{"pos":"16","len":"8","color":"0"},{"pos":"48","len":"8","color":"0"},{"pos":"80","len":"8","color":"0"},{"pos":"112","len":"8","color":"0"},{"pos":"88","len":"4","color":"0"},{"pos":"120","len":"2","color":"0"},{"pos":"122","len":"2","color":"0"},{"pos":"124","len":"2","color":"0"},{"pos":"126","len":"2","color":"0"}]}],"nbMesures":"4"}';
        $project2->versions()->create(["numero" => 0, "repr" => json_decode($yolorepr)]);

    }
}
