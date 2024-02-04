@extends("layout.masters")
@section("title",$data['title'])

@section('content')
<div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
    @include('layout.nav')
    <div class="app-main bg-white">
        @include('layout.sidebar')
        <div class="app-main__outer">
            <div class="card-body " id="all_emp_tb" style="position: relative;">
                <div class="mb-3">
                    @include('layout.flashmessage')
                </div>
                <div class="col-md-8 offset-md-2">
                    <div id="response"></div>
                </div>
                <h4 style="font-weight: bold;" class="mb-5 text-info" >{{$data['header']}}</h4>
                <a href="javascript:void(0)" id="create-dept-btn" class="text-end text-info" style="position: absolute;right:1.5rem;top:76px;">
                    <i class="fa fa-plus-circle" style="font-size:30px;" aria-hidden="true"></i>
                </a>
                <table style="width: 100%;" class="table table-hover table-bordered mt-5 ">
                    <thead class="text-center">
                        <th>Rating point</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($data['criterias'] as $criteria)
                            <tr class="text-center" style="line-height: 40px;">
                                <a href="" style="text-decoration:none;cursor:pointer;">
                                    <td>{{ $criteria->rating_point }}</td>
                                    <td>{{ $criteria->bonus_amount }} </td>
                                    <td class=" " style="border:none;margin-top:13px;">
                                        <div class="d-flex justify-content-center">                                                        
                                            <a href="javascript:void(0)" class="criteria-edit-btn col-md-4" data-criteria-id="{{ $criteria->id }}" data-criteria-amount="{{ $criteria->bonus_amount }}"   class="col-md-7 " style="text-decoration:none;">
                                                Edit
                                            </a>                                        
                                        </div>  
                                    </td>
                                </a>
                            </tr>      
                        @endforeach                
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('modal.salarycriteria.edit')
</div>
@endsection