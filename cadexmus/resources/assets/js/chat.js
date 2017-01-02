$(document).ready(function () {
    var username = $('#usernamelogged').html();
    var message_template = require("../../views/chat/message.hbs");
	
    retrieveChatMessages();
    changeRefreshMode();
    var pullInterval;

    $('#sendMsgForm').submit(function (event) {
        event.preventDefault();
        if($('#title').data('as-guest')){
            alert("you are not in the project, you can't chat");
            return;
        }
        sendMessage();
    });
	
	
	/* polling */
	
    function changeRefreshMode(){
        if($("#autoRefresh").prop('checked'))
            pullInterval = setInterval(retrieveRecentChatMessages, 5000);
        else
            clearInterval(pullInterval);
    }

	$("#autoRefresh").change(changeRefreshMode);
	

    function retrieveChatMessages() {
        $.get(urlRetrieveChatMessages, function(data){
            // enlève le petit ajax-loader
            $('#chatDisplayMessages').html("");
            appendMessages(data);
        });
    }

    function retrieveRecentChatMessages() {
        $.get(urlRetrieveRecentChatMessages, function(data){
            if(data.length)
                appendMessages(data);
        });
    }

    function appendMessages(data){
        console.log("nouveaux messages", data);
        var messageElement = "";
        var messageConcat = [];

        for (var i = 0; i < data.length; i++) {
            messageElement = message_template({
                name: data[i].user.name,
                body: data[i].body
            });
            messageConcat.push(messageElement);
        }
        var messages = messageConcat.join('');

        $('#chatDisplayMessages').append(messages);
        scrollBotChat();
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
                if(! $("#autoRefresh").prop('checked'))
                    retrieveRecentChatMessages();
            });
            var myJson = JSON.stringify(j);
        }
    }

    function appendMessage(msg){
        messageElement = message_template({
            name: msg.username,
            body: msg.message
        });
        $('#chatDisplayMessages').append(messageElement);
        scrollBotChat();
    }
});
