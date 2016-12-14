var userToInvite;

$(document).ready(function(){

    $('#inviteForm').submit(function(event){
        event.preventDefault();
        invite();
    });

    function invite(){
    	userToInvite = $('#userToInvite').val();
        
    	$.ajax({
            url: urlInvite,
            type: 'GET',
            cache: false,
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
        $("#infoInvite").text(data);
        $("#infoInvite").show();
        $("#infoInvite").fadeOut(5000);
    }
});
