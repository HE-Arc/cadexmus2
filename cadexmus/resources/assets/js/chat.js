var username;

$(document).ready(function()
{

    username = $('#username').html();

    pullData();
    var isTypingSent = false;
    $(document).keyup(function(e) {
        if (e.keyCode == 13)
            sendMessage();
        else
            if(isTypingSent==false) isTyping();
    });

    $("#btnSendMsg").click(sendMessage);
    $("#text").blur(notTyping);

function pullData()
{
    retrieveChatMessages();
    retrieveTypingStatus();
    setTimeout(pullData,5000);
}

function retrieveChatMessages()
{

      $.ajax({
      //url: $("#retrieveChatMessages").html(),
      url: urlRetrieveChatMessages,
      type: 'GET',
      cache: false,
      success: function(data){
            $('#chat-window').html("");
        for (var k in data) {
            $('#chat-window').append('<br><div><li>'+data[k]['name'] +'</li></div><br>');
            $('#chat-window').append('<br><div>'+data[k]['body'] +'</div><br>');

        }
      }});
}



function retrieveTypingStatus()
{
      $.ajax({
      url: urlGetUserName,
      type: 'GET',
      cache: false,
      success: function(text){
        // console.log(text);
        $.get(urlRetrieveTypingStatus, {username: text}, function(data)
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

}

function sendMessage()
{
    var text = $('#text').val();

    if (text.length > 0)
    {
        $.post(urlSendMessage, {text: text}, function()
        {
            $('#chat-window').append('<br><div>'+text+'</div><br>');
            $('#text').val('');
            notTyping();
        });
    }
}

function isTyping()
{
  isTypingSent = true;

      $.ajax({
      url: urlIsTyping,
      type: 'POST',
      cache: false,
      });
}



function notTyping()
{
  isTypingSent = false;
       $.ajax({
      url: urlNotTyping,
      type: 'POST',
      cache: false,
      });
}


});
