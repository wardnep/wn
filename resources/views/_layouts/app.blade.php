@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
@stop

@section('js')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LPBRPKTYDE"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-LPBRPKTYDE');
    </script>
@stop
