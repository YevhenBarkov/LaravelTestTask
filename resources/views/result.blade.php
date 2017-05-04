@extends('app')
@section('content')
    <form action="/save" method="post" id="form2">
        Hashes for string : {{$str}}<br>
        <input type="hidden" name="words" value="{{$str}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @foreach($hashes as $name => $hash)
            <input type="checkbox" name="{{$name}}" value="{{$hash}}">
            {{$name}} : {{$hash}}<br>
        @endforeach
    </form>

    <div class="bottom-part">
        <button type="submit" form="form2" value="Save"><h2>Save</h2></button>
    </div>
@stop