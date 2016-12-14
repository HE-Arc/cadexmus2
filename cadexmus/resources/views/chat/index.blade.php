
<div id="chatDisplayMessages">
    <span><img src="{{asset('images/ajax-loader.gif')}}"></span>
</div>
<div id="chatWriteMessage">
    <hr>
    <form id="sendMsgForm">
        <input class="form-control" id="text" type="text" placeholder="message">
    </form>

</div>  
<script src="{{ asset('js/chat.js')}}"></script>
<script>
    var urlRetrieveChatMessages = "{{ route('projet.retrieveChatMessages',$projet) }}";
    var urlSendMessage = "{{ route('projet.sendMessage',$projet) }}";
</script>

