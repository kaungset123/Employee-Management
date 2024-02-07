@extends("layout.master")
@section("title","Admin Home")

@section('content')
    <div class="app-main__outer mt-5 col-md-10 offset-md-1">
            @include('layout.flash_message')
            <form action="{{ route('permission.store') }}" method="post" class="col-md-6 " >
                @csrf
                <div class="form-group">
                    <label for="name">Add Permission</label>
                    <input type="text" name="name" class="form-control">
                    @error('name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    <button type="submit" class="btn btn-sm bg-primary text-white mt-3  " style="box-shadow: 1px 2px 9px black;margin-left:1rem;">Add</button>
                </div>
            </form>

            <div>
                <table class="table">
                        <thead class="text-center">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Action</th>
                        </thead>
                        <tbody>     
                            @foreach($permissions as $permission)             
                                <tr class="text-center">
                                    <td>{{$permission->id}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td class="d-flex justify-content-center  col-md-8 offset-md-2">
                                        <div class="col-md-5">
                                            <a href="" style="text-decoration: none;">
                                            <a class="btn btn-sm bg-info text-white">
                                                Edit   
                                            </a>
                                        </div>
                                        <div class="">
                                            <form method="post" action=" {{ route('permission.destroy',$permission->id) }} ">
                                                @csrf
                                                @method('DELETE')
                                                <a href="" style="text-decoration: none;">
                                                <button type="submit" class="btn btn-sm bg-danger text-white" >
                                                    Delete 
                                                </button>                                                
                                                </a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
    </div>
@endsection