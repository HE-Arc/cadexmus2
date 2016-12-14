var username;

$(document).ready(function(){

    username = $('#username').html();
    var message_template = require("../../views/chat/message.hbs");

    pullData();
    retrieveChatMessages();
    var isTypingSent = false;

    $('#sendMsgForm').submit(function(event){
        event.preventDefault();
        sendMessage();
    });


function pullData(){
    retrieveChatMessages();
    setTimeout(pullData,5000);
}

//alert("test");
function retrieveChatMessages(){

      $.ajax({
      url: urlRetrieveChatMessages,
      type: 'GET',
      cache: false,
      success: function(data){
        var messageElement="";
         var messageConcat = [];

          for (var i = 0; i < data.length; i++) {        
              messageElement = message_template({
                name:  data[i].user.name,
                body: data[i].body
              });
              messageConcat.push(messageElement);
          }
          message = messageConcat.join('');

        $('#chatDisplayMessages').html(message);
        scrollBotChat();
      }});
}

function scrollBotChat(){
  var chatDisplayMessages = $('#chatDisplayMessages'); 
  var height = chatDisplayMessages[0].scrollHeight;
   chatDisplayMessages.scrollTop(height);
}


function sendMessage(){
  message = $('#text').val();
  var messageElement = message_template({
  name: username,
  body: message
  });

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
