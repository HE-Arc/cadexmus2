
<div id="chatDisplayMessages">
    <span><img src="{{asset('images/ajax-loader.gif')}}"></span>
</div>
<div id="chatWriteMessage">
    <hr>
    <input class="form-control" id="text" type="text" placeholder="message">
    <button id="btnSendMsg">Envoyer</button>
</div>  
<script src="{{ asset('js/chat.js')}}"></script>
<script>
    var urlRetrieveChatMessages = "{{ route('projet.retrieveChatMessages',$projet) }}";
    var urlGetUserName = "{{ route('projet.getUserName') }}";
    var urlSendMessage = "{{ route('projet.sendMessage',$projet) }}";
    var urlIsTyping = "{{ route('projet.isTyping',$projet) }}";
    var urlNotTyping = "{{ route('projet.notTyping',$projet) }}";
    var urlRetrieveTypingStatus = "{{ route('projet.retrieveTypingStatus',$projet) }}";
</script>

