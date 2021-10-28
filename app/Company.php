<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'Company';
    protected $primaryKey = 'id';
    protected $dateFormat = 'U';

    public function getDateFormat() {
        return 'Y-m-d H:i:s';
    }
}

