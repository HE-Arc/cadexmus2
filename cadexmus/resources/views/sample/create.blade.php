@extends('layouts.app')

@section('content')
<form class="form-horizontal" action="{{ route('sample.store')}}" method="post"  enctype="multipart/form-data">
    {{ csrf_field() }}
    
	<input type="file" name="url"  accept="audio/*">
	
    <label for="name">nom : </label>
	<input type="text" name="nom">
	<br>
    
	<label for="type">type : </label>
	<select name="type">
		<option>instrument</option>
		<option>fx</option>
		<option>drums</option>
	</select>
	<br>
	
    <input type="submit">
</form>
@endsection
