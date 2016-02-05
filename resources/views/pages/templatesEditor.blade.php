@extends('default')

@section('content')

@include('objects/model_create', array('object' => 'Playlist',
																			 'allowed_departments' => $allowed_departments,
																			 'route' => 'dashboard.playlist.store'))

<div class="global">
	<div class="row">
			<!-- TODO ADD FORM -->
			<h3>Template Editor</h3>
			<ul>
				<li>
					<input type="name" name="templateName" placeholder="Template Name...."
								 value="{{ $searchItem or '' }}"/>
          <input type="name" name="templateClass" placeholder="Template Class...."
                        value="{{ $searchItem or '' }}"/>
          <input type="name" name="templateDuration" placeholder="Template Duration...."
                        value="{{ $searchItem or '' }}"/>
          <input type="name" name="templateDuration" placeholder="Thumbnail Path..."
                        value="{{ $searchItem or '' }}"/>
          <!-- Needs href - JOSH? -->
					<a href=""><button type="submit" name="btnaddTemplate">Save</button></a>
				</li>
			</ul>
	</div>

	<div class="row">
		@include('objects/playlistItem')
	</div>
</div>
@endsection
