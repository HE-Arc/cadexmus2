var username;

$(document).ready(function()
{

    username = $('#username').html();

    pullData();
    var isTypingSent = false;
    $(document).keyup(function(e) {
        if (e.keyCode == 13)
            sendMessage();
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
      url: urlRetrieveChatMessages,
      type: 'GET',
      cache: false,
      success: function(data){
            $('#chatDisplayMessages').html("");
            for (i = 0; i < data.length; i++) {
                var messageElement = '<div class="chatMessage">'+
                '<p class="sender">'+data[i].user.name+'</p>'+
                '<p class="message">'+data[i].body+'</p>'+
                '</div>';
                $('#chatDisplayMessages').append(messageElement);
              }
              scrollBotChat();
      }});
}

function scrollBotChat()
{
  var chatDisplayMessages = $('#chatDisplayMessages'); 
  var height = chatDisplayMessages[0].scrollHeight;
   chatDisplayMessages.scrollTop(height);
}


function sendMessage()
{
  message = $('#text').val();
  var messageElement = '<div class="ChatMessage">'+
                       '<p class="sender">'+username+'</p>'+
                       '<p class="message">'+message+'</p>'+
                       '</div>';

  $('#chatDisplayMessages').append(messageElement);
  scrollBotChat();
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
