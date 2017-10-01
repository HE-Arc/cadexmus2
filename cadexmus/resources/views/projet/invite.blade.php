<div class="invite" data-as-guest="{{ $asGuest }}">
    <h3>Add a collaborator</h3>

    <form action="{{ route('projet.invite', $projet) }}" style="margin: 0 10px 0">
        <input name="pseudo" type="text" class="form-control" placeholder="username" maxlength="191">
    </form>
</div>
