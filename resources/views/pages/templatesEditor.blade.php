@extends('backend')

@section('content')

@include('objects/modal_templates', array('object' => 'Templates',
																			'heading' => 'Create New Template'))

@include('objects/modal_delete', array('object' => 'Delete'))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/settings/templates/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			{!! Form::open(['route' => 'dashboard.settings.templates.filter', 'method' => 'POST']) !!}
				<h3>Template Editor</h3>
				@if (Session::has('message'))
					<h5>{{Session::pull('message')}}</h5>
				@else
					<h5>Manage templates</h5>
				@endif
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
						<button type="submit" name="btnFindTemplate">Filter</button>
						<button type="submit" name="btnFindAll">Clear Filter</button>
					</li>
				</ul>
			{!! Form::close() !!}
	</div>

	<div class="row">
		@include('objects/listTemplates', array('editMode' => true))
	</div>
</div>
@endsection
