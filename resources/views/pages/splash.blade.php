@extends('backend')

@section('content')

<div class="buffer" id="home"></div>

<a id="largeArea" href="../index.php?action=login">
<div class="view">
  <div class="plane main">
    <img class="circle" width="100px" src="{{ URL::asset('images/logo.png') }}" alt="php input" title="php input">
  </div>
</div>
</a>
@endsection
