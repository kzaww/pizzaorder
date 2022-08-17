@extends('user.layout.style')

@section('content')
    <div class="row mt-5 d-flex justify-content-center">

        <div class="col-4 ">
            <div class="mb-2">
                <a href="javascript:window.history.back();" class="">
                    <button class="btn bg-dark text-white" style="margin-top: 20px;" aria-label="back">
                        <i class="fas fa-backspace"></i> Back
                    </button>
                </a>
            </div>
            <img src="{{ asset('uploads/'.$pizza->image) }}" class="postition-relative"  width="100%">            <br>
            <a href="{{ route('user#order') }}"><button class="btn btn-primary float-end mt-2 col-12" aria-label="buy"><i class="fas fa-shopping-cart"></i> Order</button></a>
        </div>
        <div class="col-6">
            <table class="table table-bordered">
                <thead class="bordered border-dark border-2">
                    <tr>
                        <th>Title</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Name</b></td>
                        <td>{{ $pizza->pizza_name }}</td>
                    </tr>
                    <tr>
                        <td><b>Price</b></td>
                        <td>{{ $pizza->price }}</td>
                    </tr>
                    <tr>
                        <td><b>Discount</b></td>
                        <td>{{ $pizza->discount_price }}%</td>
                    </tr>
                    @if ($pizza->buy_one_get_one_status == 1)
                        <tr>
                            <td><b>Buy One Get One</b></td>
                            <td>Yes</td>
                        </tr>
                    @else
                    <tr>
                        <td><b>Buy One Get One</b></td>
                        <td>No</td>
                    </tr>
                    @endif
                    <tr>
                        <td><b>Waiting Time</b></td>
                        <td>{{ $pizza->waiting_time }} min</td>
                    </tr>
                    <tr>
                        <td><b>Description</b></td>
                        <td><textarea class="form-control" disabled>{{ $pizza->description }}</textarea></td>
                    </tr>
                    <tr class="">
                        <td></td>
                        <td ><b class="text-danger">Total Price</b><div class=""> <?php echo( $pizza->price-$pizza->price*$pizza->discount_price/100)?>K</div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
