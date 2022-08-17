@extends('admin.layout.app')

@section('content')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if(Session::has('deleted'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{Session::get('deleted')}}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="$('.alert').hide()"></button>
        </div>
          @endif
        <div class="row mt-4">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <a href="{{ route('admin#userList')}}"><button class="btn btn-sm btn-outline-dark">User List</button></a>
                  <a href="{{ route('admin#adminList')}}"><button class="btn btn-sm btn-outline-dark">Admin List</button></a>
                </h3>
                <div class="card-tools">
                    <form action="{{ route('admin#adminSearch') }}" method="get">
                        @csrf
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="searchData" class="form-control float-right" placeholder="Search">

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

                <table class="table table-hover text-nowrap text-center">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>User Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Address</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($admin as $item)
                        <tr>
                            <td>{{ $item ->id  }}</td>
                            <td>{{ $item ->name  }}</td>
                            <td>{{ $item ->email  }}</td>
                            <td>{{ $item ->phone  }}</td>
                            <td>{{ $item ->address  }}</td>
                            <td>
                                <a href="{{ route('admin#adminDelete',$item->id) }}" onclick="return confirm('Are you sure?')"><button class="btn btn-sm bg-danger text-white"  title="delete"><i class="fas fa-trash-alt"></i></button></a>
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $admin->links() }}
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
