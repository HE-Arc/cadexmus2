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

function pullData()
{
    retrieveChatMessages();
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
            $('#chatDisplayMessages').html("");
        for (var k in data) {
            var messageElement = '<div class="chatMessage">'+
                '<p class="sender">'+data[k]['name']+'</p>'+
                '<p class="message">'+data[k]['body']+'</p>'+
              '</div>';
            $('#chatDisplayMessages').append(messageElement);

        }
      }});
}


function sendMessage()
{
    var text = $('#text').val();
    $('#text').prop("disabled",true);        

    if (text.length > 0)
    {
        $.post(urlSendMessage, {text: text}, function()
        {
           $('#text').val('').prop("disabled",false);   
            retrieveChatMessages();
        });
    }
}



});
