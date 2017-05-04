<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/simple.css') !!}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <title>Some</title>
</head>
<script>
    $(document).ready(function () {
        $('#addWord').click(function () {
            $('#selectedWords').append(' ' + $('#words').val());
            $('#allSelectedWords').val($('#selectedWords').text());
        });
    });

</script>
<body>

<header><h1>Words hashing</h1></header>
<nav>
    <ul>
        <li><a href="/">Select words</a> </li>
        <li><a href="/getLastSavedHashes" target="_blank">Last hashes</a> </li>
        <li><a href="/getAllSavedHashes" target="_blank">All hashes</a> </li>
    </ul>

</nav>

<div class="container">

    <div id="content">
        @yield('content')
    </div>

</div>

<footer>Test Task</footer>

</body>
</html>
