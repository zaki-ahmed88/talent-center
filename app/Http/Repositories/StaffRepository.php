<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Http\Traits\ApiDesignTrait;
//use App\Models\role;
use App\Models\Role;
use App\Models\User;

use App\Http\Interfaces\StaffInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class StaffRepository implements StaffInterface{

    use ApiDesignTrait;



    private $userModel;
    private $roleModel;



    public function __construct(User $user, Role $role) {

        $this->userModel = $user;
        $this->roleModel = $role;
    }




    public function addStaff($request)
    {

        //dd($request);
       $validation = Validator::make($request->all(),[
           'name' => 'required|min:3',
           'phone' => 'required',
           'email' => 'required|email|unique:users',
           'password' => 'required|min:8',
           'role_id' => 'required|exists:roles,id',
       ]);

       if($validation->fails())
       {
           return $this->ApiResponse(422,'Validation Error', $validation->errors());
       }

       $this->userModel::create([
           'name' => $request->name,
           'phone' => $request->phone,
           'email' => $request->email,
           'password' => Hash::make($request->password),
           'role_id' => $request->role_id,
           'status' => 0,
       ]);

       return $this->ApiResponse(200, 'Staff Was Created');

    }



    public function allStaff(){

//        $roles = ['Admin', 'Secretary', 'Support'];
//       $staff = $this->roleModel::whereIn('name', $roles)->get();
//       dd($staff);

//        $staff = $this->roleModel::where('is_staff', 1)->with('roleUsers')->get();


        $is_staff = 1;

        $staff = $this->userModel::whereHas('roleName', function ($query) use ($is_staff){
            return $query->where('is_staff', $is_staff);
        })->with('roleName')->get();

//        $staff = $this->userModel::get();
        return $this->ApiResponse(200, 'Done', null, $staff);

    }



    public function deleteStaff($request){

        $validation = Validator::make($request->all(), [
            'staff_id' => 'required|exists:users,id',
        ]);

        if($validation->fails()){
            return $this->ApiResponse(422, 'Validation Error', $validation->errors());
        }

        $staff = $this->userModel::whereHas('roleName', function ($query){
            return $query->where('is_staff', 1);
        })->find($request->staff_id);

        //dd($staff);

        if($staff){

            $staff->delete();
            return $this->ApiResponse(200, 'Staff Was Deleted', null, $staff);

        }

        return $this->ApiResponse(422, 'This User Not Staff');

    }


    public function updateStaff($request){

    }

    public function specificStaff($request){

        $validation = Validator::make($request->all(), [
            'staff_id' => 'required|exists:users,id',
        ]);

        if($validation->fails()){
            return $this->ApiResponse(200, 'Validation Error', $validation->errors());
        }

        $staff = $this->userModel::whereHas('roleName', function ($staff_id){
            return $staff_id->where('is_staff', 1);
        })->find($request->staff_id);

        if($staff){
            return  $this->ApiResponse(200, 'Done', null, $staff);
        }

        return  $this->ApiResponse(404, 'Not Found');


    }
}
