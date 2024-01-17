@extends("layout.master")
@section("title",$data['title'])

@section('content')
        <div class="app-main__outer">
                <div class="card-body" id="all_emp_tb">
                    <div class="">
                        @include('layout.flashmessage')
                    </div>
                    <h4 style="font-weight: bold;" class="mb-3">{{$data['header']}}</h4>    
                    <form class="d-flex col-md-8 offset-md-2"  action="{{ route('user.index') }}" method="GET" >
                        <a href="{{ route('user.index',['perPage' => $data['users']->perPage()]) }}" style="color: black;">
                            <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
                        </a>
                        <input type="hidden" name="perPage" value="{{ $data['users']->perPage() }}">
                        @include('layout.searchbar')
                    </form>
                    @include('layout.pageLimit')
                    @if(count($data['users']) > 0)
                        <table style="width: 100%;"  class="table table-hover  table-bordered mt-4 ">
                            <thead class="text-center">
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
                                        <tr style="background: pink;">
                                            <td>
                                                @if($user->img !== '' && !empty($user->img))
                                                    <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $user->img)}}">     
                                                @else
                                                    no image
                                                @endif
                                            </td>
                                            <td>{{$user->name}}</td>
                                            <td>
                                                @if($user->department != null)
                                                    {{$user->department->name}}
                                                @endif
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
                                                        <!-- <i class="fa-solid fa-pen-to-square text-primary"></i> -->
                                                        Restore
                                                    <a>
                                                    <form method="post" action="{{ route('user.forceDelete',$user->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="border:none;cursor:pointer;background:none;" class="text-danger">
                                                            <!-- <i class="fa-solid fa-trash text-danger"></i> -->
                                                            Delete
                                                        </button>
                                                    </form>  
                                                </div>                                                               
                                            </td>
                                        </tr>                                  
                                    @else
                                        <tr>
                                            <td>
                                                <a href="{{ route('user.profile',$user->id) }}">
                                                    @if($user->img !== '' && !empty($user->img))
                                                        <img style="width:50px; height:50px;border-radius:25px;" src="{{ asset('storage/uploads/' . $user->img)}}">
                                                    @else
                                                        no image     
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
                                            <td>{{ $user->getRoleNames()->first() }}</td>
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
                                                    <a href="{{ route('user.edit',$user->id) }}" class="col-md-6 offset-md-1" style="text-decoration:none;">
                                                        <!-- <i class="fa-solid fa-pen-to-square text-primary"></i> -->
                                                        Edit
                                                    <a>
                                                    <form method="post" action="{{ route('user.destroy',$user->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="border:none;cursor:pointer;background:none;" class=" text-danger"  onclick="return confirm('Are you sure you want to delete this item?')">
                                                            <!-- <i class="fa-solid fa-trash text-danger"></i> -->
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>

                                            </td>
                                        </tr>
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