@csrf
<input class="form-control me-2" type="text" name="search" value="{{ $data['search'] }}" placeholder="project name" aria-label="Search">
<input class="form-control me-2" type="text" name="member_name" value="{{ $data['memberName'] }}" placeholder="member name" aria-label="Search">
<input type="date" class="form-control" name="created_at" value="{{ $data['created'] }}">
<button class="btn btn-outline-success " type="submit">Search</button>