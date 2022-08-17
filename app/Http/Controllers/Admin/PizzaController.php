<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
        //direct pizza page
        public function pizza(){
            if(Session::has('pizza_search'))
            {
                Session::forget('pizza_search');
            }
            $data=Pizza::paginate(7);

            if(count($data) == 0 ){
                $emptyStatus = 0;
            }else{
                $emptyStatus = 1;
            }
            return view('admin.pizza.list')->with(['pizza'=>$data,'status'=>$emptyStatus]);
        }

        // direct create pizza
        public function createPizza()
        {
            $category=Category::get();
            return view('admin.pizza.create')->with(['category'=>$category]);
        }

        // insert pizza
        public function insertPizza(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'pizza_name'=>'reqired',
                'image'=>'required',
                'price'=>'required',
                'public'=>'required',
                'category'=>'required',
                'discount'=>'required',
                'buyGet'=>'required',
                'time'=>'required',
                'description'=>'required'   ,

            ]);

            if ($validator->fails()) {
                return back()
                            ->withErrors($validator)
                            ->withInput();
            }
            $file = $request->image;
            $fileName = uniqid().'_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/',$fileName);

            $data=$this->requestPizzaData($request,$fileName);

            Pizza::create($data);
            return redirect()->route('admin#pizza')->with(['createdSuccess'=>'Successfully created']);
        }

        //delete pizza
        public function deletePizza($id)
        {
            $file=Pizza::select('image')->where('pizza_id',$id)->first();
            $fileName=$file['image'];

            Pizza::where('pizza_id',$id)->delete(); //DB delete
            //project delete
            if(File::exists(public_path().'/uploads/'.$fileName)){
                File::delete(public_path().'/uploads/'.$fileName);
            }

            return back()->with(['deleteSuccess'=>'Success Deleted!']);
        }

        //pizza info
        public function pizzaInfo($id)
        {
            $data=Pizza::where('pizza_id',$id)->first();
            return view('admin.pizza.info')->with(['pizza'=>$data]);
        }

        //edit pizza
        public function editPizza($id)
        {
            $data=Pizza::select()
                    ->join('categories','pizzas.category_id','=','categories.category_id')
                    ->where('pizza_id',$id)
                    ->first();
            $category=Category::get();

            return view('admin.pizza.edit')->with(['pizza'=>$data,'category'=>$category]);
        }

        //update pizza
        public function updatePizza(Request $request)
        {
            $d=$request->all();
            $id=$d['id'];
            unset($d['id']);
            $updateData=$this->requestUpdatePizzaData($d);
            if(isset($updateData['image']))
            {
                //get old image name
                $file=Pizza::select('image')->where('pizza_id',$id)->first();
                $fileName=$file['image'];

                // delete old image
                if(File::exists(public_path().'/uploads/'.$fileName)){
                    File::delete(public_path().'/uploads/'.$fileName);
                }

                $file=$updateData['image'];
                $imageName = uniqid().'_'.$file->getClientOriginalName();
                $file->move(public_path().'/uploads/',$imageName);
                $updateData['image'] = $imageName;


            }
                Pizza::where('pizza_id',$id)->update($updateData);
                return redirect()->route('admin#pizza')->with(['update'=>'Pizza updated!!']);

        }

        // search pizza
        public function searchPizza(Request $request)
        {
            $searchKey = $request->search;
            $searchData=Pizza::orwhere('pizza_name','like','%'.$searchKey.'%')
                                ->orwhere('price','like','%'.$searchKey.'%')
                                ->paginate(7);
            $searchData->appends($request->all());

            Session::put('pizza_search',$searchKey);

            if(count($searchData) == 0 ){
                $emptyStatus = 0;
            }else{
                $emptyStatus = 1;
            }
            return view('admin.pizza.list')->with(['pizza'=>$searchData,'status'=>$emptyStatus]);
        }

        //category item
        public function categoryItem($id)
        {
            $data = Pizza::select('pizzas.*','categories.category_name')
                        ->join('categories','categories.category_id','pizzas.category_id')
                        ->where('pizzas.category_id',$id)
                        ->paginate(5);

            return view('admin.category.item')->with(['pizza'=>$data]);
        }

        //pizza CSV DOWNLOAD
        public function pizzaDownload()
        {
            If(Session::has('pizza_search'))
            {
                $pizza=Pizza::orwhere('pizza_name','like','%'.Session::get('pizza_search').'%')
                ->orwhere('price','like','%'.Session::get('pizza_search').'%')
                ->get();

            }else{
                $pizza=Pizza::get(); //GET DATA
            }

            $csvExporter = new \Laracsv\Export(); //BUILD OBJECT

            $csvExporter->build($pizza, [
                'pizza_id' => 'No',
                'pizza_name' => 'Name',
                'price' => 'Price',
                'discount_price'=>'Discount',
                'publish_status'=>'Publish status',
                'buy_one_get_one_status'=>'Buy One Get One',
                'created_at' => 'Created date',
                'updated_at' => 'Updated date',
            ]);//FIRST '' IS TABLE FIELD(COLUMN) NAME SEC '' IS INSIDE DOWNLOAD FIELD(COLUMN) NAME

            $csvReader = $csvExporter->getReader(); //READER FOR CSV OBJECT

            $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8); // WHICH FONT USE IN READER

            $filename = 'pizzaList.csv'; // FILE NAME

            return response((string) $csvReader)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="'.$filename.'"'); //DOWNLOAD OR EXPROT FILE
        }
        //request update pizza data
        private function requestUpdatePizzaData($request)
        {
            $arr =[
                'pizza_name'=>$request['name'],
                'price'=>$request['price'],
                'publish_status'=>$request['public'],
                'category_id'=>$request['category'],
                'discount_price'=>$request['discount'],
                'buy_one_get_one_status'=>$request['buyGet'],
                'waiting_time'=>$request['time'],
                'description'=>$request['description'],
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ];
            if(isset($request['image'])){
                $arr['image']=$request['image'];
            }
            return $arr;
        }
        // request pizza data
        private function requestPizzaData($request,$fileName)
        {
            return [
                'pizza_name'=>$request->name,
                'image'=>$fileName,
                'price'=>$request->price,
                'publish_status'=>$request->public,
                'category_id'=>$request->category,
                'discount_price'=>$request->discount,
                'buy_one_get_one_status'=>$request->buyGet,
                'waiting_time'=>$request->time,
                'description'=>$request->description,
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
            ];
        }
}
