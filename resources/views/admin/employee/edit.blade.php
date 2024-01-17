@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card mb-3 col-md-10 offset-md-1 mt-3">
        <div class="col-md-10 mt-3 mb-3 offset-md-1 p-3">
            @include('layout.flashmessage')
            <h4 class="mb-4" style="font-weight: bold;">{{ $data['header'] }}</h4>
            <form action="{{route('user.update',$data['user']->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <labe for="name">Name</labe>
                            <input type="text" class="form-control mt-2" name="name" value="{{$data['user']->name }}">
                            @error('name')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role</label>
                            @foreach($data['roleName'] as $roleName)                           
                                <select class="form-control" name="role">
                                    @foreach($data['roles'] as $role)
                                        @if(auth()->user()->getRoleNames()->first()  == 'super admin')
                                            <option value="{{$role}}" 
                                                {{ old('role', $roleName) == $role ? 'selected' : '' }}>
                                                {{$role}}
                                            </option>
                                        @else
                                            @if($role != 'super admin')
                                                <option value="{{$role}}" 
                                                    {{ old('role', $roleName) == $role ? 'selected' : '' }}>
                                                    {{$role}}
                                                </option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="date">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" value="{{$data['user']->date_of_birth }}">
                            @error('date_of_birth')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label class="department">Department</label>
                            <select class="form-control" name="department_id"> 
                                        <option value="" selected>Default</option>                               
                                @foreach($data['dpmts'] as $dpmt)   
                                    @if($data['user']->department_id !== null)                              
                                        <option value="{{$dpmt->id}}" 
                                                {{ old('department_id', $data['user']->department->id) == $dpmt->id ? 'selected' : '' }} 
                                            >
                                            {{$dpmt->name}}
                                        </option>
                                    @else
                                        <option value="{{$dpmt->id}}">
                                            {{$dpmt->name}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" name="phone" value="{{$data['user']->phone }}">
                            @error('phone')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="salary">Basic Salary</label>
                            <input type="text" class="form-control" name="basic_salary" value="{{$data['user']->basic_salary }}">
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
                            <input type="email" class="form-control" name="email" value="{{$data['user']->email }}">
                            @error('email')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hourly_rate">Horuly Rate</label>
                            <input type="text" class="form-control" name="hourly_rate" value="{{$data['user']->hourly_rate }}">
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
                            <input type="password" class="form-control" name="password">
                            @error('password')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ot">OT pay</label>
                            <input type="text" class="form-control" name="ot_rate" value="{{$data['user']->ot_rate }}">
                            @error('ot_rate')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="conrirmpass">Confirmed Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
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
                                <input type="radio" name="gender" value="male" 
                                {{ $data['user']->gender == 'male' ? 'checked' : '' }} >
                                 Male
                            </div>
                            <div>
                                <input type="radio" name="gender" value="female" 
                                {{ $data['user']->gender == 'female' ? 'checked' : '' }} > 
                                Female
                            </div>
                            @error('gender')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-0 mt-4">
                    <div class="form-group ">
                        <input type="file" class="form-control" name="img" style="border: none;" accept="image/*" onchange="displayImage(this)">
                    </div>
                    <img id="preview-image" src="{{ asset('storage/uploads/' . $data['user']->img) }}" style="width: 130px;height:130px;">
                </div>
                <div class="mt-4">
                    <div class="form-group">
                        <label for="">Address</label>
                        <textarea class="form-control" name="address" rows="5" placeholder="Address">{{$data['user']->address}}</textarea>
                        @error('address')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3 ">
                    <button type="reset" class="btn btn-sm bg-danger me-5 text-white " style="box-shadow: 1px 2px 9px black;">
                        cancel
                    </button>
                    <button type="submit" class="btn btn-sm bg-primary text-white " style="box-shadow: 1px 2px 9px black;margin-left:1rem;">update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection