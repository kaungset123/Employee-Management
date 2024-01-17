@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card mb-3 col-md-10 offset-md-1 mt-3">
        <div class="col-md-10 mt-3 mb-3 offset-md-1 p-3">
            <div class="col-md-6 offset-md-3">
                @include('layout.flashmessage')
            </div>           
            <h4 class="mb-5 " style="font-weight: bold;">CREATE EMPLOYEE</h4>
            <form action="{{ route('user.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <labe for="name">Name</labe>
                            <input type="text" class="form-control mt-2" name="name" value="{{old('name')}}">
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" name="role">
                                @foreach($data['roles'] as $role)
                                        @if(auth()->user()->getRoleNames()->first()  == 'super admin')
                                            <option value="{{$role->name}}" {{ old('role', $role->name) == $role->name ? 'selected' : '' }}>
                                                {{$role->name}}
                                            </option>
                                        @else
                                            @if($role->name != 'super admin')
                                                <option value="{{$role->name}}" {{ old('role', $role->name) == $role->name ? 'selected' : '' }}>
                                                    {{$role->name}}
                                                </option>
                                            @endif
                                        @endif                                  
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="date">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" value="{{old('date_of_birth')}}">
                            @error('date_of_birth')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class="department">Department</label>
                            <select class="form-control" name="department_id">
                                @foreach($data['dpmts'] as $dpmt)
                                    <option value="{{$dpmt->id}}" {{ old('department_id', $dpmt->id) == $dpmt->id ? 'selected' : '' }}>{{$dpmt->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>  
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                            @error('phone')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salary">Basic Salary</label>
                            <input type="text" class="form-control" name="basic_salary" value="{{old('basic_salary')}}">
                            @error('basic_salary')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="{{old('email')}}">
                            @error('email')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hourly_rate">Horuly Rate</label>
                            <input type="text" class="form-control" name="hourly_rate" value="{{old('hourly_rate')}}">
                            @error('hourly_rate')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                            @error('password')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ot">OT pay</label>
                            <input type="text" class="form-control" name="ot_rate" value="{{old('ot_rate')}}">
                            @error('ot_rate')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>                  
                </div>
                <div class=" row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirmpass">Confirmed Password</label>
                            <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                            @error('password_contirmation')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div> 
                </div>
                <div class=" mt-4">
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="col-md-3">
                                <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : 'checked'}}> Male
                            </div>
                            <div>
                                <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : ''}}> Female
                            </div>                           
                        </div>
                        @error('gender')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 p-0">
                    <div class="form-group mt-4">
                        <input type="file" class="form-control" name="img" style="border: none;" value="{{ old('img') }}"  accept="image/*" onchange="displayImage(this)">
                    </div>
                    <img id="preview-image" src="#" style="width: 130px;height:130px;display:none;" alt="Preview">
                </div>          
                <div class="mt-4">
                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" name="address" rows="5" placeholder="Address">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3 ">
                    <button type="reset" class="btn btn-sm bg-danger me-5 text-white " style="box-shadow: 1px 2px 9px black;">
                        cancel
                    </button>
                    <button type="submit" class="btn btn-sm bg-primary text-white " style="box-shadow: 1px 2px 9px black;margin-left:1rem;">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection