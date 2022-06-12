<?php

namespace App\Model\G7;
use Auth;
use App\Model\BaseModel;
use App\Model\Common\Customer;
use App\Model\Common\User;
use Illuminate\Database\Eloquent\Model;
use DB;

class Config extends BaseModel
{
    protected $table = 'configs';
    protected $fillable = ['g7_id', 'date_reminder'];

    
}
