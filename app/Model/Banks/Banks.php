<?php

namespace App\Model\Banks;

use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    protected $table = "fi_banks";
    public $timestamps = false;
    protected $primaryKey = 'bank_id';
}
