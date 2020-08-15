<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Model\Category\Category;
use App\Model\Users\UsersView;
use App\User;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Kodevz\MolyDatatable\Facades\MolyDataTable;

class UsersController extends Controller
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
    public function index()
    {
        $users = UsersView::with('roles', 'modalData');

        $paginator = MolyDataTable::create($users)->opJson();

        return $paginator;
    }

    /**
     * Show the single category by id
     *
     * @param int $id
     * @return void
     */
    public function show(int $id): Category
    {
        return User::find($id);
    }



    /**
     * Create new category
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::updateOrCreate(['email' => $input['email']], $input);


        $roles = User::findOrFail($user->id)->roles();
        $roles->attach([5]);


        $success['token'] =  $user->createToken('MAYILAIMANAM')->accessToken;
        $success['user'] =   $user;
        $success['msg'] =  'User created successfully';

        return response()->json(['success' => $success], 200);
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
        $updateData = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'confirmed' => $request['confirmed'],
            'confirmation_code' => $request['confirmation_code'],
            'active' => $request['active'],
        ];
        $users = User::findOrFail($id);
        $users->roles()->sync([5]);
        $users->update($updateData);

        return $users;
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
        $category = User::findOrFail($id);

        $category->delete();

        return 204;
    }

    /**
     * Show Categories
     *
     * @return void
     */
    public function showUsers(Request $request, int $id = null)
    {

        $users = UsersView::with('roles', 'modalData');

        if ($id) {
            return $users->find($id);
        }

        if ($request->has('first') && $request->has('rows')) {
            return $users->skip($request['first'])->limit($request['rows'])->get();
        }

        return UsersView::with('roles')->get();
    }


    public function saveProfileInfo(Request $request)
    {
        
        $validate = $request->validate([
            'profile_image' => 'required|max:500|mimes:jpeg,png',
        ]);
        

        $user = User::find($request->user()->id);

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->username = $request->get('username');

        if ($request->file('profile_image')) {
            $path =  $request->file('profile_image')->store('public/uploads/profile/images');
            $user->profile_image = str_replace("public/", "http://192.168.43.154/laravel6/mm/public/storage/", $path);
        }

        $user->save();

        return [
            'msg' => 'Profile saved successfully',
            'status' => true,
            'data' => User::find($user->id)
        ];
    }

    
}
