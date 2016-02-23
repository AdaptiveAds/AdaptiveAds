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
			{!! Form::open(['route' => 'dashboard.settings.skins.process', 'method' => 'POST']) !!}
				<h3>Skins Editor</h3>
				<ul name="lstTemplateControls">
					<li>
						<input type="text" name="txtSkinName" placeholder="Skin Name...."
									 value="{{ $searchItem or '' }}"/>
	          <input type="text" name="txtSkinClass" placeholder="Skin Class...."
	                        value="{{ $searchItem or '' }}"/>
						<a href="#SkinsModal" data-displayCreateModal="true"
																		data-modalObject="Skins"
																		data-modalMethod="POST"
																		data-modalRoute="{{ URL::route('dashboard.settings.skins.store') }}">
							<button type="button" name="btnAddSkin">Add</button>
						</a>
						<button type="submit" name="btnFind">Find</button>
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
