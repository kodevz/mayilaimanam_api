<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Model\Common\AddressBook;
use Illuminate\Http\Request;

class AddressBookApiController extends Controller
{
    public function __construct()
    {
        
    }

    public function index() 
    {
        return [
            'data'=> AddressBook::all()
        ];
    }

    public function show(int $id) 
    {
        return [
            'data'=> AddressBook::find($id)
        ];
    }

    public function store(Request $request) 
    {
        
        $addressBook = new AddressBook;
       
        $addressBook->name = $request->get('name');
        $addressBook->address_1 = $request->get('address_1');
        $addressBook->address_2 = $request->get('address_2');
        $addressBook->city = $request->get('city');
        $addressBook->state = $request->get('state');
        $addressBook->pin_code = $request->get('pin_code');
        $addressBook->default_address = $request->get('default_address');
        $addressBook->land_mark = $request->get('land_mark');
        $addressBook->save();

        return [
            'status' => true,
            'msg' => 'Saved successfully',
            'data' => $addressBook
        ];
    }

    public function update(Request $request)
    {
        $addressBook = AddressBook::find($request->get('id'));

        $addressBook->name = $request->get('name');
        $addressBook->address_1 = $request->get('address_1');
        $addressBook->address_2 = $request->get('address_2');
        $addressBook->city = $request->get('city');
        $addressBook->state = $request->get('state');
        $addressBook->pin_code = $request->get('pin_code');
        $addressBook->default_address = $request->get('default_address');
        $addressBook->land_mark = $request->get('land_mark');
        $addressBook->save();

        return [
            'status' => true,
            'msg' => 'Update successfully',
            'data' => $addressBook
        ];
    }

    public function delete(int $id)
    {
        $addressBook = AddressBook::findOrFail($id);

        $addressBook->delete();

        return [
            'status' => true,
            'msg' => 'Delete Successfully'
        ];
    }

    public function updateSetDefaultAddress(Request $request) 
    {
        $addressBooks = AddressBook::all();

        foreach($addressBooks as $addressBook) {
            $addressBook->default_address = 0;
            $addressBook->save();
        }

       AddressBook::where('id', $request->get('id'))->update(['default_address' => (int) $request->get('default_address')]);

        return [
            'status' => true,
            'message' => 'Succefully set default address'
        ];
    }
}
