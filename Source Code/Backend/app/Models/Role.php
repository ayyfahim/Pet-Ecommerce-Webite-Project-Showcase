<?php


namespace App\Models;


use App\Models\Traits\ModelCommon;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $guarded = ['id'];
}
