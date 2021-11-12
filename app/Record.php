<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $table = 'CaseInfo';
    protected $primaryKey = 'CustID';
    protected $dateFormat = 'U';

    public $timestamps = false;
    protected $keyType = 'string';
    public $incrementing = false;
    public function getDateFormat() {
        return 'Y-m-d H:i:s';
    }
}
