@extends("layout.masters")
@section("title",$data['title'])

@section('content')
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    @include('layout.nav')
    <div class="app-main bg-white">
        @include('layout.sidebar')
        <div class="app-main__outer">
            <div class="card-body " id="all_emp_tb" style="position: relative;">
                <div class="mb-3">
                    @include('layout.flash_message')
                </div>
                <div class="col-md-8 offset-md-2">
                    <div id="response"></div>
                </div>
                <h4 style="font-weight: bold;" class="mb-5 text-info" >{{$data['header']}}</h4>
                <a href="javascript:void(0)" id="create-dept-btn" class="text-end text-info" style="position: absolute;right:1.5rem;top:76px;">
                    <i class="fa fa-plus-circle" style="font-size:30px;" aria-hidden="true"></i>
                </a>
                <table style="width: 100%;" class="table table-hover table-bordered mt-5 ">
                    <thead class="text-center">
                        <th>Name</th>
                        <th>Manager</th>
                        <th>Members</th>
                        <th>Action</th>
                    </thead>
                    <tbody >
                        @foreach($data['departments'] as $department)
                            @if($department->deleted_at != null)
                                <tr class="text-center" style="line-height: 40px;background:pink;opacity:0.6;">
                                    <a href="{{ route('department.show',$department->id) }}" style="text-decoration:none;cursor:pointer;">
                                        <td>{{$department->name}}</td>
                                        <td>
                                            @if($department->managerName != null)
                                                {{ $department->managerName->value('name') }}
                                            @else
                                                not yet
                                            @endif
                                        </td>
                                        <td>{{ @count($department->users) }} </td>
                                        <td class=" " style="border:none;margin-top:13px;">
                                            <div class="d-flex justify-content-center">                                                        
                                                <a href="{{ route('department.restore',$department->id) }}" style="text-decoration:none;" class="col-md-2 offset-md-2">
                                                    Restore
                                                </a>
                                                <form method="post" action="{{ route('department.force_delete',$department->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" style="border:none;cursor:pointer;background:none;line-height:10px;" 
                                                    class="text-danger" onclick="return confirm('Are you sure to permanently delete this department?')">
                                                        Permanent Delete
                                                    </button>
                                                </form>
                                            </div>  
                                        </td>
                                    </a>
                                </tr>
                            @else
                                <tr class="text-center" style="line-height: 40px;">
                                    <td>
                                        <a href="{{ route('department.show',$department->id) }}" style="text-decoration:none;cursor:pointer;color:#000;">
                                            {{$department->name}}
                                        </a>
                                    </td>
                                    <td>
                                        @if($department->managerName != null)
                                            {{ $department->managerName->value('name') }}
                                        @else
                                            not yet
                                        @endif
                                    </td>
                                    <td>{{ @count($department->users) }} </td>
                                    <td class=" " style="border:none;margin-top:13px;">
                                        <div class="d-flex justify-content-center">
                                            <a href="javascript:void(0)" class="edit-btn col-md-4" data-department-id="{{ $department->id }}" data-department-name="{{ $department->name }}" class="col-md-7 " style="text-decoration:none;">
                                                Edit
                                            </a>                                                          
                                            <form method="post" action="{{ route('department.destroy',$department->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="border:none;cursor:pointer;background:none;line-height:10px;" 
                                                class="text-danger" onclick="return confirm('Before deleting department\n - make sure to empty the department \n - transport all the employee to other valid department')">
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
            </div>
        </div>
    </div>
    @include('modal.department.create')
    @include('modal.department.edit')
</div>
@endsection