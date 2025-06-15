<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Datatables;

class StaffController extends AdminBaseController
{
    //*** JSON Request
    public function datatables()
    {
        $datas = Admin::where('id','!=',1)->where('id','!=',Auth::guard('admin')->user()->id)->latest('id')->get();
         //--- Integrating This Collection Into Datatables
        return Datatables::of($datas)
                ->addColumn('role', function(Admin $data) {
                    $role = $data->role_id == 0 ? __('No Role') : $data->role->name;
                    return $role;
                }) 
                ->addColumn('action', function(Admin $data) {
                    $delete ='<a href="javascript:;" data-href="' . route('admin-staff-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a>';
                    $AssignUser ='<a data-href="' . route('admin-staff-assign-user',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="icofont-user"></i>'.__('Assign HCP').'</a>';
                    return '<div class="action-list">
                        <a data-href="' . route('admin-staff-show',$data->id) . '" class="view details-width" data-toggle="modal" data-target="#modal1"> <i class="fas fa-eye"></i>'.__("Details").'</a>
                        <a data-href="' . route('admin-staff-edit',$data->id) . '" class="edit" data-toggle="modal" data-target="#modal1"> <i class="fas fa-edit"></i>'.__('Edit').'</a>
                        '.$delete.'
                        '.($data->role_id == 20 ? $AssignUser : "").'
                    </div>';
                }) 
                ->rawColumns(['action'])
                ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index(){
        return view('admin.staff.index');
    }

    public function create(){
        return view('admin.staff.create');
    }

    //*** POST Request
    public function store(Request $request)
    {
        //--- Validation Section
        $rules = [
               'email'      => 'required|email|unique:admins',
               'photo'      => 'required|mimes:jpeg,jpg,png,svg',
                ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = new Admin();
        $input = $request->all();
        if ($file = $request->file('photo')) 
         {      
            $name = \PriceHelper::ImageCreateName($file);
            $file->move('assets/images/admins',$name);           
            $input['photo'] = $name;
        } 
        $input['role'] = 'Staff';
        $input['password'] = bcrypt($request['password']);
        $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section        
        $msg = __('New Data Added Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }

    public function edit($id)
    {
        $data = Admin::findOrFail($id);  
        return view('admin.staff.edit',compact('data'));
    }

    public function update(Request $request,$id)
    {
        //--- Validation Section
        if($id != Auth::guard('admin')->user()->id)
        {
            $rules =
            [
                'photo' => 'mimes:jpeg,jpg,png,svg',
                'email' => 'required|unique:admins,email,'.$id
            ];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
            }
            //--- Validation Section Ends
            $input = $request->all();  
            $data = Admin::findOrFail($id);        
                if ($file = $request->file('photo')) 
                {              
                    $name = \PriceHelper::ImageCreateName($file);
                    $file->move('assets/images/admins/',$name);
                    if($data->photo != null)
                    {
                        if (file_exists(public_path().'/assets/images/admins/'.$data->photo)) {
                            unlink(public_path().'/assets/images/admins/'.$data->photo);
                        }
                    }            
                $input['photo'] = $name;
                } 
            if($request->password == ''){
                $input['password'] = $data->password;
            }
            else{
                $input['password'] = Hash::make($request->password);
            }
            $data->update($input);
            $msg = __('Data Updated Successfully.');
            return response()->json($msg);
        }
        else{
            $msg = __('You can not change your role.');
            return response()->json($msg);            
        }
 
    }

    //*** GET Request
    public function show($id)
    {
        $data = Admin::findOrFail($id);
        return view('admin.staff.show',compact('data'));
    }
    public function assignUsers($id)
    {
        $users = User::where('ban', 0)->get();
        $data = Admin::with('users')->findOrFail($id);
        $selectedUserIds = DB::table('staff_user')
            ->where('staff_id', $data->id)
            ->pluck('user_id')
            ->toArray(); 
        return view('admin.staff.assignUsers',compact('data','users', 'selectedUserIds'));
    }
    public function storeAssignUsers(Request $request)
    {
        $request->validate([
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id'
        ]);
        $staff = Admin::findOrFail($request->id);
        $userIds = $request->input('user_ids', []);
        DB::transaction(function () use ($staff, $userIds) {
            DB::table('staff_user')->where('staff_id', $staff->id)->delete();
            $data = [];
            foreach ($userIds as $userId) {
                $data[] = [
                    'staff_id' => $staff->id,
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($data)) {
                DB::table('staff_user')->insert($data);
            }
        });
        //--- Redirect Section        
        $msg = __('Successfully Assigned.');
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }
    //*** GET Request Delete
    public function destroy($id)
    {
    	if($id == 1)
    	{
        return "You don't have access to remove this admin";
    	}
        $data = Admin::findOrFail($id);
        //If Photo Doesn't Exist
        if($data->photo == null){
            $data->delete();
            //--- Redirect Section     
            $msg = __('Data Deleted Successfully.');
            return response()->json($msg);      
            //--- Redirect Section Ends     
        }
        //If Photo Exist
        if (file_exists(public_path().'/assets/images/admins/'.$data->photo)) {
            unlink(public_path().'/assets/images/admins/'.$data->photo);
        }
        $data->delete();
        //--- Redirect Section     
        $msg = __('Data Deleted Successfully.');
        return response()->json($msg);      
        //--- Redirect Section Ends    
    }
}
