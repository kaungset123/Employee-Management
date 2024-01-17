@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card mb-3 " style="height: 100vh;">
        <div class="col-md-10 mt-3 offset-md-1 p-3">
            @include('layout.flashmessage')
            <h4 class="mb-3 mt-3" style="font-weight: bold;">{{ $data['header'] }}</h4>
            <h5>{{ $data['task']->project->name }}</h5>
            <form class="mt-5" action="{{ route('task.update',$data['task']->id) }}" method="post">
                @csrf
                @method('PUT')
                <input type="hidden" name="project_id" value="{{ $data['project']->id }}">
                <input type="hidden" name="created_by" value="{{ $data['task']->created_by }}">
                <input type="hidden" name="updated_by" value="{{ auth()->user()->id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <labe for="name">Task Name</labe>
                            <input type="text" class="form-control mt-2" name="name" value="{{ $data['task']->name }}">
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group mt-4">
                            <label for="description">Description</label>
                            <textarea name="description" rows="4" class="form-control" placeholder="description...">{{ $data['task']->description }}</textarea>
                            @error('description')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <label for="role">Member</label>
                            <select class="form-control" name="user_id">
                                @foreach($data['project']->members as $member)
                                    <option value="{{$member->id}}" {{ old('user_id', $member->id) == $data['task']->user_id ? 'selected' : '' }}>{{$member->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <labe for="start_date">Start Date</labe>
                            <input type="date" class="form-control mt-2" name="start_date" value="{{ $data['task']->start_date }}">
                            @error('start_date')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" class="form-control mt-1" value="{{ $data['task']->end_date }}">
                            @error('end_date')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3  offset-md-2">
                    <button type="reset" class="btn btn-sm bg-danger me-5 text-white " style="box-shadow: 1px 2px 9px black;">
                        Cancle
                    </button>
                    <button type="submit" class="btn btn-sm bg-primary text-white " style="box-shadow: 1px 2px 9px black;margin-left:1rem;">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection