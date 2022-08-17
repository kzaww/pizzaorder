@extends('user.layout.style')

@section('content')
     <!-- Page Content-->
     <div class="container px-4 px-lg-5" id="home">
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
            <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" id="code-lab-pizza" src="https://www.pizzamarumyanmar.com/wp-content/uploads/2019/04/chigago.jpg" alt="..." /></div>
            <div class="col-lg-5">
                <h1 class="font-weight-light" id="about">CODE LAB Pizza</h1>
                <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
                <a class="btn btn-primary" href="#!">Enjoy!</a>
            </div>
        </div>

        <!-- Content Row-->
        <div class="d-flex">
            <div class="col-3 me-5">
                <div class="">
                    <div class="py-5 text-center">
                        <form class="d-flex m-5" method="GET" action="{{ route('user#searchItem') }}">
                            @csrf
                            <div class="input-group">
                                <input class="form-control" name="searchData" value="{{ old('searchData')}}" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-dark btn-sm" type="submit">Search</button>
                            </div>
                        </form>
                        <div class="bg-secondary">
                            <a href="{{ route('user#index') }}" class="text-decoration-none"><div class="m-2 p-2 pe-3 text-white">All</div></a>
                            @if (count($category) < 5)
                                @foreach ($category as $item)
                                    <a href="{{ route('user#categorySearch',$item->category_id) }}" class="text-decoration-none "><div class="m-2 p-2 text-white">{{ $item->category_name }}</div></a>
                                @endforeach
                            @else
                                <div class="container " style="height: 250px;overflow-Y:scroll;overflow-X:hidden">
                                    @foreach ($category as $item)
                                        <a href="{{ route('user#categorySearch',$item->category_id) }}" class="text-decoration-none"><div class="m-2 p-2 text-white">{{ $item->category_name }}</div></a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <hr>
                        <form action="{{ route('user#searchPizzaItem') }}" method="GET">
                            @csrf
                            <div class="text-center m-4 p-2">
                                <h3 class="mb-3">Start Date - End Date</h3>

                                    <input type="date" name="startDate" id="" class="form-control"> -
                                    <input type="date" name="endDate" id="" class="form-control">

                            </div>
                            <hr>
                            <div class="text-center m-4 p-2">
                                <h3 class="mb-3">Min - Max Amount</h3>

                                    <input type="number" name="minPrice" id="" class="form-control" placeholder="minimum price"> -
                                    <input type="number" name="maxPrice" id="" class="form-control" placeholder="maximun price">

                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-secondary text-white">Search <i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="row gx-4 gx-lg-5 justify-content-around" id="pizza">
                    @if ($status == 0)
                        <div class="" style="width: 750px">
                            <h3 class="text-muted text-center" style="line-height: 100vh">There is no data yet!!</h3>
                        </div>
                    @else
                        @foreach ($pizza as $item )
                            <div class="col-md-4 col-sm-4 col-4 mb-5">
                                <div class="card" style="height: 310px;width:220px;">
                                    <!-- Sale badge-->

                                    @if ($item->buy_one_get_one_status == 1)
                                        <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Buy One Get One</div>
                                    @endif
                                    <!-- Product image-->
                                    <img class="card-img-top" id="pizzaImage" src="{{ asset('uploads/'.$item->image) }}" height="170px" alt="..." />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <!-- Product name-->
                                            <h5 class="fw-bolder">{{ $item->pizza_name }}</h5>
                                            <!-- Product price-->
                                            @if ($item->discount_price != 0)
                                                <span class="text-danger text-decoration-line-through">{{ $item->price }}K</span> <?php echo( $item->price-$item->price*$item->discount_price/100)?>K
                                            @else
                                            <span class="text-muted">{{ $item->price }}K</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{ route('user#pizzaDetails',$item->pizza_id) }}">More Details</a></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div class="d-flex justify-content-center">
                    {{ $pizza->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="text-center d-flex justify-content-center align-items-center" id="contact">
        <div class="col-4 border shadow-sm ps-5 pt-5 pe-5 pb-2 mb-5">
            @if (Session::has('contactSuccess'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('contactSuccess') }}
                    <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="close"></button>
                </div>
            @endif
            <h3>Contact Us</h3>

            <form action="{{ route('admin#createContact') }}" class="my-4" method="POST">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" class="form-control my-3" placeholder="Name" required>
                <input type="text" name="email" value="{{ old('email') }}" class="form-control my-3" placeholder="Email" required>
                <textarea class="form-control my-3" name="message" rows="3" placeholder="Message" required>{{ old('message') }}</textarea>
                <button type="submit" class="btn btn-secondary">Send <i class="fas fa-arrow-right"></i></button>
            </form>
        </div>
    </div>
@endsection
