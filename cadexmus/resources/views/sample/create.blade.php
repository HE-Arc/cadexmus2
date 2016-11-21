@extends('layouts.app')

@section('content')
<form class="form-horizontal" action="{{ route('sample.store')}}" method="post"  enctype="multipart/form-data">
    {{ csrf_field() }}

	<input type="file" id="fileInput" accept="audio/*" style="display:none" name="url">
	<label for="fileInput">Select file</label><br>
	
    <label for="name">nom : </label>
	<input id="fileName" type="text" name="nom">
	<br>
    
	<label for="type">type : </label>
	<select name="type">
		<option>default</option>
		<option>instrument</option>
		<option>fx</option>
		<option>drums</option>
	</select>
	<br>
	
    <input type="submit">
</form>

<script>
	document.getElementById("fileInput").addEventListener("change", handleFiles, false);
	function handleFiles() {
		var file = this.files[0];
		if(file!=undefined){
			document.getElementById("fileName").value = file.name.split(".")[0];
			document.getElementById("fileName").focus()
		}
	}
</script>

@endsection
