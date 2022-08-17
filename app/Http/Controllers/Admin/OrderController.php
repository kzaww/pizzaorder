<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //direct order list
    public function orderList()
    {
        $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',DB::raw('count(*) as count'))
                    ->join('users','orders.customer_id','users.id')
                    ->join('pizzas','orders.pizza_id','pizzas.pizza_id')
                    ->groupBy('orders.customer_id','orders.pizza_id')
                    ->paginate(7);

        return view('admin.order.list')->with(['order'=>$data]);
    }

    //direct today Order list
    public function todayOrder()
    {
        $date = Carbon::now()->toDateString();

        $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',DB::raw('count(*) as count'))
                    ->join('users','orders.customer_id','users.id')
                    ->join('pizzas','orders.pizza_id','pizzas.pizza_id')
                    ->groupBy('orders.customer_id','orders.pizza_id')
                    ->whereDate('orders.order_time',$date)
                    ->paginate(7);


        return view('admin.order.today')->with(['order'=>$data]);
    }

    //search order list
    public function orderSearch(Request $request)
    {
        $searchData = $request->searchData;

        $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',DB::raw('count(*) as count'))
                    ->join('users','orders.customer_id','users.id')
                    ->join('pizzas','orders.pizza_id','pizzas.pizza_id')
                    ->orwhere('users.name','like','%'.$searchData.'%')
                    ->orwhere('pizzas.pizza_name','like','%'.$searchData.'%')
                    ->groupBy('orders.customer_id','orders.pizza_id')
                    ->paginate(7);

        $data ->appends($request->all());
        return view('admin.order.list')->with(['order'=>$data]);
    }

    public function todaySearch(Request $request)
    {
        $searchData = $request->searchData;
        $date = Carbon::now()->toDateString();

        $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name',DB::raw('count(*) as count'))
                    ->join('users','orders.customer_id','users.id')
                    ->join('pizzas','orders.pizza_id','pizzas.pizza_id')
                    ->orwhere('users.name','like','%'.$searchData.'%')
                    ->orwhere('pizzas.pizza_name','like','%'.$searchData.'%')
                    ->groupBy('orders.customer_id','orders.pizza_id')
                    ->whereDate('orders.order_time',$date)
                    ->paginate(7);

        $data ->appends($request->all());
        return view('admin.order.today')->with(['order'=>$data]);
    }
}
