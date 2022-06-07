<?php

namespace App\Model\G7;

use App\Model\BaseModel;
use App\Model\Uptek\Service;

class G7ServicePrice extends BaseModel
{
    protected $fillable = ['g7_id', 'service_id', 'price'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

}
