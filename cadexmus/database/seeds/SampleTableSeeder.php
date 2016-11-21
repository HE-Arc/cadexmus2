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

        $path = realpath(public_path('uploads/samples/native'));
        $type="default";

        // http://php.net/manual/fr/class.directoryiterator.php#88459
        foreach (new DirectoryIterator($path) as $fileInfo) {
            if($fileInfo->isDot()) continue;
            $name = explode(".",$fileInfo->getFilename())[0];
            Sample::create([
                "nom"=>$name,
                "url"=>'samples/native/'.$fileInfo->getFilename(),
                "type"=>$type,
            ]);
        }
    }
}
