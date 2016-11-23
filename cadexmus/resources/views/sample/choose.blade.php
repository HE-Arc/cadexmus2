
@foreach ($samples as $s)
    <p>{{ $s->id }} : {{ $s->nom }}</p>
    <audio controls src="uploads/{{$s->url}}"></audio>
@endforeach
@include('sample.create')