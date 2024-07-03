<?php

namespace App\Model\ChartofAccount;

use Illuminate\Database\Eloquent\Model;

class chartofaccount extends Model
{
    protected $table = "fi_chartofaccount";
    public $timestamps = false;

    public function childs() {
   
        return $this->hasMany('App\Model\ChartofAccount\chartofaccount','parent_id') ;
    }
}
