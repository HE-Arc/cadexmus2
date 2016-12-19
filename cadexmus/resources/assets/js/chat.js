var username;

$(document).ready(function () {

    username = $('#usernamelogged').html();
    var message_template = require("../../views/chat/message.hbs");

    //pullData();
    var host = 'ws://localhost:8889';
    var socket = null;
    var socketOpen = false;
    webSocket();
    retrieveChatMessages();

    $('#sendMsgForm').submit(function (event) {
        event.preventDefault();
        sendMessage();
    });


    function pullData() {
        retrieveChatMessages();
        setTimeout(pullData, 5000);
    }

    function webSocket() {

        try {
            socket = new WebSocket(host);

            //Manages the open event within your client code
            socket.onopen = function () {
                console.log('Connection Opened');
                socketOpen=true;
                return;
            };
            //Manages the message event within your client code
            socket.onmessage = function (msg) {
                var objMessage = JSON.parse(msg.data);
                appendMessage(objMessage);
                return;
            };
            //Manages the close event within your client code
            socket.onclose = function () {
                console.log('Connection Closedl');
                pullData();
                return;
            };
        } catch (e) {
            console.log(e);
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
                retrieveChatMessages();
            });
            appendMessage(j);
            var myJson = JSON.stringify(j);
            if(socketOpen)
                socket.send(myJson);
        }
    }
});
