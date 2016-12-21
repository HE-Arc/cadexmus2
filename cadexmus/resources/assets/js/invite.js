var userToInvite;

$(document).ready(function(){

    $('#inviteForm').submit(function(event){
        event.preventDefault();
        var asGuest = $('#title').data('as-guest') === "true";
        if(asGuest){
            alert("you are not in the project, you can't invite");
            return;
        }
        invite($(this).attr('action'));
        $('#userToInvite').val("");
    });

    function invite(url){
    	userToInvite = $('#userToInvite').val();

    	$.ajax({
            url: url,
            type: 'POST',
            data: {
                userToInvite: userToInvite
            },
            success: function(data){
                console.log(data);
                info(data);
      	    }
    	});

    }

    function info(data){
        $("#infoInvite").text(data).show().fadeOut(5000);
    }
});
