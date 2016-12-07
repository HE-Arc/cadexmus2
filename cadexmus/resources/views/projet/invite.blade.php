<h3>Ajouter un collaborateur</h3>
<div id="invite">
<form id="inviteForm" style="margin: 0 10px 0 0">
<input id="userToInvite" type="text"  class="form-control" placeholder="pseudo du collaborateur">
</form>
</div>
<script src="{{ asset('js/invite.js')}}"></script>
<script>
    var urlInvite = "{{ route('projet.invite',$projet) }}";
</script>