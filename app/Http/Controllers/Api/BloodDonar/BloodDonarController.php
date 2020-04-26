<?php

namespace App\Http\Controllers\Api\BloodDonar;

use App\Http\Controllers\Controller;
use App\Model\BloodDonar\BloodDonar;
use App\Model\BloodDonar\BloodDonarsView;
use App\Model\BloodDonar\BloodGroup;
use App\Model\Listing\Listing;
use Illuminate\Http\Request;
use Kodevz\MolyDatatable\Facades\MolyDataTable;

class BloodDonarController extends Controller
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;      
    }

    /**
     * Fetch all categories
     *
     * @return array
     */
    public function index(Request $request)
    {   
        $donars = BloodDonar::with('bloodDonateDetails', 'bloodGroup');
                             
        $paginator = MolyDataTable::create($donars)->opJson();

        return $paginator;
    }

    /**
     * Blood groups
     *
     * @return array
     */
    public function bloodGroups()
    {
        return BloodGroup::all();
    }
    
    /**
     * Show the single category by id
     *
     * @param int $id
     * @return void
     */
    public function show(int $id) : BloodDonar
    {
        return BloodDonar::find($id);
    }

    /**
     * Create new category
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {   
        if (!$request->get('id')) {
             $validate = $request->validate([
                'donar_name' => 'required|max:75',
                'phone_number' => 'required|unique:blood_donars|max:75',
                'address' => 'required',
                'blood_group_id' => 'required',
                'status' => 'required'
            ]);
        }

        $donar = new BloodDonar;
        if ($request->get('id')) {
            $donar = BloodDonar::find($request->get('id'));
        }

        

        $donar->donar_name = $request->get('donar_name');
        $donar->phone_number = $request->get('phone_number');
        $donar->address = $request->get('address');
        $donar->blood_group_id = $request->get('blood_group_id');
        $donar->status = $request->get('status');
        $donar->save();

        if (!$request->get('id')) {
            $donar->donar_code = 'MMBLDDO/'.date('Y/m/d') . '/' . $donar->id;
            $donar->save();
        }
   
        return BloodDonar::with('bloodDonateDetails', 'bloodGroup')->find($donar->id);
    }
    
    public function register(Request $request)
    {   
        
        $user = $request->user();

        $donar = new BloodDonar;

        if (BloodDonar::where('mm_user_id', $user->id)->count()) {
            return [
                'status' => true,
                'msg' => 'You are already registered'
            ];
        }
        if ($request->get('id')) {
            $donar = BloodDonar::find($request->get('id'));
        }

    
        $donar->donar_name = $user->first_name . ' ' . $user->last_name;
        $donar->phone_number = $user->phone_no;
        $donar->blood_group_id = $request->get('blood_group_id');
        $donar->mm_user_id = $user->id;
        $donar->save();

        if (!$request->get('id')) {
            $donar->donar_code = 'MMBLDDO/'.date('Y/m/d') . '/' . $donar->id;
            $donar->save();
        }
   
        return [
            'msg' => "Successfully register your blood donar request. Mayilaimanam will be verify soon.",
            'status' => true
        ];
    }

    /**
     * Update category by id
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id) 
    {
        $category = Listing::findOrFail($id);
        
        return $category;
    }

    /**
     * Delete the category by id
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function delete(Request $request, int $id)
    {
        $category = Listing::findOrFail($id);

        $category->delete();

        return 204;
    }


    public function donars(Request $request) 
    {
        // $categoryIds =  $request->get('category_id');

        // if (!count($categoryIds)) {
        //     $categoryIds[] = $request->get('parent_id');
        // }
        
        $bloodDonars = BloodDonarsView::where('status', 'Verified')->orderBy('id', 'DESC');

        return $bloodDonars->skip($request->get('start'))->limit($request->get('end'))->get();
    }
}
