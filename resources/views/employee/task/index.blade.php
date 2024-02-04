    @extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card-body" id="all_emp_tb">
        <b style="font-size: 23px;" class="mt-4 text-info">{{ $data['header'] }}</b>
        @include('layout.flashmessage')
        <form class="d-flex col-md-6 offset-md-3 mt-4" action="{{ route('task.index',$data['project_id']) }}" method="GET">
            @csrf
            <a href="{{ route('task.index',$data['project_id'] ,['perPage' => $data['tasks']->perPage()]) }}" style="color: black;">
                <i class="fas fa-redo-alt mt-1" style="font-size: 30px;"></i>
            </a>
            <input type="hidden" name="perPage" value="{{ $data['tasks']->perPage() }}">
            <input class="form-control border-info" type="text" name="search" value="{{ $data['search'] }}" placeholder="Search by name" aria-label="Search">
            <button class="btn btn-outline-info " type="submit">Search</button>
        </form>
        <div class="mt-3" style="position: relative;">
            <div class="d-flex relative align-items-start">
                <a href="{{ route('project.myproject') }}" class="me-2 absolute text-info" style="font-size: 28px;margin-top:-4px;">
                    <i class="fas fa-arrow-alt-circle-left"></i>
                </a>
                @include('layout.pageLimit')
            </div>
            <div class="" style="position: absolute;right:1rem;top:5px;">
                <a href="{{route('task.create',$data['project_id']) }}" class="mt-3 text-info" style="position:absolute;top:-20px;right:117px;">
                    <i class="fa-solid fa-circle-plus" style="font-size: 30px;color:#0d6efd;"></i>
                </a>
                <a href="{{ route('task.deleteList',$data['project_id']) }}" id="project_delete_list">
                    @include('component.deleteButton')
                </a>
            </div>
        </div>
        @if(count($data['tasks']) > 0)
            <table style="width: 100%;" class="table table-hover  table-bordered mt-4 ">
                <thead class="text-center">
                    <th>Name</th>
                    <th>Project Name</th>
                    <th>Department</th>
                    <th>Task Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Action</th>
                <tbody>
                    @foreach($data['tasks'] as $task)
                    <tr class="text-center">
                        <td>{{ $task->user->name}}</td>
                        <td>{{ $task->project->name}}</td>
                        <td>{{ $task->user->department->name}}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->start_date->format('F j,Y h:i A') }}</td>
                        <td>{{ $task->end_date->format('F j,Y h:i A') }}</td>
                        <td>
                            {{ $task->deadlineWarning['difference_in_days']}}
                        </td>
                        <td>
                            <div class="mt-3">
                                @if($task->status == 0)
                                <p class="text-danger">Not Started</p>
                                @elseif($task->status == 1)
                                <p class="text-primary">In Progress</p>
                                @elseif($task->status == 2)
                                <p class="text-success">Completed</p>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-black" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                </a>
                                <ul id="action_drop" class="dropdown-menu " style="width:10px;box-shadow:3px 3px 9px;">
                                    <li class="">
                                        <a href="{{ route('task.edit',$task->id) }}" class="dropdown-item text-black">
                                            <button class="btn btn-sm text-primary" style="border:none;background:none;">
                                                Edit
                                            </button>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-black" href="">
                                            <form action="{{ route('task.destroy',$task->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm text-danger" style="border:none;background:none;" onclick="return confirm('Are you sure you want to delete this item?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
                </thead>
            </table>
        @else
            <h4 class="text-danger text-center mt-5">There is not task yet!</h4>
        @endif
        <div id="pagination">
            {{ $data['tasks']->links() }}
        </div>
    </div>
</div>
@endsection