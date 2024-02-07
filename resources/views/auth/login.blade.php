@extends("layout.simpleMaster")
@section('title','Login')

@section('content')
<div class="app-container app-theme-white body-tabs-shadow">
    <div class="app-container">
        <div class="h-100 bg-plum-plate bg-animation">
            <div class="d-flex h-100 justify-content-center align-items-center">
                <div class="mx-auto app-login-box col-md-8">
                    <div class="app-logo-inverse mx-auto mb-3"></div>
                    <div class="modal-dialog w-100 mx-auto">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="h5 modal-title text-center">
                                    <h4 class="mt-2">
                                    @if(session('status'))
                                        <p class="alert alert-success " x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show">
                                            {{session('status')}}
                                        </p>
                                    @endif
                                        <div>Welcome back,</div>
                                        <span>Please sign in to your account below.</span>
                                    </h4>
                                </div>
                                <form class="" method="post" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="email...">
                                                @error('email')
                                                <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="position-relative form-group">
                                                <input type="password" class="form-control" name="password" placeholder="password...">
                                                @error('password')
                                                <p class="text-danger">{{$message}}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-relative form-check"><input name="check" id="exampleCheck" type="checkbox" class="form-check-input"><label for="exampleCheck" class="form-check-label">Keep me logged in</label></div>
                                    <div class="modal-footer clearfix">
                                        <div class="float-left"><a href="javascript:void(0);" class="btn-lg btn btn-link">Recover Password</a></div>
                                        <div class="float-right">
                                            <button class="btn btn-primary btn-lg" type="submit">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="text-center text-white opacity-8 mt-3">Copyright © ArchitectUI 2019</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection