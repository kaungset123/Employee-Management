@extends("layout.master")
@section("title",$data['title'])

@section('content')
        <div class="app-main__outer">
            <div class="card mb-3 " style="height: 100vh;">
                <div class="card-body" id="all_emp_tb">
                    <b style="font-size: 23px;" class="mt-4 text-info">{{ $data['header'] }}</b>
                    @if(count($data['tasks']) > 0 )
                        <table style="width: 100%;"  class="table table-hover table-striped table-bordered mt-5 ">
                            <thead class="text-center">
                                <th>Project Name</th>
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
                                            <td>{{ $task->project->name }}</td>
                                            <td>{{ $task->name }}</td>
                                            <td>{{ $task->description }}</td>
                                            <td>{{ $task->start_date->format('F j, Y H:m s') }}</td>
                                            <td>{{ $task->end_date->format('F j, Y H:m s') }}</td>
                                            <td>                                          
                                                {{ $task->deadlineWarning['difference_in_days'] }}                                         
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
                                                @if($task->status == 0)
                                                    <form action="{{ route('task.start',$task->id) }}" method="post">
                                                        @csrf
                                                        @method('PUT')                                               
                                                        <button type="submit" class="btn btn-sm bg-primary text-white">
                                                            Start Now
                                                        </button>
                                                    </form>
                                                @elseif($task->status == 1)
                                                    <form action="{{ route('task.complete',$task->id) }}" method="post">
                                                        @csrf
                                                        @method('PUT')                                               
                                                        <button type="submit" class="btn btn-sm bg-success">
                                                            Complete
                                                        </button>
                                                    </form>
                                                @elseif($task->status == 2)
                                                    <b class="text-success">Task Completed!</b>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </thead>
                        </table>
                    @else
                        <h4 class="text-danger text-center mt-5">There is not task yet!</h4>
                    @endif
                </div>
            </div>
        </div>
@endsection