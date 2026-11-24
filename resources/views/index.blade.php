<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>wn</title>
    <link rel="stylesheet" href="/vendor/fontawesome-free/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-gray-950 px-4 py-8 text-lg text-gray-100 antialiased">
    <nav class="w-full max-w-md text-center">
        <h1 class="mb-6 text-2xl font-bold tracking-wide text-white">wn <span class="font-normal text-gray-400">Trading Tools</span></h1>
        <div class="mb-6 flex flex-col gap-2">
            <a class="flex min-h-12 items-center justify-center gap-3 rounded-lg border border-gray-700 bg-gray-900 px-4 py-3 text-gray-100 no-underline transition hover:border-blue-500 hover:bg-gray-800 hover:text-blue-300" href="{{ url('journey') }}"><i class="fa fa-book text-blue-400" aria-hidden="true"></i> Trading Journey</a>
            <a class="flex min-h-12 items-center justify-center gap-3 rounded-lg border border-gray-700 bg-gray-900 px-4 py-3 text-gray-100 no-underline transition hover:border-blue-500 hover:bg-gray-800 hover:text-blue-300" href="{{ url('algorithmic') }}"><i class="fa fa-cogs text-blue-400" aria-hidden="true"></i> Algorithmic Trading</a>
            <a class="flex min-h-12 items-center justify-center gap-3 rounded-lg border border-gray-700 bg-gray-900 px-4 py-3 text-gray-100 no-underline transition hover:border-blue-500 hover:bg-gray-800 hover:text-blue-300" href="{{ url('quant') }}"><i class="fa fa-backward text-blue-400" aria-hidden="true"></i> Quant Trading</a>
            <a class="flex min-h-12 items-center justify-center gap-3 rounded-lg border border-gray-700 bg-gray-900 px-4 py-3 text-gray-100 no-underline transition hover:border-blue-500 hover:bg-gray-800 hover:text-blue-300" href="{{ url('alert') }}"><i class="fa fa-bell text-blue-400" aria-hidden="true"></i> Alert</a>
        </div>
        <div class="flex flex-col gap-2">
            <a class="flex min-h-12 items-center justify-center gap-3 rounded-lg border border-gray-700 bg-gray-900 px-4 py-3 text-gray-100 no-underline transition hover:border-blue-500 hover:bg-gray-800 hover:text-blue-300" href="{{ url('position_sizing') }}"><i class="fa fa-asterisk text-blue-400" aria-hidden="true"></i> Position Sizing</a>
            <a class="flex min-h-12 items-center justify-center gap-3 rounded-lg border border-gray-700 bg-gray-900 px-4 py-3 text-gray-100 no-underline transition hover:border-blue-500 hover:bg-gray-800 hover:text-blue-300" target="_blank" rel="noopener noreferrer" href="https://github.com/wardnep"><i class="fa fa-rocket text-blue-400" aria-hidden="true"></i> Github</a>
        </div>
    </nav>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-LPBRPKTYDE"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-LPBRPKTYDE');
    </script>
</body>
</html>
