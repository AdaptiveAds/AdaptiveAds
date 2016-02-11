<ul name="lstDepartmentItems">
  @if(isset($departments))
    @if($departments->count() > 0)
      @foreach($departments as $department)
        <li>
          <a href="#DepartmentsModal" data-displayEditModal="true"
                                    data-modalObject="Departments"
                                    data-modalMethod="PUT"
                                    data-modalRoute="{{ URL::route('dashboard.settings.departments.update', $department->id) }}"
                                    data-userID="{{ $department->id }}">
            {{ $department->name }}
          </a>
          <button type="button">Edit</button>
          <button type="button">Disable</button>
        </li>
      @endforeach
    @else
      <li name="itmNone">
        <h3>No departments found.</h3>
      </li>
    @endif
  @endif
</ul>
