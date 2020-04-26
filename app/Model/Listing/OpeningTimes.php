<?php

namespace App\Model\Listing;

use Illuminate\Database\Eloquent\Model;

class OpeningTimes extends Model
{
    protected $table = 'openingtimes';
    
    protected $guarded = ['id'];

    public $timestamps = false;

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }
    

    public function setStartAttribute($value) 
    {
         $this->attributes['start'] = $value == 'null' || $value == 'undefine' ? NULL : $value;
    }

    public function setEndAttribute($value) 
    {
         $this->attributes['end'] = $value == 'null' || $value == 'undefine' ? NULL : $value;
    }

    public function setHolidayAttribute($value)
    {
        $this->attributes['holiday'] = $value == 'true' ? 1 : 0;
    }

    public function getHolidayAttribute($value)
    {
        return $value == '1' ? true : false;
    }

}
