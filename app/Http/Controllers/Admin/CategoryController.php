<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //direct category page
    public function category(){
        if(Session::has('category_search'))
        {
            Session::forget('category_search');
        }
        $data=Category::select('categories.*',DB::raw('count(pizzas.category_id) as count'))
                        ->LeftJoin('pizzas','pizzas.category_id','categories.category_id')
                        ->groupBy('categories.category_id')
                        ->paginate(7);

        return view('admin.category.list')->with(['category'=>$data]);
    }

    //direct add  Category page
    public function addCategory(){
        return view('admin.category.addCategory');
    }

    //insert data to category
    public function createCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data= [
            'category_name'=> $request->name,
        ];
        Category::create($data);
        return redirect()->route('admin#category')->with(['categorySuccess'=>'Category Added!!']);
    }

        //delete category
    public function deleteCategory($id){
        Category::where('category_id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Category Deleted!!']);
    }

    //edit category
    public function editCategory($id)
    {
        $data=Category::where('category_id',$id)->first();

        return view('admin.category.update')->with(['category'=>$data]);
    }

    // update category
    public function updateCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $updateData = [
            'category_name'=>$request->name
        ];
        Category::where('category_id',$request->id)->update($updateData);
        return redirect()->route('admin#category')->with(['updateSuccess'=>'Success Update!!']);
    }

    public function searchCategory(Request $request)
    {
        // dd($request->searchData);
        // $data = Category::where('category_name','like','%'.$request->searchData.'%')->paginate(7);

        $data=Category::select('categories.*',DB::raw('count(pizzas.category_id) as count'))
                        ->LeftJoin('pizzas','pizzas.category_id','categories.category_id')
                        ->where('categories.category_name','like','%'.$request->searchData.'%')
                        ->groupBy('categories.category_id')
                        ->paginate(7);

        Session::put('category_search',$request->searchData);

        $data->appends($request->all());
        return view('admin.category.list')->with(['category'=>$data]);
    }

    public function categoryDownload()
    {
        If(Session::has('category_search'))
        {
            $category=Category::select('categories.*',DB::raw('count(pizzas.category_id) as count'))
            ->LeftJoin('pizzas','pizzas.category_id','categories.category_id')
            ->where('categories.category_name','like','%'.Session::get('category_search').'%')
            ->groupBy('categories.category_id')
            ->get();

        }else{
            $category=Category::select('categories.*',DB::raw('count(pizzas.category_id) as count'))
            ->LeftJoin('pizzas','pizzas.category_id','categories.category_id')
            ->groupBy('categories.category_id')
            ->get(); //GET DATA
        }


        $csvExporter = new \Laracsv\Export(); //BUILD OBJECT

        $csvExporter->build($category, [
            'category_id' => 'id',
            'category_name' => 'name',
            'count' => 'Product Count',
            'created_at' => 'created date',
            'updated_at' => 'updated date',
        ]);//FIRST '' IS TABLE FIELD(COLUMN) NAME SEC '' IS INSIDE DOWNLOAD FIELD(COLUMN) NAME

        $csvReader = $csvExporter->getReader(); //READER FOR CSV OBJECT

        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8); // WHICH FONT USE IN READER

        $filename = 'categoryList.csv'; // FILE NAME

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"'); //DOWNLOAD OR EXPROT FILE
    }

}
