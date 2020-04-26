<?php

namespace App\Model\BloodDonar;

use Illuminate\Database\Eloquent\Model;

class BloodDonate extends Model
{
    protected $table = 'blood_donate_details';

    protected $guarded  = ['id', 'created_at', 'updated_at'];

    public function bloodDonar() 
    {
        return $this->belongsTo(BloodDonar::class, 'donars_id');
    }
}
