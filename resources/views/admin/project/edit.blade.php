@extends("layout.master")
@section("title","Add Project")

@section('content')
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    @include('layout.necess')
    <div class="app-main p-0">
        @include('layout.sidebar')
        <div class="app-main__outer">
            <div class="card mb-3">
                <div class="col-md-10 mt-3 offset-md-1 p-3" >
                    <h4 class="mb-3" style="font-weight: bold;">EDIT PROJECT</h4>
                    <form action="" method="post" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" placeholder="Project Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="description" placeholder="Description" required>
                                    </div>
                                </div>    
                            </div>     
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="startDate" placeholder="Start Date" required>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <input type="date" class="form-control" name="endDate" placeholder="End Date" required>
                                    </div>
                                </div>
                            </div>  
                            <div class="row mt-4">
                                <div class="col-md-6 ">                  
                                    <div class="form-group">
                                        <label for="teamLeader">Team Leader</label>
                                        <select class="form-control" id="teamLeader" name="teamLeader" required>
                                            <option value="#">Crist</option>
                                            <option value="#">Guogeor</option>
                                            <option value="#">Saya</option>
                                            <option value="#">Lincon</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-6 ">                  
                                    <div class="form-group">
                                        <label for="teamMembers">Team Members</label>
                                        <select class="form-control" id="teamMembers" name="teamMembers[]" multiple required>
                                            <option value="#">TeamMember1</option>
                                        </select>
                                    </div>
                                </div>   
                            </div>           
                            <div class="d-flex justify-content-end mt-3 ">
                                <button type="reset" class="btn btn-sm bg-danger me-5 text-white " style="box-shadow: 1px 2px 9px black;">
                                    cancel
                                </button>
                                <button type="submit" class="btn btn-sm bg-primary text-white" style="box-shadow: 1px 2px 9px black;margin-left:1rem;">Edit</button>
                            </div>                       
                    </form>
                </div>
            </div>
        </div>
</div>

@include('layout.app_drawer_wrapper')

@endsection