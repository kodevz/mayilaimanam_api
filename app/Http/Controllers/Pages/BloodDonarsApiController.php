<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Model\Ad\AdPost;
use App\Model\BloodDonar\BloodDonarsApi;
use App\Model\Category\CategoryListingView;
use App\Model\Category\TopMenusView;
use Category;
use Illuminate\Http\Request;
use mysqli;

class BloodDonarsApiController extends Controller
{
    public function __construct()
    {
        
    }

    public function index() 
    {
        return [
            'data'=> BloodDonarsApi::all()
        ];
    }

    public function show(int $id) 
    {
        return [
            'data'=> BloodDonarsApi::find($id)
        ];
    }

    public function store(Request $request) 
    {
        
        $donar = new BloodDonarsApi;
       
        $donar->donar_name = $request->get('donar_name');
        $donar->phone_number = $request->get('phone_number');
        $donar->address = $request->get('address');
        $donar->blood_group = $request->get('blood_group');
        $donar->status = $request->get('status');
        $donar->save();

        if (!$request->get('id')) {
            $donar->donar_code = 'MMBLDDO/'.date('Y/m/d') . '/' . $donar->id;
            $donar->save();
        }

        return [
            'status' => true,
            'msg' => 'Saved successfully',
            'data' => $donar
        ];
    }

    public function update(Request $request)
    {
        $donar = BloodDonarsApi::find($request->get('id'));

        $donar->donar_name = $request->get('donar_name');
        $donar->phone_number = $request->get('phone_number');
        $donar->address = $request->get('address');
        $donar->blood_group = $request->get('blood_group');
        $donar->status = $request->get('status');
        $donar->save();

        return [
            'status' => true,
            'msg' => 'Update successfully',
            'data' => $donar
        ];
    }

    public function delete(int $id)
    {
        $donar = BloodDonarsApi::findOrFail($id);

        $donar->delete();

        return [
            'status' => true,
            'msg' => 'Delete Successfully'
        ];
    }
}
