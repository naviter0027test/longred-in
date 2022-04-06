<?php

namespace App\Repositories;

use Illuminate\Support\Facades\File;
use App\Staging;
use App\Account;
use Exception;
use Storage;

class StagingRepository
{
    public function create($params, $files = []) {
        if(isset($files['img'])) {
            $ext = $files['img']->getClientOriginalExtension();
            $extTmp = strtolower($ext);
            $imgArr = ['jpg', 'jepg', 'png', 'bmp', 'gif', 'tiff'];
            if(in_array($extTmp, $imgArr) == false)
                throw new Exception('圖片格式限定:jpg, jepg, png, bmp, gif, tiff');
        }

        $tit = '';
        if(isset($params['title']) && trim($params['title']) != '')
            $tit = $params['title'];
        $staging = new Staging();
        $staging->title = $tit;
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
            //$staging->title = $originName;
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
            $stagAttr = $staging->getAttributes();
            $stagings[$i]['img'] = '/uploads'. $stagings[$i]['img'];
            foreach($stagAttr as $key => $value) {
                if(is_null($value)) {
                    $stagings[$i]->{$key} = '';
                }
                if($key == 'area') {
                    $stagings[$i]->area = $value. '';
		}
	    }
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

    public function del($id) {
        $root = config('filesystems')['disks']['uploads']['root'];

        $staging = Staging::where('id', '=', $id)->first();
        if(isset($staging->id) == false) {
            throw new Exception('指定分期表不存在');
        }
        //echo $root. $staging->img;
        if(File::exists($root. $staging->img) && trim($staging->img) != '') {
            unlink($root. $staging->img);
        }
        $staging->delete();
    }
}
