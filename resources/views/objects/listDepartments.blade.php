<ul name="lstDepartmentItems">
  @if(isset($departments))
    @if($departments->count() > 0)
      @foreach($departments as $department)
        <li>
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


            @if ($user->is_super_user)
              {{-- Show correct button to disable ot enable --}}
              {!! Form::open(['route' => ['dashboard.settings.departments.destroy', $department->id], 'method' => 'DELETE']) !!}
                <button type="submit" name="btnDelete">Delete</button>
              {!! Form::close() !!}
            @endif
          @endif
        </li>
      @endforeach
    @else
      <li name="itmNone">
        <h3>No departments found.</h3>
      </li>
    @endif
  @endif
</ul>
