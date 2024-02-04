<div class="modal fade" id="leavePdfModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  method="post" id="leave-pdf-form">
                @csrf   
                <input type="hidden" name="id" id="leaveId">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Generate Leave PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="choosedMonth">Month</label>
                        <select class="form-select" aria-label="Default select example" name="month" id="choosedMonth">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option> 
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <label for="year">Year</label>
                        <input type="number" class="form-control" name="year" id="choosedYear" placeholder="choose year"  min="2023" max="2050">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancle</button>
                    <button type="submit" class="btn btn-primary">Generate </button>
                </div>
            </form>
        </div>
    </div>
</div>