<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'wn'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <style>
        body { background: #111827; color: #e5e7eb; }
        /* Transitional styles for existing Blade content while its layout uses Tailwind. */
        .content { margin: 0 auto; max-width: 1440px; padding: 1.5rem; }
        .box, .small-box { overflow: hidden; border: 1px solid #374151; border-radius: .75rem; background: #1f2937; box-shadow: 0 10px 24px #0002; }
        .box-body, .box-header { padding: 1.25rem; }
        .box-header { border-bottom: 1px solid #374151; }
        .box-title { font-size: 1.125rem; font-weight: 600; }
        .row { display: flex; flex-wrap: wrap; margin: -.5rem; }
        .row > [class*="col-"] { box-sizing: border-box; padding: .5rem; }
        .col-xs-12, .col-md-12, .col-sm-12, .col-lg-12 { width: 100%; }
        .col-xs-6, .col-md-6, .col-sm-6, .col-lg-6 { width: 50%; }
        .col-md-2 { width: 16.6667%; } .col-md-3 { width: 25%; } .col-md-4 { width: 33.3333%; }
        .col-md-5 { width: 41.6667%; } .col-md-8 { width: 66.6667%; } .col-md-11 { width: 91.6667%; }
        .col-lg-6 { width: 50%; } .col-lg-2 { width: 16.6667%; }
        @media(max-width: 767px) { .content { padding: 1rem; } .row > [class*="col-"] { width: 100%; } }
        .form-control { display: block; width: 100%; min-height: 2.5rem; border: 1px solid #4b5563; border-radius: .5rem; background: #111827; color: #f9fafb; padding: .5rem .75rem; }
        .form-control:focus { outline: 2px solid #60a5fa; outline-offset: 1px; }
        textarea.form-control { min-height: 6rem; }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: .4rem; border: 1px solid #4b5563; border-radius: .5rem; padding: .5rem .75rem; color: #f9fafb; text-decoration: none; cursor: pointer; }
        .btn:hover { filter: brightness(1.15); } .btn-primary, .btn-info { background: #2563eb; border-color: #2563eb; }
        .btn-success { background: #059669; border-color: #059669; } .btn-danger { background: #dc2626; border-color: #dc2626; }
        .btn-warning { background: #d97706; border-color: #d97706; } .btn-default { background: #374151; }
        .table-responsive { overflow-x: auto; } .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #374151; padding: .65rem; text-align: left; vertical-align: top; }
        .table thead, .table-striped tbody tr:nth-child(odd) { background: #273449; }
        .text-muted { color: #9ca3af; } .text-danger { color: #f87171; } .text-center { text-align: center; }
        .small-box { padding: 1.25rem; } .small-box h3 { margin: 0; font-size: 1.75rem; font-weight: 700; }
        .small-box p { margin: .25rem 0 0; color: #d1d5db; }
        .bg-aqua { border-color: #0891b2; } .bg-green { border-color: #059669; } .bg-blue { border-color: #2563eb; } .bg-purple { border-color: #7c3aed; }
        .callout { border-left: 4px solid #f59e0b; border-radius: .5rem; background: #292524; padding: 1rem; margin: 1rem 0; }
        .pagination { display: flex; justify-content: center; gap: .25rem; list-style: none; padding: 0; }
        .pagination a, .pagination span { display: block; padding: .4rem .7rem; border-radius: .35rem; background: #374151; color: #e5e7eb; text-decoration: none; }
        .pagination .active span { background: #2563eb; }
    </style>
    @yield('css')
</head>
<body class="min-h-screen antialiased">
    <header class="border-b border-gray-700 bg-gray-900/90">
        <div class="mx-auto flex max-w-screen-2xl flex-wrap items-center justify-between gap-3 px-4 py-3 sm:px-6">
            <a href="{{ url('/') }}" class="text-lg font-bold tracking-wide text-white no-underline">wn <span class="font-normal text-gray-400">Trading Tools</span></a>
            <nav class="flex flex-wrap gap-2 text-sm">
                <a class="rounded-md px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white" href="{{ url('journey') }}">Journey</a>
                <a class="rounded-md px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white" href="{{ url('journey-analysis') }}">Analysis</a>
                <a class="rounded-md px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white" href="{{ url('algorithmic') }}">Algorithmic</a>
                <a class="rounded-md px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white" href="{{ url('quant') }}">Quant</a>
                <a class="rounded-md px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white" href="{{ url('alert') }}">Alerts</a>
                <a class="rounded-md px-3 py-2 text-gray-300 hover:bg-gray-800 hover:text-white" href="{{ url('position_sizing') }}">Position sizing</a>
            </nav>
        </div>
    </header>
    <main class="mx-auto max-w-screen-2xl py-6">
        @yield('content')
    </main>
    @yield('js')
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LPBRPKTYDE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){window.dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-LPBRPKTYDE');
    </script>
</body>
</html>
