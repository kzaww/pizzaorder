@extends('user.layout.style')

@section('content')
    <div class="row mt-5 d-flex justify-content-center">
        Order Page
        <div class="col-4">
            <div class="mb-2">
                <a href="{{ route('user#index') }}" class="">
                    <button class="btn bg-dark text-white float-sm-left" style="margin-top: 20px;">
                        <i class="fas fa-backspace"></i> Back
                    </button>
                </a>
            </div>
            <img src="{{ asset('uploads/'.$pizza->image) }}" class="postition-relative"  width="100%">

        </div>
        <div class="col-6">
            @if (Session::has('totalTime'))
            <div class="alert alert-dismissible fade show alert-success" role="alert">
                Order success....!!Please wait {{ Session::get('totalTime') }} Minutes...
                <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="$('.alert').hide()" aria-label="close" ></button>
            </div>
        @endif
            <h3 class="text-decoration-underline">Name:</h3>
            <span>{{ $pizza ->pizza_name }}</span><hr>

            <h3 class="text-decoration-underline">Price:</h3>
            <span class="text-danger"><?php echo( $pizza->price-$pizza->price*$pizza->discount_price/100)?>K</span><hr>

            <h3 class="text-decoration-underline">Waiting Time:</h3>
            <span>{{ $pizza ->waiting_time }} min</span><hr>

            <form action="" method="POST">
                @csrf
                <h3 class="text-decoration-underline">Pizza Count:</h3>
                <input type="number" class="form-control" name="pizzaCount" max="10" placeholder="no of pizza" autofocus required>
                {{-- @if ($errors->has('pizzaCount'))
                    <span class="text-danger">{{ $errors->first('pizzaCount') }}</span>
                @endif --}}
                <hr>


                <h3 class="text-decoration-underline">Payment Type:</h3>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="paymentType" id="inlineRadio1" value="1" required>
                        <label class="form-check-label" for="inlineRadio1">credit card</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="paymentType" id="inlineRadio2" value="2" required>
                        <label class="form-check-label" for="inlineRadio2">cash on delivery</label>
                    </div>
                    {{-- <br>
                    @if ($errors->has('paymentType'))
                        <span class="text-danger">{{ $errors->first('paymentType') }}</span>
                    @endif --}}
                    <hr>
                    <button type="submit" class="btn btn-warning float-end mb-2 col-12" aria-label="Buy"><i class="fas fa-coins"></i> Buy</button>
            </form>
        </div>
    </div>
@endsection
