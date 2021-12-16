<?php

namespace App\Repositories;

use App\Staging;
use App\Account;
use Exception;
use Storage;

class StagingRepository
{
    public function create($params, $files = []) {
        $staging = new Staging();
        $staging->title = '';
        $staging->img = '';
        $staging->area = isset($params['area']) ? $params['area'] : 1;
        $staging->save();
        $root = config('filesystems')['disks']['uploads']['root'];
        $path = date('/Y/m'). '/';
        if(isset($files['img'])) {
            $originName = $files['img']->getClientOriginalName();
            $originName = explode('.', $originName)[0];
            $ext = $files['img']->getClientOriginalExtension();
            $filename = $staging->id. "_img.$ext";
            $staging->title = $originName;
            $staging->img = $path. $filename;
            $staging->save();
            $files['img']->move($root. $path, $filename);
        }
    }
}
