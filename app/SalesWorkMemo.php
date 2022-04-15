<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesWorkMemo extends Model
{
    protected $table = 'SalesWorkMemo';
    protected $primaryKey = 'WorkMemoID';
    protected $dateFormat = 'U';

    public $timestamps = false;

    public function getDateFormat() {
        return 'Y-m-d H:i:s';
    }
}

