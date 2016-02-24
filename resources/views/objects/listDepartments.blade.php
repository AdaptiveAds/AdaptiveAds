<ul name="lstDepartmentItems">
  @if(isset($departments))
    @if($departments->count() > 0)
      @foreach($departments as $department)
        <li>
          <a href="#">
            {{ $department->name }}
          </a>
          <a href="#DepartmentsModal" data-displayEditModal="true"
                                      data-modalObject="Departments"
                                      data-modalMethod="PUT"
                                      data-modalRoute="{{ URL::route('dashboard.settings.departments.update', $department->id) }}"
                                      data-userID="{{ $department->id }}">
            <button type="button" name="btnEdit">Edit</button>
          </a>


          {{-- Show correct button to disable ot enable --}}
          {!! Form::open(['route' => ['dashboard.settings.departments.toggleDeleted', $department->id], 'method' => 'POST']) !!}
            @if ($department->deleted == 0)
              <button type="submit" name="btnDisable">Disable</button>
            @else
              <button type="submit" name="btnEnable">Enable</button>
            @endif
          {!! Form::close() !!}
        </li>
      @endforeach
    @else
      <li name="itmNone">
        <h3>No departments found.</h3>
      </li>
    @endif
  @endif
</ul>
