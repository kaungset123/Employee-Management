@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer ">
    <div class="p-4">
        <h3 style="font-weight: bold;" class="text-info">{{ ucfirst($data['department']->name)}} Department</h3>
        @foreach($data['members'] as $member)
            @if($member['user']->hasRole('manager'))
                <a href="{{ route('profile.index',$member['user']->id) }}" style="cursor: pointer;text-decoration:none;color:#000;">
                    <div class="dept_bg mb-2 col-md-2 offset-md-5 p-3" style="text-align: center;">
                        <img class="manager_img" src="{{ asset('/storage/uploads/' . $member['user']->img) }}">
                        <div class="mt-2">
                            <b> {{ $member['user']->name }}</b><br>
                            <b>
                                @foreach($member['user']->getRoleNames() as $role)
                                    @if($role == 'manager')
                                        {{ $role }}
                                    @endif                                
                                @endforeach
                            </b><br>
                            Rating <b>{{ $member['rating'] }}</b>
                        </div>
                    </div>
                    <div class="expen_bar">
                    </div>
                </a>
            @endif
        @endforeach
        @if(count($data['members']) > 3)
        <div class="row mb-3">
            @foreach($data['members'] as $member)
            @if($member['user']->getRoleNames()->first() != 'manager')
            <div class="col-md-4 text-center mb-5">
                <a href="{{ route('user.profile',$member['user']->id) }}" style="cursor: pointer;text-decoration:none;color:#000;">
                    <div class="dept_bg  p-2">
                        <img class="member_img" src="{{ asset('/storage/uploads/' . $member['user']->img) }}">
                        <div class="mt-2">
                            <b> {{ $member['user']->name }}</b><br>
                            <b> {{ $member['user']->getRoleNames()->first() }}</b><br>
                            Rating <b>{{ $member['rating'] }}</b>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <div class="row mb-3">
            @foreach($data['members'] as $member)
            @unless($member['user']->hasRole('manager'))
            <div class="col-md-6 text-center mb-5">
                <a href="{{ route('profile.index',$member['user']->id) }}" style="cursor: pointer;text-decoration:none;color:#000;">
                    <div class="dept_bg  p-2">
                        <img class="member_img" src="{{ asset('/storage/uploads/' . $member['user']->img) }}">
                        <div class="mt-2">
                            <b> {{ $member['user']->name }}</b><br>
                            <b> {{ $member['user']->getRoleNames()->first() }}</b><br>
                            Rating <b>{{ $member['rating'] }}</b>
                        </div>
                    </div>
                </a>
            </div>
            @endunless
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection