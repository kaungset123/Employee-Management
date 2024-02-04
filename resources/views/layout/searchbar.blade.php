    @csrf
    <input class="form-control border-info" type="text" name="search" value="{{ $data['search'] }}" placeholder="Search by name" aria-label="Search">
    <input class="form-control  border-info" type="text" name="department_name" value="{{ $data['departmentName'] }}" placeholder="Search by department" aria-label="Search">
    <input type="date" class="form-control border-info" name="created_at" value="{{ $data['created'] }}" >
    <button class="btn btn-outline-info " type="submit">Search</button>
