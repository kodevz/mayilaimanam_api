<?php

namespace App\Model\Ad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class AdPost extends Model
{
    use SoftDeletes; 

    protected $table = 'ad_post';

    protected $guarded  = ['id', 'created_at', 'updated_at', 'deleted_at'];

    public function setAdPostDate($value)
    {
        $this->attributes['ad_post_date'] =  Carbon::parse($value);
    }

    public function getAdImageAttribute($value) 
    {
        if (strpos($value, 'public') === FALSE) {
            $value = 'public/'. $value;
        }
       
        $appUrl = App::make('url')->to('/');
        return str_replace("public/", "$appUrl/public/storage/", $value);
    }
}
