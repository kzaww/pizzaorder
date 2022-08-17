@extends('admin.layout.app')

@section('content')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mt-4">
          <div class="col-12">
          <div class='text-center'>
            <h1>{{ $pizza[0]->category_name }}</h1>
          </div>
            <div class="card">
              <div class="card-header">
                <a href="javascript:window.history.back();" class="text-decoration-none text-dark" ><i class="fas fa-arrow-left"></i>Back</a>
                <span class="" style="margin-left: 35%">Total - <button class="btn btn-sm btn-outline-dark color-white">{{ $pizza->total() }}</button></span>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">

                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Image</th>
                      <th>Pizza Name</th>
                      <th>Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($pizza as $item)
                        <tr>
                            <td>{{ $item ->pizza_id  }}</td>
                            <td><a href='{{ asset('uploads/'.$item->image) }}'><img src="{{ asset('uploads/'.$item->image) }}" width='150px' height='100px'></a></td>
                            <td>{{ $item ->pizza_name  }}</td>
                            <td>{{ $item ->price  }}</td>
                        </tr>
                    @endforeach
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

      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
