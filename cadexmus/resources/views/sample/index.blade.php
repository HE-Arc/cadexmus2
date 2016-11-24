<ul>
@foreach ($samples as $s)
    <li class="sample" sampleName="{{$s->nom}}" sampleUrl="{{$s->url}}" style="cursor: pointer;">
        <p>{{ $s->id }} : {{ $s->nom }}</p>
        <audio controls src="{{asset("uploads")}}/{{$s->url}}"></audio>
    </li>
@endforeach
</ul>
@include('sample.create')