<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserCheckMiddleware;
use App\Http\Middleware\AdminCheckMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if(Auth::check()){
            if(Auth::user()->role == 'admin'){
                return redirect()->route('admin#profile');
            }else if(Auth::user()->role == 'user'){
                return redirect()->route('user#index');
            }
        }
    })->name('dashboard');
});

route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>[AdminCheckMiddleware::class]],function(){
    route::get('profile','AdminController@profile')->name('admin#profile')->middleware([AdminCheckMiddleware::class]);
    route::post('update/{id}','AdminController@updateProfile')->name('admin#updateProfile');
    route::post('changePassword/{id}','AdminController@changePassword')->name('admin#change');

    route::get('userList','UserController@userList')->name('admin#userList');
    route::get('adminList','UserController@adminList')->name('admin#adminList');
    route::get('userList/search','UserController@userSearch')->name('admin#userSearch');
    route::get('userList/delete/{id}','UserController@userDelete')->name('admin#userDelete');
    route::get('adminlist/search','UserController@adminSearch')->name('admin#adminSearch');
    route::get('adminList/delete/{id}','UserController@adminDelete')->name('admin#adminDelete');

    route::get('category','CategoryController@category')->name('admin#category');//list
    route::get('addCategory','CategoryController@addCategory')->name('admin#addCategory');
    route::post('addCategory','CategoryController@createCategory')->name('admin#createCategory');
    route::get('deleteCategory/{id}','CategoryController@deleteCategory')->name('admin#deleteCategory');
    route::get('editCategory/{id}','CategoryController@editCategory')->name('admin#editCategory');
    route::post('updateCategory','CategoryController@updateCategory')->name('admin#updateCategory');
    route::get('category/search','CategoryController@searchCategory')->name('admin#searchCategory');
    route::get('categoryItem/{id}','PizzaController@categoryItem')->name('admin#categoryItem');
    route::get('category/download','CategoryController@categoryDownload')->name('admin#categoryDownload');

    route::get('pizza','PizzaController@pizza')->name('admin#pizza');
    route::get('createPizza','PizzaController@createPizza')->name('admin#createPizza');
    route::post('insertPizza','PizzaController@insertPizza')->name('admin#insertPizza');
    route::get('deletePizza/{id}','PizzaController@deletePizza')->name('admin#deletePizza');
    route::get('pizzaInfo/{id}','PizzaController@pizzaInfo')->name('admin#pizzaInfo');
    route::get('edit/{id}','PizzaController@editPizza')->name('admin#editPizza');
    route::post('updatePizza','PizzaController@updatePizza')->name('admin#pizzaUpdate');
    route::get('pizza/search','PizzaController@searchPizza')->name('admin#searchPizza');
    route::get('pizza/download','PizzaController@pizzaDownload')->name('admin#pizzaDownload');

    route::get('contact/list','ContactController@contactList')->name('admin#contactList');
    route::get('contact/search','ContactController@contactSearch')->name('admin#contactSearch');
    route::get('contact/download','ContactController@contactDownload')->name('admin#contactDownload');

    route::get('order/list','OrderController@orderList')->name('admin#orderList');
    route::get('todayOrder/list','OrderController@todayOrder')->name('admin#todayOrder');
    route::get('order/search','OrderController@orderSearch')->name('admin#orderSearch');
    route::get('today/search','OrderController@todaySearch')->name('admin#todaySearch');
});

route::group(['prefix'=>'user','middleware'=>[UserCheckMiddleware::class]],function(){
    route::get('/',"UserController@index")->name('user#index');

    route::get('pizza/details/{id}','UserController@pizzaDetails')->name('user#pizzaDetails');
    route::get('category/search/{id}','UserController@categorySearch')->name('user#categorySearch');
    route::get('search/item','UserController@searchItem')->name('user#searchItem');

    route::get('search/pizzaItem','UserController@searchPizzaItem')->name('user#searchPizzaItem');

    route::post('contactCreate','Admin\ContactController@createContact')->name('admin#createContact');

    route::get('order','UserController@order')->name('user#order');
    route::post('order','UserController@placeOrder')->name('user#placeOrder');
});
