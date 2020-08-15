<?php

namespace App\Model\Category;

use App\Model\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TrainTimings extends Model
{
    protected $table = 'train_timings';
    
    protected $primaryKey = 'id';

}
