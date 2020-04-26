<?php

namespace App\Model\BloodDonar;

use Illuminate\Database\Eloquent\Model;

class BloodGroup extends Model
{
    protected $table = 'blood_groups';

    protected $guarded  = ['id'];

    public $timestamp = false;

    public function bloodDonars()
    {
        return $this->hasMany(BloodDonar::class, 'id', 'blood_group_id');
    }
}
