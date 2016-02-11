@extends('default')

@section('content')

@include('objects/modal_templates', array('object' => 'Templates',
																			'heading' => 'Create New Template',
																			'allowed_departments' => $allowed_departments))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/settings/templates/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			{!! Form::open(['route' => 'dashboard.settings.templates.process', 'method' => 'POST']) !!}
				<h3>Template Editor</h3>
				<ul name="lstTemplateControls">
					<li>
						<input type="text" name="txtTemplateName" placeholder="Template Name...."
									 value="{{ $searchItem or '' }}"/>
	          <input type="text" name="txtTemplateClass" placeholder="Template Class...."
	                        value="{{ $searchItem or '' }}"/>
	          <input type="number" name="numTemplateDuration" placeholder="Duration (Seconds)...."
	                        value="{{ $searchItem or '' }}"/>
						<a href="#TemplatesModal" data-displayCreateModal="true"
																		data-modalObject="Templates"
																		data-modalMethod="POST"
																		data-modalRoute="{{ URL::route('dashboard.settings.templates.store') }}">
							<button type="button" name="btnAddTemplate">Add</button>
						</a>
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
