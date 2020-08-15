<?php

namespace App\Model\Common;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressBook extends Model
{    
    use SoftDeletes;
    
    protected $table = 'address_book';

    protected $guarded  = ['id', 'created_at', 'updated_at'];


    public function getDefaultAddressAttribute($value) 
    {
        return (int) $value;
    }
   
}
