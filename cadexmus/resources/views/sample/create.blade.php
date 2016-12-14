

<form class="form-horizontal" action="{{ route('sample.store')}}" method="post"  enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="password-confirm" class="col-md-4 control-label" for="fileInput">Select file : </label>

        <div class="col-md-6">
            <input type="file" id="fileInput" accept="audio/*" id="input-1a" class="file" data-show-preview="false" name="url">
        </div>
    </div>

    <div class="form-group">
        <label for="password-confirm" class="col-md-4 control-label">Name : </label>

        <div class="col-md-6">
            <input id="fileName" type="text" class="form-control" name="nom" required>
        </div>
    </div>

    <div class="form-group">
        <label for="password-confirm" class="col-md-4 control-label">Type : </label>

        <div class="col-md-6">
            <select name="type" class="selectpicker">
        		<option>default</option>
        		<option>instrument</option>
        		<option>fx</option>
        		<option>drums</option>
        	</select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <input type="submit" class="btn btn-default" value="Validate">
        </div>
    </div>

    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
