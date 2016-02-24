@extends('default')

@section('content')

@include('objects/modal_skins', array('object' => 'Skins',
																			'heading' => 'Create New Skin'))

<script>
	$('document').ready(function() {
		ModalManager.token = "{{ csrf_token() }}";
		ModalManager.action = "/dashboard/settings/skins/";
		ModalManager.register_eventhandlers();
	});
</script>

<div class="global">
	<div class="row">
			{!! Form::open(['route' => 'dashboard.settings.skins.filter', 'method' => 'POST']) !!}
				<h3>Skins Editor</h3>
				<ul name="lstSkinControls">
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
						<button type="submit" name="btnFindSkin">Find</button>
						<button type="submit" name="btnFindAll">Find All</button>
					</li>
				</ul>
			{!! Form::close() !!}
	</div>

	<div class="row">
		@include('objects/listSkins')
	</div>
</div>
@endsection
