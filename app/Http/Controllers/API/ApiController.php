<?php

namespace App\Http\Controllers\API;

use Response;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //list
    public function categoryList()
    {
        $category=Category::get();
        $response = [
            'status' => 200,
            'message' => 'success',
            'data' => $category,
        ];
        return Response::json($response);
    }

    //create
    public function createCategory(Request $request)
    {
        $data = [
            'category_name' => $request->categoryName,
            'created_at' => Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
        Category::create($data);
        $response = [
            'status' => 200,
            'message' =>'success',
        ];
        return Response::json($response);
    }

    //detail with id on route get method
    public function categoryDetails($id)
    {
        $data = Category::where('category_id',$id)->first();

        if(!empty($data)){
            return Response::json([
                'status' => 200,
                'message' => 'success',
                '$data' => $data,
            ]);
        }else{
            return Response::json([
                'status' => 200,
                'message' => 'fail',
                'data' => $data,
            ]);
        }
    }

    //detail with id on body post method
    // public function categoryDetails(Request $request)
    // {
    //     $id = $request->id;

    //     $data = Category::where('category_id',$id)->first();

    //     if(!empty($data)){
    //         return Response::json([
    //             'status' => 200,
    //             'message' => 'success',
    //             '$data' => $data,
    //         ]);
    //     }else{
    //         return Response::json([
    //             'status' => 200,
    //             'message' => 'fail',
    //             'data' => $data,
    //         ]);
    //     }
    // }

    //delete category with api
    public function deleteCategory($id)
    {
        $data = Category::where('category_id',$id)->first();

        if(empty($data)){
            return Response::json([
                'status' => 200,
                'message' => 'There is no data in this id',
            ]);
        }

        Category::where('category_id',$id)->delete();

        return Response::json([
            'status' => 200,
            'message' => 'success',
        ]);
    }

    //update category with api
    public function categoryUpdate(Request $request)
    {
        $updateData = [
            'category_id' => $request->id,
            'category_name' => $request->categoryName,
            'updated_at' => Carbon::now(),
        ];

        $check = Category::where('category_id',$request->id)->first();
        if(!empty($check)){
            Category::where('category_id',$request->id)->update($updateData);
            return Response::json([
                'status' => 200,
                'message' => 'successfully updated',
            ]);
        }

        return Response::json([
            'status' => 200,
            'message' => 'There is no data in this id',
        ]);
    }
}
