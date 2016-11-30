
<div class="row">
	<div>
		<div>
			
			@foreach ($messages as $message)
        		<li>{{ $message->user->name }}</li>
        			{{ $message->body }}
    		@endforeach

		</div>
	</div>

	<div>
	<textarea rows="10" placeholder="Enter your message"></textarea>
	<button class="btn-send">Send</button>
	<div>
</div>