@extends("layout.master")
@section("title",$data['title'])

@section('content')
    <div class="app-main__outer">
        <div class="card col-md-8 mt-4 offset-md-2 p-4">
            <div class="card-body" style="position: relative;">
                <a href="{{ route('employee.dashboard') }}" class="me-2 text-info" style="font-size: 28px;margin-top:-32px;position:absolute;right:0px;">
                    <i class="fas fa-arrow-alt-circle-left"></i>
                </a>   
                <div class="rate_img_div">
                    @if(!empty($data['user']['user']->img))
                        <img src="{{ asset('storage/uploads/' . $data['user']['user']->img) }}" class="rate_img">
                    @else
                        <img class="manager_img" src="{{ asset('/images/user.jpg') }}">
                    @endif
                    <p class="text-center mt-1" style="margin-bottom:3px;">{{$data['user']['user']->name}}</p>
                    <p class="text-center mt-1" style="margin-bottom:3px;">{{$data['user']['user']->department->name}} department</p>
                    <p class="text-center mt-1" style="margin-bottom:3px;">current rating {{$data['user']['rating']}} </p>
                </div>
                <form id="ratingForm" method="post" action="{{ route('rating.store') }}">
                    @csrf
                    <input type="hidden" name="rated_id" id="rated_id" value="{{ $data['user']['user']->id }}">
                    <input type="hidden" name="rater_id" id="rater_id" value="{{ auth()->user()->id }}">
                    <div class="rating form-group">
                        <input type="hidden" name="rating" id="ratingValue" value="0">
                        <span class="star" data-value="1"><i class="fas fa-star"></i></span>
                        <span class="star" data-value="2"><i class="fas fa-star"></i></span>
                        <span class="star" data-value="3"><i class="fas fa-star"></i></span>
                        <span class="star" data-value="4"><i class="fas fa-star"></i></span>
                        <span class="star" data-value="5"><i class="fas fa-star"></i></span>
                    </div>
                    <button type="submit" class="btn btn-sm bg-primary text-white pull-right">
                        Rate
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection