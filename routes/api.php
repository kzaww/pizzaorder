<?php

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

route::post('login','AuthController@login');//login
route::post('register','AuthController@register');//register

route::group(['prefix'=>'category','namespace'=>'API','middleware'=>'auth:sanctum'],function(){
    route::get('list','ApiController@categoryList');//List
    route::post('create','ApiController@createCategory');//create
    route::get('details/{id}','ApiController@categoryDetails');//details
    route::get('delete/{id}','ApiController@deleteCategory');//delete
    route::post('update','ApiController@categoryUpdate');//update
});

route::group(['middleware'=>'auth:sanctum'],function(){
    route::get('logout','AuthController@logout');//logout
});
