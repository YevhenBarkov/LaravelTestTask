<?php

namespace App\Console\Commands;

use App\Users;
use App\Vocabulary;
use Carbon\Carbon;
use Illuminate\Console\Command;
use SimpleXMLElement;

class CreateXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create xml files with information about user,
     their saved hashes, origin words and similar words from database.
      User information include ip, browser, cookie and country of the user.
';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $users = Users::all();
        $vocabularyWords = Vocabulary::all();

        $forReturn = [];
        foreach ($users as $one) {
            $segments = explode(' ',$one['origin_words'] );
            $forReturn [] = [
                'ip' => $one['ip'],
                'browser' => $one['browser'],
                'cookie' => unserialize($one['cookie']),
                'country' => $one['country'],
                'origin_words' => $one['origin_words'],
                'hashes' => unserialize($one['saved_hashes']),
                'similar_words' => $this->getSimilarWords($segments, $vocabularyWords)
            ];
        }
        $xmlUserInfo = new SimpleXMLElement("<?xml version=\"1.0\"?><user_info></user_info>");
        $this->arrayToXml($forReturn, $xmlUserInfo);
        $xmlFile = $xmlUserInfo->asXML('public/xml/'.Carbon::now().'user.xml');
        if ($xmlFile) {
            echo 'XML file have been generated successfully';
        } else {
            echo 'XML file generation error.';
        }
    }

    private function arrayToXml($array, SimpleXMLElement &$xmlUserInfo)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xmlUserInfo->addChild("$key");
                    $this->arrayToXml($value, $subnode);
                } else {
                    $subnode = $xmlUserInfo->addChild("item$key");
                    $this->arrayToXml($value, $subnode);
                }
            } else {
                $xmlUserInfo->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }

    private function getSimilarWords($inputArray, $vocabularyArray)
    {
        $similar = [];
        foreach ($inputArray as $originWord){
            foreach ($vocabularyArray as $vocabularyWord){
                if(in_array($vocabularyWord->word, $similar)){
                    continue;
                }
                similar_text($originWord, $vocabularyWord->word, $percent);
                if($percent!=100 && $percent>=70){
                    $similar[]=$vocabularyWord->word;
                    break;
                }
            }
        }
        return implode(" ",$similar);
    }
}
