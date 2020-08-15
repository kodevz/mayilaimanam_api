<?php

namespace App\Model\Common;

use App\Model\Listing\Listing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class HelpLine extends Model
{    
    protected $table = 'helpline_numbers';

    protected $fillable = [
        'name', 'phone_numbers'
    ];

   
}
