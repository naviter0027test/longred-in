<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staging extends Model
{
    protected $table = 'Staging';
    protected $primaryKey = 'id';
    protected $dateFormat = 'U';

    public function getDateFormat() {
        return 'Y-m-d H:i:s';
    }
}
