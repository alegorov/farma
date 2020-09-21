<!DOCTYPE html>
<html>
<head>
    <title>Vue Examples</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! Html::style('css/app.css') !!}
</head>
<body>
<div id="app">
    @yield("content")
</div>
{{--<script src="/js/app.js"></script>--}}
{!! Html::script('js/app.js') !!}
</body>
</html>
