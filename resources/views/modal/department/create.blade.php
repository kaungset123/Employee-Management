<div class="modal fade" id="dept-create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('department.store') }}" method="post" id="dept-create-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Create Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Department Name</label>
                        <input type="name" id="name" name="name" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                    <button type="submit" class="btn btn-primary">Create </button>
                </div>
            </form>
        </div>
    </div>
</div>