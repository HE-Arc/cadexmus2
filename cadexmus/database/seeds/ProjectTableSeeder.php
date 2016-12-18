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

        $project2 = Projet::create(["nom"=>"Yolo"]);
        $users = User::all();
        $i = 1;
        foreach($users as $user)
        {
            $project2->users()->attach($user, array('couleur'=> $i));
            $i++;
        }

       // $project2->users()->attach(User::all(), array('couleur'=> 1));

        $yolorepr = '{"tempo":"90","nbMesures":"1","tracks":[{"volume":"1","sample":{"name":"kick2","url":"samples/native/drums/kick/acoustic/kick2.wav"},"notes":[{"color":"1","pos":"0","len":"4"},{"color":"1","pos":"12","len":"4"},{"color":"1","pos":"28","len":"4"},{"color":"1","pos":"20","len":"4"},{"color":"1","pos":"6","len":"2"}]},{"volume":"1","sample":{"name":"snare1","url":"samples/native/drums/snare/electro/snare1.wav"},"notes":[{"color":"1","pos":"8","len":"4"},{"color":"1","pos":"24","len":"4"}]},{"volume":"1","sample":{"name":"hat1","url":"samples/native/drums/hit-hat/closed/hat1.wav"},"notes":[{"color":"1","pos":"0","len":"2"},{"color":"1","pos":"4","len":"2"},{"color":"1","pos":"8","len":"2"},{"color":"1","pos":"12","len":"2"},{"color":"1","pos":"20","len":"2"},{"color":"1","pos":"24","len":"1"},{"color":"1","pos":"28","len":"1"},{"color":"1","pos":"16","len":"2"},{"color":"1","pos":"30","len":"1"},{"color":"1","pos":"26","len":"1"}]},{"volume":"1","sample":{"name":"hat2","url":"samples/native/drums/hit-hat/open/hat2.wav"},"notes":[{"color":"1","pos":"14","len":"2"},{"color":"1","pos":"20","len":"2"}]}]}';
        $project2->versions()->create(["numero" => 0, "repr" => json_decode($yolorepr)]);
    }
}
