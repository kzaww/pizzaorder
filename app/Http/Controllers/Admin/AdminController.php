<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //direct admin profile
    public function profile(){
        $id=auth()->user()->id;
        $userData=User::where('id',$id)->first();

        return view('admin.profile.index')->with(['user'=>$userData]);
    }

    //update user data
    public function updateProfile(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'email' => "required|unique:users,email,$id,id",
            'phone' => "required|unique:users,phone,$id,id",
            'address' => 'required',

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $updateData=$this->requestUserData($request);
        User::where('id',$id)->update($updateData);
        return back()->with(['updateSuccess'=>'User Information Updated!']);
    }

    //change Password
    public function changePassword($id,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldPassword'=> 'required',
            'newPassword' => "required",
            'confirm' => "required",

        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $data = User::where('id',$id)->first();

        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        $confirm     = $request->confirm;
        $hashedPassword = $data['password'];

        if (Hash::check($oldPassword, $hashedPassword)) {
            if($newPassword != $confirm){
                return back()->with('newConfirmNotSame', 'Password Confirmation Do Not Match!!,Try Again...');
            }else{
                // if(strlen($newPassword) <= 6 || strlen($confirm) <= 6){
                //     ..length 6 ma kyaw yin run mhar
                // } input mr minlenth htar lite top ma lo top bu
                $hash = Hash::make($newPassword);
                User::where('id',$id)->update([
                    'password' => $hash
                ]);
                return back()->with('successChange','Change Password Successfully');
            }
        }else{
            return back()->with('oldPasswordNotSame', 'Password Do Not Match!!,Try Again...');
        }



    }

    //change data to array format
    private function requestUserData($request)
    {
        return [
            'name'=> $request->name,
            'email' => $request->email,
            'phone' => $request -> phone,
            'address' => $request -> address
        ];
    }
}
