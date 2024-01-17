@extends("layout.master")
@section("title","Admin Home")


@section('content')
        <div class="app-main__outer mt-5 col-md-10 offset-md-1">
            @include('layout.flashmessage')
            <b class="" style="font-size: 30px;">{{$data['role']->name}} role</b>
            <form action="{{ route('role.setpermission',$data['role']->id) }}" method="post" class="mt-5">
                @csrf
                <div class="form-group  ">
                    <div class="row">
                        @csrf
                        @method('put')
                        @foreach ($data['groupedPermissions'] as $groupName => $groupPermissions)
                        <div class="col-md-4 mb-3"> 
                            <h5 style="font-weight:bolder;" class="mb-4">{{ ucfirst($groupName) }} Permissions</h5>
                            @foreach ($groupPermissions as $permission)  
                                <input type="checkbox" name="permission[]" value="{{ $permission }}" {{ in_array($permission, $data['roles']) ? "checked" : "" }}>
                                {{ $permission }}<br><br>
                            @endforeach     
                        </div>
                        @endforeach
                    </div>
                    <div class=" mt-3 ">
                        <button type="submit" class="btn btn-sm bg-primary text-white" style="box-shadow: 1px 2px 9px black;margin-left:1rem;">Update</button>
                    </div>
                </div>
            </form>
        </div>

@endsection