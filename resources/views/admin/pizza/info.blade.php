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
                                <legend class="text-center">Pizza Info</legend>
                            </div>
                            <div class="card-body ">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <div class="text-center ">
                                            <img src="{{ asset('uploads/'.$pizza->image) }}" class="rounded-circle" style="width:250px;height:250px;object-fit:cover">
                                        </div>
                                        <table class=" table table-bordered table-hover text-nowrap text-center mt-4">
                                            <thead>
                                                <tr>
                                                    <th class="w-50">Title</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><b>Name  :</b></td>
                                                    <td>{{ $pizza->pizza_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Price  :</b></td>
                                                    <td>{{ $pizza->price }} Kyats</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Publish Status  :</b></td>
                                                    <td>
                                                        @if ($pizza->publish_status == 1)
                                                            Yes
                                                        @else
                                                            No
                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td><b>Category  :</b></td>
                                                    <td>{{ $pizza->category_id }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Discount  :</b></td>
                                                    <td>{{ $pizza->discount_price }} %</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Buy One Get One  :</b></td>
                                                    <td>
                                                        @if ($pizza->buy_one_get_one_status == 1)
                                                            Yes
                                                        @else
                                                            No
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Waiting Time  :</b></td>
                                                    <td>{{ $pizza->waiting_time}} min</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Description  :</b></td>
                                                    <td><textarea name="" id="" class="form-control" rows="5" disabled >{{ $pizza->description}}</textarea> </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
