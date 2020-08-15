<?php

namespace App\Model\BloodDonar;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BloodDonar extends Model
{
    use SoftDeletes;
    
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
