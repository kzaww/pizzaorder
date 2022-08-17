@extends('admin.layout.app')

@section('content')
           <!-- Content Wrapper. Contains page content -->
           <div class="content-wrapper">


            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @if (Session::has('createdSuccess'))
                        <div class="alert alert-dismissible fade show alert-success" role="alert">
                            {{ Session::get('createdSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="$('.alert').hide()" aria-label="close" ></button>
                        </div>
                    @endif
                    @if (Session::has('deleteSuccess'))
                        <div class="alert alert-dismissible fade show alert-success" role="alert">
                            {{ Session::get('deleteSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="$('.alert').hide()" aria-label="close" ></button>
                        </div>
                    @endif
                    @if (Session::has('update'))
                    <div class="alert alert-dismissible fade show alert-success" role="alert">
                        {{ Session::get('update') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="$('.alert').hide()" aria-label="close" ></button>
                    </div>
                @endif
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title pt-1 text-decoration-none">
                                        <a href="{{ route('admin#createPizza') }}"><button class="btn btn-sm btn-dark text-white"><i class="fas fa-plus"></i></button></a>
                                        <a href="{{ route('admin#pizzaDownload') }}"><button class="btn btn-sm btn-success">CSV download</button></a>
                                    </h3>

                                    <span class="" style="margin-left: 35%">Total - <button class="btn btn-sm btn-outline-dark color-white">{{ $pizza->total() }}</button></span>
                                    <div class="card-tools pt-2">
                                        <form action="{{ route('admin#searchPizza') }}" method="get">
                                            @csrf
                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                <input type="text" name="search" class="form-control float-right" placeholder="Search">

                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-bordered table-hover text-nowrap text-center">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Pizza Name</th>
                                                <th>Image</th>
                                                <th>Price</th>
                                                <th>discount</th>
                                                <th>Publish Status</th>
                                                <th>Buy 1 Get 1 Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($status == 0)
                                                <tr>
                                                    <td colspan="8" class="h1 text-muted">There is No data</td>
                                                </tr>
                                            @else
                                                @foreach ($pizza as $item )
                                                <tr>
                                                    <td>{{ $item->pizza_id }}</td>
                                                    <td>{{ $item->pizza_name }}</td>
                                                    <td>
                                                        <img src="{{ asset('uploads/'.$item->image) }}" class="img-thumbnail" width="100px">
                                                    </td>
                                                    <td>{{ $item->price }} Kyats</td>
                                                    <td>{{ $item->discount_price }} %</td>
                                                    <td>
                                                        @if ( $item->publish_status == 0 )
                                                            UnPublish
                                                        @elseif ( $item->publish_status == 1 )
                                                            publish
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ( $item->buy_one_get_one ==1 )
                                                        Yes
                                                    @elseif ( $item->buy_one_get_one ==0 )
                                                        No
                                                    @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin#editPizza',$item->pizza_id) }}"><button class="btn btn-sm bg-dark text-white"><i class="fas fa-edit"></i></button></a>
                                                        <a href="{{ route('admin#deletePizza',$item->pizza_id) }}" onclick="return confirm('Are you sure?')"><button class="btn btn-sm bg-danger text-white"><i class="fas fa-trash-alt"></i></button></a>
                                                        <a href="{{ route('admin#pizzaInfo',$item->pizza_id) }}"><button class="btn btn-sm bg-primary text-white"><i class="far fa-eye"></i></button></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                    <div class="mt-4 d-flex justify-content-center">
                                        {{ $pizza->links() }}
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
@endsection
