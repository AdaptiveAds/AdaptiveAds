<ul name="lstDepartmentItems">
  @if(isset($departments))
    @if($departments->count() > 0)
      @foreach($departments as $department)
        <li class="listItem" name="{{ $department->name }}">
          <a href="#">
            {{ $department->name }}
          </a>

          {{-- Only show edit options if in mode --}}
          @if (isset($editMode))

            <a href="#DepartmentsModal" data-displayEditModal="true"
                                        data-modalObject="Departments"
                                        data-modalMethod="PUT"
                                        data-modalRoute="{{ URL::route('dashboard.settings.departments.update', $department->id) }}"
                                        data-userID="{{ $department->id }}">
              <button type="button" name="btnEdit">Edit</button>
            </a>


            <a href="#DeleteModal" data-displayDeleteModal="true"
                                      data-modalObject="Delete"
                                      data-modalMethod="DELETE"
                                      data-modalRoute="{{ URL::route('dashboard.settings.departments.destroy', $department->id) }}"
                                      data-userID="{{ $department->id }}">
              <button type="button" name="btnDelete">Delete</button>
            </a>
          @endif
        </li>
      @endforeach
    @else
      <li name="itmNone" class="listItem">
        <h3>No departments found.</h3>
      </li>
    @endif
  @endif
</ul>
