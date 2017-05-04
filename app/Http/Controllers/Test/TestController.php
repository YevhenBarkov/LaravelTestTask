<?php

namespace App\Http\Controllers\Test;

use App\Users;
use App\Vocabulary;
use hisorange\BrowserDetect\Provider\BrowserDetectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Facades\Agent;

/**
 * Created by PhpStorm.
 * User: yevhen
 * Date: 03.05.17
 * Time: 2:00
 */
class TestController
{

    public function words()
    {
        $words = Vocabulary::all();
        return view('vocabulary', compact('words'));

    }

    public function getAllUserHashes()
    {
        $data = Users::where('ip', $_SERVER['REMOTE_ADDR'])->get();
        $forReturn = [];
        foreach ($data as $one) {
            $forReturn [] = [
                'id' => $one['id'],
                'origin_words' => $one['origin_words'],
                'hashes' => unserialize($one['saved_hashes'])
            ];
        }
        return $forReturn;
    }

    public function getLastUserHashes()
    {
        $data = Users::where('ip', $_SERVER['REMOTE_ADDR'])
            ->orderBy('created_at', 'desc')
            ->first();
        $forReturn [] = [
            'id' => $data['id'],
            'origin_words' => $data['origin_words'],
            'hashes' => unserialize($data['saved_hashes'])
        ];
        return $forReturn;
    }

    public function save()
    {
        $errors=[];
        $agent = new \Jenssegers\Agent\Agent();

        $users = new Users();
        $users->ip = $_SERVER['REMOTE_ADDR'];
        $users->browser = $agent->browser();
        $users->cookie = serialize($_COOKIE);

        $json = file_get_contents("http://freegeoip.net/json/" . $_SERVER['REMOTE_ADDR']);
        $location = json_decode($json, true);
        if($location['country_name']==''){
            $users->country = "Unknown location";
        }else{
            $users->country = $location['country_name'];
        }

        $hashes = [];
        if (isset($_POST['md5'])) {
            $hashes['md5'] = $_POST['md5'];
        }
        if (isset($_POST['sha1'])) {
            $hashes['sha1'] = $_POST['sha1'];
        }
        if (isset($_POST['gost'])) {
            $hashes['gost'] = $_POST['gost'];
        }
        if (isset($_POST['snefru'])) {
            $hashes['snefru'] = $_POST['snefru'];
        }
        if (isset($_POST['whirlpool'])) {
            $hashes['whirlpool'] = $_POST['whirlpool'];
        }
        if (!$hashes){
            $errors[] = 'Please chose at less one hash';
        }
        $users->saved_hashes = serialize($hashes);
        if (trim($_POST['words'])==''){
            $errors[] = 'Empty string';
        }
        $users->origin_words = trim($_POST['words']);

        if ($errors){
            $words = Vocabulary::all();
            return view('vocabulary', compact('words', 'errors'));
        }
        $users->save();

        return redirect('/');
    }

    public function hash()
    {
        $errors=[];
        $hashes = [];
        $str = trim($_GET['allSelectedWords']);
        if($str==''){
            $errors[] = "Chose words please.";
        }
        if (isset($_GET['md5'])) {
            $hashes['md5'] = md5($str);
        }
        if (isset($_GET['sha1'])) {
            $hashes['sha1'] = sha1($str);
        }
        if (isset($_GET['gost'])) {
            $hashes['gost'] = hash('gost', $str);
        }
        if (isset($_GET['snefru'])) {
            $hashes['snefru'] = hash('snefru', $str);
        }
        if (isset($_GET['whirlpool'])) {
            $hashes['whirlpool'] = hash('whirlpool', $str);
        }
        if (!$hashes){
            $errors[] = "Chose at less one algorithm.";
        }

        if ($errors){
            $words = Vocabulary::all();
            return view('vocabulary', compact('words', 'errors'));
        }
        return view('result', compact('str', 'hashes'));
    }
}