<?php

namespace App\Model\BloodDonar;

use Illuminate\Database\Eloquent\Model;

class BloodDonar extends Model
{
    protected $table = 'blood_donars';

    protected $guarded  = ['id', 'created_at', 'updated_at'];

    public function bloodDonateDetails()
    {
        return $this->hasMany(BloodDonate::class, 'donars_id');
    }
    
    public function bloodGroup() 
    {
        return $this->hasOne(BloodGroup::class, 'id', 'blood_group_id');
    }
}
