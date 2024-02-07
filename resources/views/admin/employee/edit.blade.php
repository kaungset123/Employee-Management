@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card mb-3 col-md-10 offset-md-1 mt-3 p-5">
        <div class="">
            @include('layout.flash_message')
            <div class="d-flex">
                <h4 class="mb-4 text-info" style="font-weight: bold;">{{ $data['header'] }}</h4>
                <a href="{{ route('user.index') }}" class="me-2 text-info" style="font-size: 28px;margin-top:-4px;position:absolute;right:43px;">
                    <i class="fas fa-arrow-alt-circle-left"></i>
                </a>
            </div>
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
                            <select class="form-control js-example-basic-multiple" name="role[]" multiple="multiple" style="width: 100%;">
                                @foreach($data['roles'] as $role)
                                    @if(auth()->user()->getRoleNames()->first()  == 'super admin')
                                        <option value="{{$role->name}}"                                  
                                        {{ (old("role", $data['user']->roles->pluck('id')->first()) == $role->id) ? 'selected' : '' }}>
                                            {{$role->name}}
                                        </option>
                                    @else
                                        @if($role->name != 'super admin')
                                            <option value="{{$role->name}}" 
                                                {{ in_array($role->id, $data['user']->roles->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{$role->name}}
                                            </option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
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
                                @foreach($data['departments'] as $department)   
                                    @if($data['user']->department_id !== null)                              
                                        <option value="{{$department->id}}" 
                                                {{ old('department_id', $data['user']->department->id) == $department->id ? 'selected' : '' }} 
                                            >
                                            {{$department->name}}
                                        </option>
                                    @else
                                        <option value="{{$department->id}}">
                                            {{$department->name}}
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
                            <label for="hourly_rate">Hourly Rate</label>
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
                            <label for="confirm_pass">Confirmed Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                            @error('password_confirmation')
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
                    @error('img')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    <img id="preview-image" src="{{ asset('storage/uploads/' . $data['user']->img) }}" style="width: 130px;height:130px;" alt="preview">
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
                    <button type="reset" class="btn btn-sm bg-danger me-4 text-white " style="box-shadow: 1px 2px 9px black;">
                        cancel
                    </button>
                    <button type="submit" class="btn btn-sm bg-primary text-white " style="box-shadow: 1px 2px 9px black;margin-left:1rem;">update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection