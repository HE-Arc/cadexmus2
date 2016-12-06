<html>
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{ asset('js/app.js')}}"></script>
<script src="{{ asset('js/chat.js')}}"></script>
    <title>Chats</title>
</head>
<body>
    <div>
        <div id="chat-window">
        </div>
        <div>
            <div id="typingStatus"></div>
            <input type="text" id="text" autofocus="">
            <button id="btnSendMsg">Envoyer</button>
        </div>
      <!--  <a id="urlRetrieveMessage" style:"display:none">{{ route('projet.retrieveChatMessages',$projet) }}</a> -->
    </div>
<script>
    var urlRetrieveChatMessages = "{{ route('projet.retrieveChatMessages',$projet) }}";
    var urlGetUserName = "{{ route('projet.getUserName') }}";
    var urlSendMessage = "{{ route('projet.sendMessage',$projet) }}";
    var urlIsTyping = "{{ route('projet.isTyping',$projet) }}";
    var urlNotTyping = "{{ route('projet.notTyping',$projet) }}";
    var urlRetrieveTypingStatus = "{{ route('projet.retrieveTypingStatus',$projet) }}";
</script>
</body>
</html>

