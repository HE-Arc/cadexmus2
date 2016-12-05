<!DOCTYPE html>
<meta name="csrf-token" content="{{ csrf_token() }}" />
<html>
<head>

    <script src="{{ asset('js/jquery-1.11.1.min.js' )}}"></script>

    <title>Chats</title>

</head>
<body>

    <div>

        <div id="chat-window">

        </div>
        <div>
            <div id="typingStatus"></div>
            <input type="text" id="text" autofocus="" onblur="notTyping()">
            <button id="btnSendMsg" onclick="sendMessage();">Envoyer</button>
        </div>
    </div>


</body>
</html>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
    <script>
var username;

$(document).ready(function()
{
    username = $('#username').html();

    pullData();

    $(document).keyup(function(e) {
        if (e.keyCode == 13)
            sendMessage();
        else
            isTyping();
    });
});

function pullData()
{
    retrieveChatMessages();
    retrieveTypingStatus();
    setTimeout(pullData,2000);
}

function retrieveChatMessages()
{

      $.ajax({
      url: "{{ route('projet.retrieveChatMessages',$projet) }}",
      type: 'GET',
      cache: false,
      success: function(data){
        //console.log(data+ "DATA");
            $('#chat-window').html("");
        for (var k in data) {
            $('#chat-window').append('<br><div><li>'+data[k]['name'] +'</li></div><br>');
            $('#chat-window').append('<br><div>'+data[k]['body'] +'</div><br>');

        }
      }});
  /*  $.post('http://localhost/cadexmus2/cadexmus/public/retrieveChatMessages/projet/', {username: username}, function(data)
    {
        $('#chat-window').html("");
        for (var k in data) {
            $('#chat-window').append('<br><div><li>'+data[k]['sender_username'] +'</li></div><br>');
            $('#chat-window').append('<br><div>'+data[k]['message'] +'</div><br>');
        }*/

       /* if (data.length > 0)
            $('#chat-window').append('<br><div>'+data+'</div><br>');
    });*/
}


function deleteRow(rowid)  
{   
    var row = document.getElementById(rowid);
    row.parentNode.removeChild(row);
}

function retrieveTypingStatus()
{
      $.ajax({
      url: "{{ route('projet.getUserName') }}",
      type: 'GET',
      cache: false,
      success: function(text){
        // console.log(text);
        $.get("{{ route('projet.retrieveTypingStatus',$projet) }}", {username: text}, function(data)
        {

          isMeTyping = false;
            if (data.length > 0)
            {
                for (var i = 0; i < data.length; i++) {

                    if(text == data[i]['name'])
                    {
                        isMeTyping = true;
                    }
                    else
                    {
                        if(i==data.length-1)
                        {
                            typingStatus += data[i]['name'];
                        }
                        else
                        {
                           typingStatus += data[i]['name'] + ', '; 
                        }   
                    }
                                    
                }
            }
            else
            {
                typingStatus = "";
            }

            dataLengh = data.length;
            if(isMeTyping&&dataLengh>0) dataLengh--;

            switch(dataLengh) {
             case 0:
                typingStatus = '';
             break;
             case 1:
                typingStatus += ' is typing';
             break;
             default:
                typingStatus +=' are typing';

            } 
            $('#typingStatus').html(typingStatus);
            typingStatus = '';

        
        });
      }});

/*
    $.post('http://localhost/cadexmus2/cadexmus/public/retrieveTypingStatus', {username: username}, function(username)
    {
        if (username.length > 0)
            $('#typingStatus').html(username+' is typing');
        else
            $('#typingStatus').html('');
    });*/
}

function sendMessage()
{
    var text = $('#text').val();

    if (text.length > 0)
    {
        $.post("{{ route('projet.sendMessage',$projet) }}", {text: text}, function()
        {
            $('#chat-window').append('<br><div>'+text+'</div><br>');
            $('#text').val('');
            notTyping();
        });
    }
}

function isTyping()
{
    /*username = $.post('http://localhost/cadexmus2/cadexmus/public/getUserName');
    console.log(username);*/
   // $.post('http://localhost/Laravel-Ajax/public/projet/'+projet.id+'/isTyping/', {username: username});

	 /*   $.ajax({
	    type: 'POST',
	    url: 'http://localhost/Laravel-Ajax/public/isTyping',
	    data: { 
	        username: username
	    }
	});*/

      $.ajax({
      url: "{{ route('projet.isTyping',$projet) }}",
      type: 'GET',
      cache: false,
      success: function(text){
       //  console.log(text);
      }});
}



function notTyping()
{
       $.ajax({
      url: "{{ route('projet.notTyping',$projet) }}",
      type: 'GET',
      cache: false,
      success: function(text){
       //  console.log(text);
      }});
}
    </script>