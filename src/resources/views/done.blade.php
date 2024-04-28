<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @foreach ($shops as $shop)
    <div>{{ $shop->name }}</div>
    <div>{{ $shop->area }}</div>
    <div>{{ $shop->genre }}</div>
    <div>{{ $shop->description }}</div>
    <div><img src="{{ $shop->image }}"></div>
    <div><img src="image/yakiniku.jpg"></div>
    @endforeach
</body>
</html>