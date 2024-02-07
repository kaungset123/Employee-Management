@extends("layout.master")
@section("title",@$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card mb-3 col-md-10 offset-md-1 mt-3 p-5">
        <div class="">
            @include('layout.flash_message')
            <div class="d-flex relative">
                <h4 class="mb-3 text-info" style="font-weight: bold;">{{$data['header']}}</h4>
                <a href="{{ route('project.index') }}" class="me-2 text-info" style="font-size: 28px;margin-top:-4px;position:absolute;right:43px;">
                    <i class="fas fa-arrow-alt-circle-left"></i>
                </a>
            </div>
            <form action="{{ route('project.store') }}" method="post">
                @csrf
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Project Name</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                            @error('name')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">{{ __('Project Status') }}</label>
                            <select id="status" class="form-control @error('status') is-invalid @enderror" name="status">
                                @foreach(\App\Constants\ProjectStatus::getConstants() as $value => $label)
                                    <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('status')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="form-group col-md-6">
                        <label for="startDate">Start Date</label>
                        <input type="date" class="form-control" name="start_date" placeholder="Start Date" value="{{ old('start_date') }}" >
                        @error('start_date')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="startDate">End Date</label>
                        <input type="date" class="form-control" name="end_date" placeholder="End Date" value="{{ old('end_date') }}">
                        @error('end_date')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="form-group col-md-6">
                        <div>
                            <p style="font-size: 16px;">Team Leader</p>
                        </div>
                        <select class="form-control js-example-basic-single" name="project_manager_id" style="width:100%;height:40px;">
                            @foreach($data['users'] as $user)
                                @if($user->getRoleNames()->first() != 'admin')
                                    <option value="{{$user->id}}" {{ old('project_manager_id', $user->id) == $user->id ? 'selected' : '' }}>{{$user->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <div>
                            <p style="font-size: 16px;">Team Members</p>
                        </div>
                        <select class="form-control js-example-basic-multiple" name="members[]" multiple="multiple" style="width: 100%;">
                            @foreach($data['users'] as $user)
                                @if($user->getRoleNames()->first() != 'admin')
                                    <option value="{{$user->id}}" {{ in_array($user->id, old('members',[])) ? 'selected' : '' }}>
                                        {{$user->name}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('members')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea  class="form-control" rows="5" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3 ">
                    <button type="reset" class="btn btn-sm bg-danger me-5 text-white " style="box-shadow: 1px 2px 9px black;">
                        cancel
                    </button>
                    <button type="submit" class="btn btn-sm bg-primary text-white" style="box-shadow: 1px 2px 9px black;margin-left:1rem;">submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
@endsection