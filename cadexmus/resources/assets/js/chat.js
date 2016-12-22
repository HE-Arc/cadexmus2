var username;

$(document).ready(function () {
    username = $('#usernamelogged').html();
    var message_template = require("../../views/chat/message.hbs");
	
    retrieveChatMessages();

    $('#sendMsgForm').submit(function (event) {
        event.preventDefault();
        if($('#title').data('as-guest')){
            alert("you are not in the project, you can't chat");
            return;
        }
        sendMessage();
    });
	
	
	/* long polling */

	var pullInterval;
	
    function changeRefreshMode(){
        if($("#autoRefresh").prop('checked'))
            pullInterval = setInterval(retrieveRecentChatMessages, 5000);
        else
            clearInterval(pullInterval);
    }
	
	changeRefreshMode();
	
    retrieveChatMessages();
	$("#autoRefresh").change(changeRefreshMode);
	
	

    function appendMessage(msg){
        messageElement = message_template({
            name: msg.username,
            body: msg.message
        });
        $('#chatDisplayMessages').append(messageElement);
        scrollBotChat();
    }



    function retrieveRecentChatMessages() {
        $.ajax({
            url: urlRetrieveRecentChatMessages,
            type: 'GET',
            cache: false,
            success: function (data) {
                var messageElement = "";
                var messageConcat = [];

                for (var i = 0; i < data.length; i++) {
                    messageElement = message_template({
                        name: data[i].user.name,
                        body: data[i].body
                    });
                    messageConcat.push(messageElement);
                }
                message = messageConcat.join('');

                $('#chatDisplayMessages').append(message);
                scrollBotChat();
            }
        });
    }    

    function retrieveChatMessages() {
        $.ajax({
            url: urlRetrieveChatMessages,
            type: 'GET',
            cache: false,
            success: function (data) {
                var messageElement = "";
                var messageConcat = [];

                for (var i = 0; i < data.length; i++) {
                    messageElement = message_template({
                        name: data[i].user.name,
                        body: data[i].body
                    });
                    messageConcat.push(messageElement);
                }
                message = messageConcat.join('');

                $('#chatDisplayMessages').html(message);
                scrollBotChat();
            }
        });
    }

    function scrollBotChat() {
        var chatDisplayMessages = $('#chatDisplayMessages');
        var height = chatDisplayMessages[0].scrollHeight;
        chatDisplayMessages.scrollTop(height);
    }


    function sendMessage() {
        var j = {message: $('#text').val(), username: username};
        if(j.message.length > 0){
            $('#text').val('');
            $.post(urlSendMessage, {text: j.message}, function(){
                console.log("message sent");
                //retrieveChatMessages();
            });
            //appendMessage(j);
            var myJson = JSON.stringify(j);
        }
    }
});
