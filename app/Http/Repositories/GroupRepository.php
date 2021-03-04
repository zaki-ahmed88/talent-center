<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\GroupInterface;
use App\Http\Interfaces\TeachersInterface;
use App\Http\Traits\ApiDesignTrait;
use App\Models\Group;



use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class GroupRepository implements GroupInterface {

    use ApiDesignTrait;



    private $groupModel;



    public function __construct(Group $group) {

        $this->groupModel = $group;
    }




    public function addGroup($request){

       $validation = Validator::make($request->all(),[
           'name' => 'required|min:3',
           'body' => 'required',
           'image' => 'required',
           'teacher_id' => 'required|exists:users,id',
       ]);

       if($validation->fails())
       {
           return $this->ApiResponse(422,'Validation Error', $validation->errors());
       }

       $this->groupModel::create([
           'name' => $request->name,
           'body' => $request->body,
           'image' => $request->image,
           'teacher_id' => $request->teacher_id,
           'created_by' => auth()->user()->id,
       ]);

       return $this->ApiResponse(200, 'Group Was Created');

    }



    public function allGroups(){


        $is_teacher = 1;

        $groups = $this->groupModel::get();

        return $this->ApiResponse(200, 'Done', null, $groups);

    }



    public function deleteGroup($request){

        $validation = Validator::make($request->all(), [
            'group_id' => 'required|exists:groups,id',
        ]);

        if($validation->fails()){
            return $this->ApiResponse(422, 'Validation Error', $validation->errors());
        }

        $group = $this->groupModel::find($request->group_id);

        //dd($staff);

        if($group){

            $group->delete();
            return $this->ApiResponse(200, 'Group Was Deleted', null, $group);

        }

        return $this->ApiResponse(422, 'This Group Not Found');

    }






    public function updateGroup($request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'body' => 'required',
            'image' => 'required',
            'teacher_id' => 'required|exists:users,id',
        ]);

        if($validator->fails()){
            return $this->ApiResponse(422, 'Validation Errors', $validator->errors());
        }

        $group = $this->groupModel::find($request->group_id);

        if($group){

            $group->update([
                'name' => $request->name,
                'body' => $request->body,
                'image' => $request->image,
                'teacher_id' => $request->teacher_id,
            ]);


            return $this->ApiResponse(200, 'Group Was Updated', null, $group);
        }

        return $this->ApiResponse(404, 'Group Not Found');



    }








    public function specificGroup($request){

        $validation = Validator::make($request->all(), [
            'group_id' => 'required|exists:groups,id',
        ]);

        if($validation->fails()){
            return $this->ApiResponse(200, 'Validation Error', $validation->errors());
        }

        $group = $this->groupModel::find($request->group_id);

        if($group){
            return  $this->ApiResponse(200, 'Done', null, $group);
        }

        return  $this->ApiResponse(404, 'Group Not Found');


    }
}
