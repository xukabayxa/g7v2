<?php

namespace App\Model\Common;

use Auth;
use App\Model\BaseModel;
use App\Model\Product;
use App\Model\Uptek\G7Info;
use Illuminate\Database\Eloquent\Model;
use DB;

class PromoCampaignProduct extends BaseModel
{
    protected $table = 'promo_campaign_has_products';
}
