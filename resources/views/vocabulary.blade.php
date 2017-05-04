@extends('app')
@section('content')

    <div class="top-part">
        <h2>Select words and hashes</h2>
    </div>

    <div class="hold">
        <div class="left-part">
            Words:
            <select id="words" size="1" autocomplete="off">
                @foreach($words as $word)
                    <option value={{$word->word}}>{{$word->word}}</option>
                @endforeach
            </select>
            <button id="addWord"> Add this word</button>

            <p id="selectedWords"></p>
        </div>
        <div class="right-part">
            <form action="/hash" id="form1">
                <input type="checkbox" id="md5" name="md5" value="1">
                <label for="md5">Use md5 algorithm</label><br>

                <input type="checkbox" id="sha1" name="sha1" value="1">
                <label for="sha1">Use sha1 algorithm</label><br>

                <input type="checkbox" id="gost" name="gost" value="1">
                <label for="gost">Use gost algorithm</label><br>

                <input type="checkbox" id="snefru" name="snefru" value="1">
                <label for="snefru">Use snefru algorithm</label><br>

                <input type="checkbox" id="whirlpool" name="whirlpool" value="1">
                <label for="whirlpool">Use whirlpool algorithm</label><br>

                <input type="hidden" id="allSelectedWords" name="allSelectedWords">
            </form>
        </div>
    </div>
    <div class="errors">
        @foreach($errors as $error)
            {{$error}}
        @endforeach
    </div>
    <div class="bottom-part">
        <button type="submit" form="form1" value="Hash!"><h2>Hash!</h2></button>
    </div>
@stop