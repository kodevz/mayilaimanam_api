<?php

namespace App\Model\Ad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
        return str_replace("public/", "http://192.168.43.154:8000/storage/", $value);
    }

    
}
