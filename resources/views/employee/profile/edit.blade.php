@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
        <div class="card col-md-10 mt-4 mb-4 p-5 offset-md-1 p-3">
            @include('layout.flashmessage')
            <h4 class="mb-4 text-info" style="font-weight: bold;">{{ $data['header'] }}</h4>
            <form action="{{route('profile.update',$data['user']->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
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
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label for="date">Date of Birth</label>
                            <input type="date" class="form-control" name="date_of_birth" value="{{$data['user']->date_of_birth }}">
                            @error('date_of_birth')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
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
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="{{$data['user']->email }}">
                            @error('email')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
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
                            <label for="conrirmpass">Confirmed Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                            @error('password_contirmation')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class=" p-0">
                    <div class="form-group mt-4">
                        <input type="file" class="form-control" name="img" style="border: none;" value="{{ old('img') }}"  accept="image/*" onchange="displayImage(this)">
                        @error('img')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <img id="preview-image" src="{{ asset('storage/uploads/' . $data['user']->img) }}" style="width: 130px;height:130px;" alt="Preview">
                </div>
                <div class="mt-3">
                    <div class="form-group">
                        <label>Address</label>  
                        <textarea class="form-control" name="address" rows="5" placeholder="Address">{{ $data['user']->address }}</textarea>
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
@endsection