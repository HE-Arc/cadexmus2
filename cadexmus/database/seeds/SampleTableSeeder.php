<?php

use App\Sample;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class SampleTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        function browseAndCreateSamples($path){

            $realPath = realpath(public_path("uploads/samples/native/$path"));

            foreach (new DirectoryIterator($realPath) as $fileInfo) {
                if($fileInfo->isDot()) continue;
                if($fileInfo->isDir()){
                    browseAndCreateSamples($path."/".$fileInfo->getFilename());
                }else if($fileInfo->isFile()){
                    $tags = str_replace("/"," ",$path);
                    $name = explode(".",$fileInfo->getFilename())[0];
                    Sample::create([
                        "nom"=>$name,
                        "url"=>'samples/native'.$path."/".$fileInfo->getFilename(),
                        "type"=>$tags,
                    ]);
                }
            }
        }

        browseAndCreateSamples('');

    }
}
