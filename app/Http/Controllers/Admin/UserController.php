<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //direct userlist page
    public function userList()
    {
        $userData = User::where('role','user')->paginate(7);
        if(count($userData) == 0 ){
            $emptyStatus = 0;
        }else{
            $emptyStatus = 1;
        }
        return view('admin.user.userlist')->with(['user'=>$userData,'status'=>$emptyStatus]);
    }

    //direct adminList page
    public function adminList()
    {
        $userData = User::where('role','admin')->paginate(7);
        return view('admin.user.adminlist')->with(['admin'=>$userData]);
    }

    //user data search
    public function userSearch(Request $request)
    {
        $response = $this->dataSearch('user',$request);
        return view('admin.user.userlist')->with(['user'=>$response]);
    }

    //admin Data Search
    public function adminSearch(Request $request)
    {
        $response = $this->dataSearch('admin',$request);

        return view('admin.user.adminlist')->with(['admin'=>$response]);
    }

    //delete User data
    public function userDelete($id)
    {
        User::where('id',$id)->delete();
        return back()->with(['deleted'=>'Delete Success']);
    }

    //delete admin data
    public function adminDelete($id)
    {
        User::where('id',$id)->delete();
        return back()->with(['deleted'=>'Delete Success']);
    }

    //data searching
    private function dataSearch($role,$request)
    {
        $searchData = User::where('role',$role);

        $searchData = $searchData->where(function ($query) use($request) {
            $query->orwhere('name','like','%'.$request->searchData.'%')
            ->orwhere('email','like','%'.$request->searchData.'%')
            ->orwhere('phone','like','%'.$request->searchData.'%')
            ->orwhere('address','like','%'.$request->searchData.'%');
        })
        ->paginate(7);


        $searchData->append($request->all());
        return $searchData;
    }
}
