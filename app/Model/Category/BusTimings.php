<?php

namespace App\Model\Category;

use App\Model\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class BusTimings extends Model
{
    protected $table = 'bus_timings';
    
    protected $primaryKey = 'id';

    public function getDepartureTime($value)
    {
        return 'hai';
        return Carbon::parse($value)->format('H:i');
    }

}
