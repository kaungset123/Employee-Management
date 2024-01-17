@extends("layout.master")
@section("title",$data['title'])

@section('content')
<div class="app-main__outer">
    <div class="card-body col-md-8 offset-md-2  mt-5 mb-5">
        <div class="rate_img_div">
            <img src="{{ asset('storage/uploads/' . $data['user']['user']->img) }}" class="rate_img">
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

@endsection