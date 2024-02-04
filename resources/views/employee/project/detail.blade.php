@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer mt-4">
    <div class="col-md-10 offset-md-1">
        <div class="mb-3 card">
            <div class="card-header-tab card-header">
                <div class="card-header-title font-size-lg text-capitalize font-weight-normal text-info"><b style="font-size: 23px;">Project Detail</b></div>
                <div class="btn-actions-pane-right actions-icon-btn">
                    @role('admin|super admin')
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('project.edit',$data['project']->id) }}" class="col-md-5">
                                <i class="fa-solid fa-pen-to-square text-primary"></i>
                            </a>
                            <form action="{{ route('project.destroy',$data['project']->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border: none;cursor:pointer;background:#fff;">
                                    <i class="fa-solid fa-trash text-danger"></i>
                                </button>
                            </form>
                        </div>
                    @endrole
                </div>
            </div>

            <div class="widget-chart widget-chart2 text-left p-0">
                <div class="widget-chat-wrapper-outer">
                    <div class="widget-chart-content widget-chart-content-lg p-5">
                        <div class="row mb-4">
                            <div class="col-md-1">
                                <img src="{{ asset('/storage/uploads/' . $data['project']->projectManager->img) }}" style="width:56px; height:56px;border-radius:28px;">
                            </div>
                            <div class="col-md-4">
                                <b>{{ $data['project']->projectManager->name }}</b><br>
                                <h5>Project Manager</h5>
                            </div>
                        </div>
                        <p><b>project name: {{$data['project']->name}}</b></p>
                        <p><b>start date: {{$data['project']->start_date}}</b></p>
                        <p><b>end date: {{$data['project']->end_date}}</b></p>
                        <p><b>Duration: {{$data['project']->projectPeriod}}</b></p>
                        <p><b>DeadLine: {{$data['projectProgress']['deadlineWarning']['difference_in_days']}} days</b></p>
                        <div>
                            <p><b>Total tasks : {{ $data['projectProgress']['total'] }}</b></p>
                            <p><b>Remaining tasks : {{ $data['projectProgress']['remain'] }}</b></p>
                        </div>
                        <b>Project Completion Status</b>
                        <div class="progress mt-2">
                            <div class="progress-bar bg-info" role="progressbar" aria-valuenow="{{$data['projectProgress']['progress'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{$data['projectProgress']['progress'] }}%;color:black;">
                                {{number_format($data['projectProgress']['progress'] ,1)}}%
                            </div>
                        </div>
                        {{number_format($data['projectProgress']['progress'] ,1)}}% 
                    </div>
                </div>
            </div>
            <hr>
            <div class="pt-2 pb-0 card-body mb-5">
                <h6 class="text-muted text-uppercase font-size-md opacity-9 mb-2 font-weight-normal">Task Completion Status</h6>
                <div class="scroll-area-md shadow-overflow">
                    <div class="scrollbar-container">
                        <ul class="rm-list-borders rm-list-borders-scroll list-group list-group-flush">
                            @foreach ($data['taskProgress'] as $userId => $userProgress)
                            <li class="list-group-item">
                                <div class="widget-content p-3">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left ">
                                            <div class="widget-subheading mt-1 opacity-10">
                                                <img src="{{ asset('/storage/uploads/' . $userProgress['user']->img) }}" style="width:50px; height:50px;border-radius:25px;margin-right:10px;">
                                                <b>{{ $userProgress['user']->name }}</b>
                                            </div>
                                            <div class="widget-heading"> </div>
                                        </div>
                                        <div class="widget-content-right">
                                            <p><b>Total tasks : </b> {{ $userProgress['totalTask'] }} </p>
                                            <p><b> Remaining tasks : </b> {{ $userProgress['remainingTask'] }} </p>
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" aria-valuenow=" {{ $userProgress['progressPercentage'] }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $userProgress['progressPercentage'] }}%;color:black;">
                                            {{ number_format($userProgress['progressPercentage'], 1) }}%
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection