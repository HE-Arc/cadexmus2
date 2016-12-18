<div id="errors" class="alert alert-danger">
@if (count($errors) > 0)
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@else
    {{ $urlError or 'Une erreur est survenue' }}
@endif
</div>

<script>
    var errors = document.getElementById("errors").outerHTML;
    window.top.window.error(errors);
</script>