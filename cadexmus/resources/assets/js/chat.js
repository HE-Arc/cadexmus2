var username;

$(document).ready(function () {

    username = $('#username').html();

    pullData();
    retrieveChatMessages();
    var isTypingSent = false;

    $('#sendMsgForm').submit(function (event) {
        event.preventDefault();
        sendMessage();
    });

    function pullData() {
        retrieveChatMessages();
        setTimeout(pullData, 5000);
    }

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
            for (var i = 0; i < data.length; i++) {
                var message_template = require("../../views/chat/message.hbs");
                var messageElement = message_template({
                name:  data[i].user.name,
                body: data[i].body
                });
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
  var message_template = require("../../views/chat/message.hbs");
  var messageElement = message_template({
  name: username,
  body: message
  });


    function sendMessage() {
        message = $('#text').val();
        var messageElement = '<div class="ChatMessage">' +
            '<p class="sender">{{username}}</p>' +
            '<p class="message">{{message}}</p>' +
            '</div>';

        $('#chatDisplayMessages').append(messageElement);
        scrollBotChat();
        var text = $('#text').val();
        $('#text').prop("disabled", true);

        if (text.length > 0) {
            $.post(urlSendMessage, {text: text}, function () {
                $('#text').val('').prop("disabled", false).focus();
                retrieveChatMessages();
            });
        }
    }


});
