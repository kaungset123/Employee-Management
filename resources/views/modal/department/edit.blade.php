<div class="modal fade" id="updateDepartmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  method="post" id="dept-edit-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="departmentId" >
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Edit Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Department Name</label>
                        <input type="name" name="name" id="departmentName" class="form-control" >
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