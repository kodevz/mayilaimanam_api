<?php

namespace App\Model\BloodDonar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BloodDonarsApi extends Model
{
    use SoftDeletes;
    
    protected $table = 'blood_donars_api';

    protected $guarded  = ['id', 'created_at', 'updated_at'];

}
