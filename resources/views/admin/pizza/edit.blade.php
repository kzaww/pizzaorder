@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-10 offset-2 mt-5">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <a href="{{ route('admin#pizza') }}" class="text-decoration-none text-dark" ><i class="fas fa-arrow-left"></i>Back</a>
                        </div>
                        <div class="card">
                            <div class="card-header p-2">
                                <legend class="text-center">Edit Pizza</legend>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    <img src="{{ asset('uploads/'.$pizza->image) }}" class="img-thumbnail" width="150px;">
                                </div>
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">

                                        <form class="form-horizontal" method="POST" action="{{ route('admin#pizzaUpdate') }}" enctype="multipart/form-data">
                                            @csrf
                                            <input type="number" class="form-control" placeholder="" name="id" value="{{ old('name',$pizza->pizza_id) }}" hidden>
                                            <div class="form-group row">
                                                <label for="nm" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="nm" placeholder="Pizza Name" name="name" value="{{ old('name',$pizza->pizza_name) }}" required autofocus>
                                                    {{-- @if ($errors->has('name'))
                                                        <p class="text-danger">{{ $errors->first('name') }}</p>  //required ma yay chin yin
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="img" class="col-sm-2 col-form-label">Image</label>
                                                <div class="col-sm-10">
                                                    <input type="file" class="form-control" id="img" accept="" name="image" >
                                                    {{-- @if ($errors->has('name'))
                                                        <p class="text-danger">{{ $errors->first('name') }}</p>  //required ma yay chin yin
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pr" class="col-sm-2 col-form-label">Price</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="pr" placeholder="Price" name="price" value="{{ old('price',$pizza->price) }}" required>
                                                    {{-- @if ($errors->has('name'))
                                                        <p class="text-danger">{{ $errors->first('name') }}</p>  //required ma yay chin yin
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pub" class="col-sm-2 col-form-label">Public Status</label>
                                                <div class="col-sm-10" >
                                                    <select name="public" class="form-control" id="pub" required>
                                                        <option value="">Choose Option</option>
                                                        @if ($pizza->publish_status == 1)
                                                            <option value="1" selected>Publish</option>
                                                            <option value="0">Unpublish</option>
                                                        @else
                                                            <option value="1">Publish</option>
                                                            <option value="0" selected>Unpublish</option>
                                                        @endif
                                                    </select>
                                                    {{-- @if ($errors->has('name'))
                                                        <p class="text-danger">{{ $errors->first('name') }}</p>  //required ma yay chin yin
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="cat" class="col-sm-2 col-form-label">Category</label>
                                                <div class="col-sm-10">
                                                    <select name="category" class="form-control" id="cat" required >
                                                        <option value="{{ $pizza->category_id }}">{{ $pizza->category_name }}</option>
                                                        @foreach ($category as $item )
                                                            @if ($item->category_id != $pizza->category_id)
                                                                <option value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('category'))
                                                        <p class="text-danger">{{ $errors->first('category') }}</p>  {{--required ma yay chin yin--}}
                                                     @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="dis" class="col-sm-2 col-form-label">Discount</label>
                                                <div class="col-sm-10">
                                                    <input type="number" min="0" max="99" class="form-control" id="dis" placeholder="Discount price" name="discount" value="{{ old('discount',$pizza->discount_price) }}" required >
                                                    {{-- @if ($errors->has('name'))
                                                        <p class="text-danger">{{ $errors->first('name') }}</p>  //required ma yay chin yin
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label  class="col-sm-2 col-form-label" >Buy 1 Get 1</label>
                                                <div class="col-sm-10 mt-2" >
                                                    @if ($pizza->buy_one_get_one_status == 1)
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" name="buyGet" class="form-input-check" id="yes" value="1" checked required >
                                                        <label for="yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" name="buyGet" class="form-input-check" id="no" value="0"  required>
                                                        <label for="no">No</label>
                                                    </div>
                                                    @else
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" name="buyGet" class="form-input-check" id="yes" value="1" required >
                                                        <label for="yes">Yes</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" name="buyGet" class="form-input-check" id="no" value="0" checked required>
                                                        <label for="no">No</label>
                                                    </div>
                                                    @endif
                                                    {{-- @if ($errors->has('name'))
                                                        <p class="text-danger">{{ $errors->first('name') }}</p>  //required ma yay chin yin
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="wt" class="col-sm-2 col-form-label">Waiting time</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" id="wt" placeholder="Waiting time" name="time" value="{{ old('time',$pizza->waiting_time) }}"  required>
                                                    {{-- @if ($errors->has('name'))
                                                        <p class="text-danger">{{ $errors->first('name') }}</p>  //required ma yay chin yin
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Description</label>
                                                <div class="col-sm-10">
                                                    <textarea name="description" class="form-control" id=""  rows="3" placeholder="..."  required>{{ old('description',$pizza->description) }}</textarea>
                                                    {{-- @if ($errors->has('name'))
                                                        <p class="text-danger">{{ $errors->first('name') }}</p>  //required ma yay chin yin
                                                    @endif --}}
                                                </div>
                                            </div>
                                            <div class="form-group row float-right mr-1">
                                                <div class="offset-sm-2 col-sm-10 ">
                                                    <button type="submit" class="btn btn bg-dark text-white">Update</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
