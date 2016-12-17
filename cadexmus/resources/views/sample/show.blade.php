<label id="sample-name">{{$sample->nom}}</label>
<label id="sample-url">{{$sample->url}}</label>
<script>
    var sampleName = document.getElementById("sample-name").innerHTML;
    var sampleUrl = document.getElementById("sample-url").innerHTML;
    window.top.window.callback(sampleName,sampleUrl);
</script>