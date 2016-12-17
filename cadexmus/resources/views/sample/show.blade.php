<label id="sample-name">{{$sample->nom}}</label>
<label id="sample-url">{{$sample->url}}</label>
<script>
    var sampleName = document.getElementById("sample-name").innerHTML;
    var sampleUrl = document.getElementById("sample-url").innerHTML;
    // appelle la méthode callback de la fenêtre mère
    // https://openclassrooms.com/courses/dynamisez-vos-sites-web-avec-javascript/upload-via-une-iframe#/id/r-1927437
    window.top.window.callback(sampleName,sampleUrl);
</script>