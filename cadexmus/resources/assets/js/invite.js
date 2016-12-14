var userToInvite;

$(document).ready(function(){

    $('#inviteForm').submit(function(event){
    event.preventDefault();
    invite();
    });

    function invite(){
    	userToInvite = $('#userToInvite').val();
    	console.log(userToInvite);
        
    	$.ajax({
      	url: urlInvite,
      	type: 'GET',
      	cache: false,
      	data: {
      		userToInvite: userToInvite
      	},
      	success: function(data){
      		console.log(data);
      		//notif
      	}});

    }
});
