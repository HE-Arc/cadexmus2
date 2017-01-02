<?php
    $version = $projet->versions[0];
    $users = $projet->users;
?>
@foreach ($users as $user)
    <img title="{{ $user->name }}" alt="{{ $user->name }}" class="img-circle img-user{{($user->pivot->couleur-1)%8}}"
         src="{{ asset('uploads/picture/profile/' . $user->picture) }}">
@endforeach

<h1><a id="title" href="{{ route('projet.show', $projet) }}"
       data-version="{{ $version->numero }}"
       data-color="{{ $userColor or 7 }}"
	   data-as-guest="{{ $asGuest or "false" }}"
	   >
    {{ $projet->nom }}</a>
</h1>

<div id="repr">
    @include("projet.repr", $version->repr)
</div>
<p>
    <button class="save btn">Save</button>
    <button class="refresh btn">Refresh</button> <span id="infos"></span>

<p>
    <input type="checkbox" id="autoRefresh"> automatic refresh

{{-- Modal --}}
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        @include('sample.index', ['samples' => $samples])
    </div>
</div>
