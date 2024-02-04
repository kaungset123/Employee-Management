<div class="modal fade" id="updateSalarycriteriaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  method="post" id="criteria-edit-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="criteriaId" >
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Edit Criteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Bouns amount</label>
                        <input type="text" name="bonus_amount" id="criteriaAmount" class="form-control" >
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                    <button type="submit" class="btn btn-primary">Update </button>
                </div>
            </form>
        </div>
    </div>
</div>