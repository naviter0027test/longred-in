<?php

namespace App\Repositories;

use App\Staging;
use App\Account;
use Exception;
use Storage;

class StagingRepository
{
    public function create($params, $files = []) {
        /*
        $root = config('filesystems')['disks']['uploads']['root'];
        $path = date('/Y/m'). '/';
        if(isset($files['img'])) {
            $ext = $files['img']->getClientOriginalExtension();
            $filename = $staging->id. "_pic1.$ext";
            $staging->img = $path. $filename;
            $staging->save();
            $files['img']->move($root. $path, $filename);
        }
         */
    }
}
