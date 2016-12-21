<h3>Ajouter un collaborateur</h3>
<div id="invite">
<form id="inviteForm" action="{{ route('projet.invite',$projet) }}" data-as-guest="{{ $asGuest }}"
        style="margin: 0 10px 0 0">
    <input id="userToInvite" type="text" class="form-control" placeholder="pseudo du collaborateur">
</form>
<span id="infoInvite"></span>
</div>
