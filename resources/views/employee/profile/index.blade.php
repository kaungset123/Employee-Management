@extends("layout.master")
@section("title",'')

@section('content')
    <div class="app-main__outer">
        <!-- <div class="card "> -->
            <div class="col-md-12 mt-2">
                <div class="card-hover-shadow profile-responsive card-border border-success mb-3 card">
                    <div class="dropdown-menu-header">
                        <div class="dropdown-menu-header-inner bg-info">
                            <div class="menu-header-content mt-4">
                                <div class="avatar-icon-wrapper btn-hover-shine mb-2 avatar-icon-xl">
                                    <div class="">
                                        <img src=" {{ asset('/storage/uploads/' . $data['user']['user']->img) }}" style="width:100px;height:100px;border-radius:50px;margin-bottom:5px;border:3px solid white;">
                                    </div>
                                </div>
                                <div>
                                    <h5 class="menu-header-title">{{ $data['user']['user']->name }}</h5>
                                    @if($data['user']['user']->department != null)
                                        <h6 class="menu-header-subtitle">{{ ucfirst($data['user']['user']->department->name) }} Department</h6>
                                    @endif
                                </div>
                                <div class="menu-header-btn-pane pt-2">
                                    <div role="group" class="btn-group text-center">
                                        <div class="nav">
                                            <a href="#tab-2-eg1" data-toggle="tab"class="active btn btn-dark">Profile</a>
                                            <!-- <a href="#tab-2-eg2" data-toggle="tab"class="btn btn-dark mr-1 ml-1">Experience</a> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-0 card-body">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="tab-2-eg1">
                                <ul class="list-group list-group-flush">  
                                    <div class="mt-4 mb-4 " style="text-align:left;width:50%;margin:0 auto;" id="profile_data">
                                        <p><b>Role&nbsp;&nbsp; </b>
                                            @foreach($data['user']['user']->getRoleNames() as $role)
                                                {{ $role }}
                                                @if(!$loop->last) 
                                                ,
                                                @endif
                                            @endforeach
                                        </p>
                                        @if($data['user']['user']->getRoleNames()->first() != 'super admin')
                                            <p><b>Rating&nbsp;&nbsp; </b>{{ $data['user']['rating']}}</p>
                                        @endif                                       
                                        <p><b>Email&nbsp;&nbsp; </b>{{ $data['user']['user']->email }}</p>
                                        <p><b>Phone&nbsp;&nbsp; </b>{{ $data['user']['user']->phone }}</p>
                                        <p><b>Address&nbsp;&nbsp; </b>{{ $data['user']['user']->address }}</p>
                                        <p><b>Basic Salary&nbsp;&nbsp; </b>{{ $data['user']['user']->basic_salary }}</p>
                                        <p><b>OT Rate&nbsp;&nbsp; </b>{{ $data['user']['user']->ot_rate }}</p>
                                        <p><b>Hourly Rate&nbsp;&nbsp;   </b>{{ $data['user']['user']->hourly_rate }}</p>
                                        <p><b>Participated Projects&nbsp;&nbsp; </b> 
                                            @if(count($data['user']['user']->projects) > 0)
                                                @foreach($data['user']['user']->projects as $project) 
                                                    {{ $project->name }} 
                                                    @if(!$loop->last) 
                                                    ,
                                                    @endif
                                                @endforeach
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>                                                                   
                                </ul>
                            </div>
                            <!-- <div class="tab-pane" id="tab-2-eg2">
                                <ul class="list-group list-group-flush">
                                    <div class="mt-4 mt-4" style="text-align:left;width:37%;margin:0 auto;">
                                        <p><b>Participated Projects</b> 
                                            @foreach($data['user']['user']->projects as $project) 
                                                <b>
                                                    {{ $project->name }} 
                                                </b>
                                            @endforeach
                                        </p>
                                    </div>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
    </div>
@endsection