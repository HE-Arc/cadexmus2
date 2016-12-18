<h4 class="modal-title">Or upload your custom sample</h4>
<br>
<!-- Le formulaire ne va pas exécuter l'action dans cette fenêtre mais dans l'iframe #target -->
<form target="target" class="form-horizontal" action="{{ route('sample.store')}}" method="post"  enctype="multipart/form-data">
    {{ csrf_field() }}
    <!-- La route sample.store retourne une vue qui va être chargée dans cette iframe cachée -->
    <!-- La vue contient un code js qui va tenter d'appeler la méthode callback() de cette fenêtre -->
    <iframe name="target" style="display: none"></iframe>
    <!-- callback() va remplir ces champs cachés avec les données récupérées depuis l'iframe -->
    <!-- on pourra ensuite les lire depuis le jquery pour ajouter la track -->
    <input type="hidden" id="newSampleName">
    <input type="hidden" id="newSampleUrl">

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
            <input type="submit" class="btn" value="Upload and choose">
        </div>
    </div>

    <div id="errors"></div>
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

	// la fonction qui est appelée depuis le contenu de l'iframe
    function callback(sampleName, sampleUrl){
        document.getElementById("newSampleName").value=sampleName;
        document.getElementById("newSampleUrl").value=sampleUrl;
        // on créé un nouvel event custom pour pouvoir le gérer dans le projet.show.js
        // (on ne peut pas appeler directement addTrack depuis ici)
        // https://developer.mozilla.org/fr/docs/Web/Guide/DOM/Events/Creating_and_triggering_events
        var event = new Event('sampleloaded');
        var modal = document.getElementById("myModal");
        modal.dispatchEvent(event);
    }

    // fonction appelée depuis l'iframe si la validation a échouée
    function error(errors){
        document.getElementById("errors").innerHTML = errors;
    }
</script>
