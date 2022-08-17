@extends('admin.layout.app')

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-8 offset-3 mt-5">
                    <div class="col-md-9">
                        <div class="card">
                            @if(Session::has('updateSuccess'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ Session::get('updateSuccess') }}
                                    <button type="button" class="btn btn-close" data-bs-dismiss='alert' onclick="$('.alert').hide()" aria-label="close"></button>
                                </div>
                            @endif
                            @if(Session::has('successChange'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ Session::get('successChange') }}
                                    <button type="button" class="btn btn-close" data-bs-dismiss='alert' onclick="$('.alert').hide()" aria-label="close"></button>
                                </div>
                            @endif
                            <script>
                                var msg = '{{Session::get('oldPasswordNotSame')}}';
                                var exist = '{{Session::has('oldPasswordNotSame')}}';
                                if(exist){
                                  alert(msg);
                                }
                            </script>
                            <script>
                                var msg1 = '{{Session::get('newConfirmNotSame')}}';
                                var exist1 = '{{Session::has('newConfirmNotSame')}}';
                                if(exist1){
                                    alert(msg1);
                                }
                            </script>
                            <div class="card-header p-2">
                                <legend class="text-center">User Profile</legend>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="activity">
                                        <form class="form-horizontal" method="POST" action="{{ route('admin#updateProfile',$user->id) }}">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}" placeholder="Name" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" name="email" value="{{ old('email',$user->email) }}" placeholder="Email" required>
                                                    @if ($errors->has('email'))
                                                        <p class="text-danger">{{ $errors->first('email') }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Phone</label>
                                                <div class="col-sm-10">
                                                    <input type="number" class="form-control" name="phone" value="{{ old('phone',$user->phone) }}" placeholder="Phone" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-2 col-form-label">Address</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" name="address" value="{{ old('address',$user->address) }}" placeholder="Address" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10 ">
                                                    <a href="#" onclick="$('#mo').click()">Change Password</a>
                                                </div>
                                            </div>
                                            <div class="form-group row float-right ">
                                                <div class="offset-sm-2 col-sm-10 ml-5">
                                                    <button type="submit" class="btn bg-dark text-white ">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- Button trigger modal -->
                                        <p type="button" id="mo" class="btn btn-primary" data-bs-toggle="modal" role="dialog" data-bs-target="#exampleModal" hidden>
                                        Launch demo modal
                                    </p>

                                    <!-- Modal -->
                                    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('admin#change',$user->id) }}" method="POST">
                                                    @csrf
                                                    <div class="my-1">
                                                        <label >Old Password</label>
                                                        <div class="d-flex align-items-center border border-3 rounded">
                                                            <input type="password" name="oldPassword" id="inputType1" class="form-control border-0" required>
                                                            <span class="material-symbols-outlined text-secondary" aria-label=".." id="in1" style="cursor: pointer" onclick="myfunction('inputType1','in1')">
                                                                visibility_off
                                                            </span>
                                                        </div>
                                                    {{-- @if ($errors->has('oldPassword'))
                                                        <p class="text-danger">{{ $errors->first('oldPassword') }}</p>
                                                    @endif --}}
                                                    </div>
                                                    <div class="my-1">
                                                        <label >New Password</label>
                                                        <div class="d-flex align-items-center border border-3 rounded">
                                                            <input type="password" name="newPassword" minlength="6" id="inputType2" class="form-control border-0" required>
                                                            <span class="material-symbols-outlined text-secondary" aria-label=".." id="in2" style="cursor: pointer" onclick="myfunction('inputType2','in2')">
                                                                visibility_off
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="my-1">
                                                        <label for="cp">Confirm Password</label>
                                                        <div class="d-flex align-items-center border border-3 rounded">
                                                            <input type="password" name="confirm" minlength="6" id="inputType3" class="form-control border-0" required>
                                                            <span class="material-symbols-outlined text-secondary" aria-label=".." id="in3" style="cursor: pointer" onclick="myfunction('inputType3','in3')">
                                                                visibility_off
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="float-end my-1">
                                                        <input type="submit" value="Change" class="btn bg-dark text-white">
                                                    </div>
                                                </form>
                                            </div>
                                            {{-- <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                            </div> --}}
                                        </div>
                                        </div>
                                    </div>
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
<script>
    password = true;
    function myfunction(id,id2){
        var x = document.getElementById(id);
        if (password) {
            x.type = "text";
            document.getElementById(id2).innerHTML="visibility"
        } else {
            x.type = "password";
            document.getElementById(id2).innerHTML="visibility_off"
        }
        password =! password;

    }
</script>

@endsection
