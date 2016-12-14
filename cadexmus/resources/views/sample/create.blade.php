<h4 class="modal-title">Or upload your custom sample</h4>

<br>
<form class="form-horizontal" action="{{ route('sample.store')}}" method="post"  enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="fileInput" class="col-md-4 control-label">Select file : </label>

        <div class="col-md-6">
            <label for="fileInput" class="form-control btn">Choose a file from your computer</label>
            <input type="file" id="fileInput" accept="audio/*" name="url" style="display:none">
        </div>
    </div>

    <div class="form-group">
        <label for="fileName" class="col-md-4 control-label">Name : </label>

        <div class="col-md-6">
            <input id="fileName" type="text" class="form-control" name="nom" required>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label">Type : </label>

        <div class="col-md-6">
            <select name="type" class="form-control">
        		<option>default</option>
        		<option>instrument</option>
        		<option>fx</option>
        		<option>drums</option>
        	</select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <input type="submit" class="btn btn-default" value="Upload and choose">
        </div>
    </div>

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
