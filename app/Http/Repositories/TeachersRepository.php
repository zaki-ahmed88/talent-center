<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthInterface;
use App\Http\Interfaces\TeachersInterface;
use App\Http\Traits\ApiDesignTrait;
//use App\Models\role;
use App\Models\Role;
use App\Models\User;

use App\Http\Interfaces\StaffInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class TeachersRepository implements TeachersInterface {

    use ApiDesignTrait;


    private $userModel;
    private $roleModel;



    public function __construct(User $user, Role $role) {

        $this->userModel = $user;
        $this->roleModel = $role;
    }




    public function addTeacher($request){

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

       return $this->ApiResponse(200, 'Teacher Was Created');

    }



    public function allTeachers(){


        $is_teacher = 1;

        $teachers = $this->userModel::whereHas('roleName', function ($query) use ($is_teacher){
            return $query->where('is_teacher', $is_teacher);
        })->with('roleName')->get();

        return $this->ApiResponse(200, 'Done', null, $teachers);

    }



    public function deleteTeacher($request){

        $validation = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:users,id',
        ]);

        if($validation->fails()){
            return $this->ApiResponse(422, 'Validation Error', $validation->errors());
        }

        $teacher = $this->userModel::whereHas('roleName', function ($query){
            return $query->where('is_teacher', 1);
        })->find($request->teacher_id);

        //dd($staff);

        if($teacher){

            $teacher->delete();
            return $this->ApiResponse(200, 'Teacher Was Deleted', null, $teacher);

        }

        return $this->ApiResponse(422, 'This User Not Teacher');

    }






    public function updateTeacher($request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email,'.$request->teacher_id,
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        if($validator->fails()){
            return $this->ApiResponse(422, 'Validation Errors', $validator->errors());
        }

        $staff = $this->userModel::whereHas('roleName', function ($query){
            return $query->where('is_teacher', 1);
        })->find($request->teacher_id);

        if($staff){

            $staff->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,
                'status' => 0,
            ]);


            return $this->ApiResponse(200, 'Teacher Was Updated', null, $staff);
        }

        return $this->ApiResponse(404, 'Teacher Not Found');



    }








    public function specificTeacher($request){

        $validation = Validator::make($request->all(), [
            'teacher_id' => 'required|exists:users,id',
        ]);

        if($validation->fails()){
            return $this->ApiResponse(200, 'Validation Error', $validation->errors());
        }

        $teacher = $this->userModel::whereHas('roleName', function ($teacher_id){
            return $teacher_id->where('is_teacher', 1);
        })->find($request->teacher_id);

        if($teacher){
            return  $this->ApiResponse(200, 'Done', null, $teacher);
        }

        return  $this->ApiResponse(404, 'Teacher Not Found');


    }
}
