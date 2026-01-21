<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@if (session('error'))
    {{ session('error') }}
@endif
<form action="{{route('locktest')}}" method="post">
    {{-- Generate unique key per form load --}}
    <input type="hidden" name="idempotency_key" value="{{ Str::uuid() }}"> @csrf
    <button>test</button>
</form>
</body>
</html>
