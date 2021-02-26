<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Http\Traits\ApiDesignTrait;
use App\Models\role;
use App\Models\User;

use App\Http\Interfaces\StaffInterface;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class StaffRepository implements StaffInterface{

    use ApiDesignTrait;



    private $userModel;



    public function __construct(User $user) {

        $this->userModel = $user;
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

    }

    public function updateStaff($request){

    }

    public function deleteStaff($request){

    }

    
}
