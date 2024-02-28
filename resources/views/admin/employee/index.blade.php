@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
        <div class="card-body" id="all_emp_tb">
            <div class="">
                @include('layout.flash_message')
            </div>
            <h4 style="font-weight: bold;" class="mb-3 text-info">{{$data['header']}}</h4>    
            <form class="d-flex col-md-8 offset-md-2"  action="{{ route('user.index') }}" method="GET" >
                <a href="{{ route('user.index',['perPage' => $data['users']->perPage()]) }}" style="color: black;">
                    <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                </a>
                <input type="hidden" name="perPage" value="{{ $data['users']->perPage() }}">
                @include('layout.searchbar')
            </form>
            <div class="d-flex" style="position: relative;">
                @include('layout.pageLimit')                           
                <a href="{{ route('user.create') }}" class="mt-4" style="text-decoration:none;position:absolute;right:0px;bottom:16px;font-size:20px;">
                    <i class="fa-solid fa-circle-plus text-info" style="font-size: 30px;color:#0d6efd;"></i>
                </a>
            </div>
            @if(count($data['users']) > 0)
                <table style="width: 100%;"  class="table table-hover  table-bordered mt-4 ">
                    <thead class="text-center ">
                        <th>Image</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>email</th>
                        <th>created by</th>
                        <th>updated by</th>
                        <th>created at</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($data['users'] as $user)
                            @if($user->deleted_at != null)
                                <tr style="background: pink;height:60px;">
                                    <td>
                                        @if($user->img !== '' && !empty($user->img))
                                            <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $user->img)}}">     
                                        @else
                                            <img class="manager_img" src="{{ asset('/images/user.jpg') }}">
                                        @endif
                                    </td>
                                    <td>{{$user->name}}</td>
                                    <td>
                                        @if($user->department != null)
                                            {{$user->department->name}}
                                        @endif
                                    </td>   
                                    <td>
                                        @foreach($user->getRoleNames() as $role)
                                            {{ $role }}
                                            @if(!$loop->last) 
                                            ,
                                            @endif
                                        @endforeach
                                    </td>   

                                    <td>{{$user->email}}</td>

                                    @if(!empty($user->createdByUser))                                    
                                        <td>{{$user->createdByUser->name}}</td>
                                    @else
                                        <td>Not yet</td>
                                    @endif

                                    @if(!empty($user->updatedByUser))                                    
                                        <td>{{$user->updatedByUser->name}}</td>  
                                    @else
                                        <td> Not yet </td>                         
                                    @endif

                                    <td>{{$user->created_at->format('F j, Y ')}}</td>
                                    <td style="border:none;">
                                        <div class="d-flex">
                                            <a href="{{ route('user.restore',$user->id) }}" class="col-md-7 " style="text-decoration:none;">
                                                Restore
                                            <a>
                                            <form method="post" action="{{ route('user.forceDelete',$user->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="border:none;cursor:pointer;background:none;" class="text-danger" onclick="return confirm('Are you sure you want to permanently delete this item?')">
                                                    Delete
                                                </button>
                                            </form>  
                                        </div>                                                               
                                    </td>
                                </tr>                                  
                            @else
                                @if(auth()->user()->getRoleNames()->first() != 'super admin')
                                    @if($user->getRoleNames()->first() != 'super admin')
                                        <tr style="height: 60px;">
                                            <td>
                                                <a href="{{ route('profile.index',$user->id) }}">
                                                    @if($user->img !== '' && !empty($user->img))
                                                        <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $user->img)}}">
                                                    @else
                                                        <img class="manager_img" src="{{ asset('/images/user.jpg') }}">  
                                                    @endif
                                                </a>
                                            </td>
                                            <td>{{$user->name}}</td>
                                            <td>
                                                @if($user->department != null)
                                                    {{$user->department->name}}
                                                @else
                                                    N/A
                                                @endif
                                            </td> 
                                            <td>
                                                @foreach($user->getRoleNames() as $role)
                                                    {{ $role }}
                                                    @if(!$loop->last) 
                                                    ,
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{$user->email}}</td>
                                            @if(!empty($user->createdByUser))                                    
                                                <td>{{$user->createdByUser->name}}</td>
                                            @else
                                                <td>Not yet</td>
                                            @endif
                                            @if(!empty($user->updatedByUser))                                    
                                                <td>{{$user->updatedByUser->name}}</td>  
                                            @else
                                            <td> Not yet </td>                         
                                            @endif

                                            <td>{{$user->created_at->format('F j, Y ')}}</td>
                                            <td class="" style="border:none;">
                                                <div class="d-flex mt-1" >
                                                    <a href="{{ route('user.edit',$user->id) }}" class="col-md-5" style="text-decoration:none;">
                                                        Edit
                                                    <a>
                                                    <form method="post" action="{{ route('user.destroy',$user->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="border:none;cursor:pointer;background:none;" class=" text-danger"  onclick="return confirm('Are you sure you want to delete this item?')">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @else
                                    <tr style="height: 60px;">
                                        <td>
                                            <a href="{{ route('profile.index',$user->id) }}">
                                                @if($user->img !== '' && !empty($user->img))
                                                    <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $user->img)}}">
                                                @else
                                                    <img class="manager_img" src="{{ asset('/images/user.jpg') }}">   
                                                @endif
                                            </a>
                                        </td>
                                        <td>{{$user->name}}</td>
                                        <td>
                                            @if($user->department != null)
                                                {{$user->department->name}}
                                            @else
                                                N/A
                                            @endif
                                        </td> 
                                        <td>
                                            @foreach($user->getRoleNames() as $role)
                                                {{ $role }}
                                                @if(!$loop->last) 
                                                ,
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$user->email}}</td>
                                        @if(!empty($user->createdByUser))                                    
                                            <td>{{$user->createdByUser->name}}</td>
                                        @else
                                            <td>Not yet</td>
                                        @endif
                                        @if(!empty($user->updatedByUser))                                    
                                            <td>{{$user->updatedByUser->name}}</td>  
                                        @else
                                        <td> Not yet </td>                         
                                        @endif

                                        <td>{{$user->created_at->format('F j, Y ')}}</td>
                                        <td class="" style="border:none;">
                                            <div class="d-flex mt-1" >
                                                <a href="{{ route('user.edit',$user->id) }}" class="col-md-5" style="text-decoration:none;">
                                                    Edit
                                                <a>
                                                <form method="post" action="{{ route('user.destroy',$user->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="border:none;cursor:pointer;background:none;" class=" text-danger"  onclick="return confirm('Are you sure you want to delete this item?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    </tbody>
                </table> 
            @else
                <h3 class="text-danger text-center mt-5">no result!</h3>
            @endif   
            <div id="pagination">
                {{ $data['users']->links() }}
            </div>          
        </div>
    </div>
@endsection