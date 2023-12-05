@extends("layout.master")
@section("title","Admin Home")

@section('content')
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    @include('layout.necess')
    <div class="app-main p-0">
        @include('layout.sidebar')
        <div class="app-main__outer">
            <div class="card mb-3">
                <div class="col-md-10 mt-3 offset-md-1 p-3" >
                    <h4 class="mb-3" style="font-weight: bold;">EMPLOYEE CREATE</h4>
                    <form action="" method="post" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="firstname" placeholder="firstname">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="lastname" placeholder="lastname">
                                    </div>
                                </div>    
                            </div>     
                            <div class="row mt-4">
                                <div class="col-md-6 ">                  
                                    <div class="form-group">
                                        <select class="form-control">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="phone" placeholder="phone number">
                                    </div>
                                </div>
                            </div>  
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="confirmpass" placeholder="confirm password">
                                    </div>
                                </div>    
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="firstname" placeholder="firstname">
                                    </div>
                                </div>
                                <div class="col-md-6 ">                  
                                    <div class="form-group">                                       
                                            <select class="form-control" >
                                                @foreach($dpmts as $dpmt)
                                                    <option value="{{$dpmt->id}}">{{$dpmt->name}}</option>
                                                @endforeach
                                            </select> 
                                    </div>
                                </div> 
                            </div>
                            <div class="mt-4">
                                <div class="form-group">
                                    <textarea class="form-control" name="address" rows="5" placeholder="Address"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="file"  style="border: none;" >
                            </div>           
                            <div class="d-flex justify-content-end mt-3 ">
                                <button type="reset" class="btn btn-sm bg-danger me-5 text-white " style="box-shadow: 1px 2px 9px black;">
                                    cancel
                                </button>
                                <button type="submit" class="btn btn-sm bg-primary text-white " style="box-shadow: 1px 2px 9px black;">submit</button>
                            </div>                       
                    </form>
                </div>
            </div>
        </div>

</div>

@include('layout.app_drawer_wrapper')

@endsection