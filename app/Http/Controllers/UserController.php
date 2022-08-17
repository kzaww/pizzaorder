<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // direct user home page
    public function index(){
        $data = Pizza::where('publish_status',1)->paginate(9);
        $status = count($data) == 0 ? 0 : 1 ;
        $category = Category::get();
        return view('user.home')->with(['pizza'=>$data,'category'=>$category,'status'=>$status]);
    }

    //detail pizza
    public function pizzaDetails($id)
    {
        $data = Pizza::where('pizza_id',$id)->first();
        Session::put('PIZZA_INFO',$data);
        return view('user.detail')->with(['pizza'=>$data]);
    }

    //search category
    public function categorySearch($id)
    {
        $data = Pizza::where('category_id',$id)
                    ->where('publish_status',1)
                    ->paginate(9);

        $status = count($data) == 0 ? 0 : 1 ;

        $category = Category::get();
        return view('user.home')->with(['pizza'=> $data,'category'=>$category,'status'=>$status]);
    }

    //search with pizza name
    public function searchItem(Request $request)
    {
        $data = Pizza::where('pizza_name','like','%'.$request->searchData.'%')->paginate(9);
        $data ->appends($request->all());
        $status = count($data) == 0 ? 0 : 1 ;
        $category = Category::get();
        return view('user.home')->with(['pizza'=> $data,'category'=>$category,'status'=>$status]);
    }

    //search with pizza price and date
    public function searchPizzaItem(Request $request)
    {
        $min = $request->minPrice;
        $max = $request->maxPrice;
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $query = Pizza::select("*",DB::raw('price - price/discount_price as total_price'));

        if(!is_null($startDate) && is_null($endDate))
        {
            $query = $query -> whereDate('created_at','>=',$startDate);
        }else if(is_null($startDate) && !is_null($endDate))
        {
            $query = $query -> whereDate('created_at','<=',$endDate);
        }else if(!is_null($startDate)  &&  !is_null($endDate))
        {
            $query = $query -> whereDate('created_at','>=',$startDate)
                            -> whereDate('created_at','<=',$endDate);
        }

        if(!is_null($min) && is_null($max))
        {
            if('total_price' == null){
                $query = $query -> where('price','>=',$min);
            }else{
                $query = $query -> where(DB::raw('price - price/discount_price'),'>=',$min);
            }
        }else if(is_null($min) && !is_null($max))
        {
            if('total_price' == null){
                $query = $query -> where('price','<=',$min);
            }else{
                $query = $query -> where(DB::raw('price - price/discount_price'),'<=',$min);
            }
        }else if(!is_null($min)  &&  !is_null($max))
        {
            if('total_price' == null){
                $query = $query -> whereBetween('price',[$min,$max]);
            }else{
                $query = $query -> whereBetween(DB::raw('price - price/discount_price'),[$min,$max]);
            }
        }

        $query = $query -> paginate(9);
        $query ->appends($request->all());

        $status = count($query) == 0 ? 0 : 1 ;
        $category = Category::get();

        return view('user.home')->with(['pizza'=> $query,'category'=>$category,'status'=>$status]);
    }

    //direct order page and get data from session
    public function order()
    {
        $pizzaInfo = Session::get('PIZZA_INFO');

        return view('user.order')->with(['pizza'=>$pizzaInfo]);
    }

    //insert data to order table
    public function placeOrder(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'pizzaCount' => 'required',
            'paymentType' => 'required',
        ]);
        if($validator ->fails())
        {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $pizzaInfo = Session::get('PIZZA_INFO');
        $userId = Auth()->user()->id;
        $count =$request->pizzaCount;
        $orderData = $this->requestOrderData($pizzaInfo,$userId,$request);

        for($i=0;$i<$count;$i++)
        {
            Order::create($orderData);
        }
        if($count <= 3){
            $waitingTime = $pizzaInfo['waiting_time'];
        }elseif($count % 3 == 0){
            $waitingTime = $pizzaInfo['waiting_time'] * intdiv($count,3);  // intdiv(13,2)  result == 6 (dont take reminder only result)
        }elseif($count % 3 !=0){
            $waitingTime = $pizzaInfo['waiting_time'] * intdiv($count,3) + $pizzaInfo['waiting_time'];
        }
        return back()->with(['totalTime'=>$waitingTime]);
    }

    private function requestOrderData($pizzaInfo,$userId,$request)
    {
        return[
            'customer_id'=>$userId,
            'pizza_id' =>$pizzaInfo['pizza_id'],
            'rider_id' => mt_rand(0,9),
            'payment_status' => $request->paymentType,
            'order_time' => Carbon::now(),
        ];
    }
}
