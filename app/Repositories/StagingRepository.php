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
            $ext = $files['img']->getClientOriginalExtension();
            $extLength = strlen($ext) + 1;
            $originName = substr($originName, 0, -$extLength);
            $filename = $staging->id. "_img.$ext";
            $staging->title = $originName;
            $staging->img = $path. $filename;
            $staging->save();
            $files['img']->move($root. $path, $filename);
        }
    }

    public function lists($user, $params) {
        $nowPage = isset($params['nowPage']) ? (int) $params['nowPage'] : 1;
        $offset = isset($params['offset']) ? (int) $params['offset'] : 10;
        $stagingQuery = Staging::orderBy('id', 'asc')
            ->skip(($nowPage-1) * $offset)
            ->take($offset);
        if(isset($params['area']) && trim($params['area']) != '') {
            $stagingQuery->where('area', '=', $params['area']);
        }
        $stagings = $stagingQuery->get();
        foreach($stagings as $i => $staging) {
            $stagings[$i]['img'] = '/uploads'. $stagings[$i]['img'];
        }
        return $stagings;
    }

    public function listsAmount($user, $params) {
        $stagingQuery = Staging::orderBy('id', 'asc');
        if(isset($params['area']) && trim($params['area']) != '') {
            $stagingQuery->where('area', '=', $params['area']);
        }
        return $stagingQuery->count();
    }
}
