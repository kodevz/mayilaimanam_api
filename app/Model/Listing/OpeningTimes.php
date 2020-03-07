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

}
