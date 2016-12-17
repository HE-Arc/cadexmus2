<ul>
@foreach ($samples as $s)
    <li class="sample" data-sampleName="{{$s->nom}}" data-sampleUrl="{{$s->url}}" style="cursor: pointer;">
        <p>{{ $s->id }} : {{ $s->nom }}</p>
        <audio controls src="{{asset("uploads")}}/{{$s->url}}"></audio>
    </li>
@endforeach
</ul>
