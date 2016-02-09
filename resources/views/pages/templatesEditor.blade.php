@extends('default')

@section('content')

<div class="global">
	<div class="row">
			{!! Form::open(['route' => 'dashboard.settings.templates.process', 'method' => 'POST', 'files' => 'true']) !!}
				<h3>Template Editor</h3>
				<ul name="lstTemplateControls">
					<li>
						<input type="text" name="txtTemplateName" placeholder="Template Name...."
									 value="{{ $searchItem or '' }}"/>
	          <input type="text" name="txtTemplateClass" placeholder="Template Class...."
	                        value="{{ $searchItem or '' }}"/>
	          <input type="number" name="numTemplateDuration" placeholder="Duration (Seconds)...."
	                        value="{{ $searchItem or '' }}"/>
	          <input type="file" name="filTemplateThumbnail"/>
	          <!-- Needs href - JOSH? -->
						<button type="submit" name="btnAddTemplate">Add</button>
						<button type="submit" name="btnFindTemplate">Find</button>
						<button type="submit" name="btnFindAll">Find All</button>
					</li>
				</ul>
			{!! Form::close() !!}
	</div>

	<div class="row">
		@include('objects/listTemplates')
	</div>
</div>
@endsection
