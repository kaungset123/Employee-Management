@if(session('status'))
    <p class="alert alert-success text-center" x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show">
        <i class="far fa-check-circle text-success"></i> {{session('status')}}
    </p>
@elseif(session('fail_status'))
    <p class="alert alert-danger text-center " x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show">
        <i class="fas fa-exclamation-triangle text-warning"></i> {{session('fail_status')}}
    </p>
@endif
