<?php

namespace App\Model\GeneralAccount;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Attribute.
 *
 * @author  The scaffold-interface created at 2017-01-12 12:11:55pm
 * @link  https://github.com/amranidev/scaffold-interface
 */
class Generalaccount extends Model
{
    public $timestamps = false;

    protected $table = 'accounts';

}
