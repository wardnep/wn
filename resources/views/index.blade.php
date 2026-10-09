<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>wn</title>
    <link rel="stylesheet" href="/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/vendor/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/vendor/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            box-sizing: border-box;
            font-family: 'Source Sans Pro', sans-serif;
            font-size: clamp(1rem, 0.9rem + 0.5vw, 1.25rem);
        }
        .menu {
            width: 100%;
            max-width: 420px;
            text-align: center;
        }
        .menu-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 24px;
        }
        .menu-group:last-child { margin-bottom: 0; }
        .menu a {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 16px;       /* tap target >= 44px */
            min-height: 44px;
            border-radius: 8px;
            text-decoration: none;
        }
        .menu a:hover,
        .menu a:focus-visible {
            background: rgba(0, 0, 0, .06);
        }
        .menu i {
            width: 1.25em;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="menu">
        <div class="menu-group">
            <a href="{{ url('journey') }}"><i class="fa fa-book" aria-hidden="true"></i> Trading Journey</a>
            <a href="{{ url('quant') }}"><i class="fa fa-cogs" aria-hidden="true"></i> Algorithmic Trading</a>
            <a href="{{ url('alert') }}"><i class="fa fa-bell" aria-hidden="true"></i> Price Alert</a>
        </div>
        <div class="menu-group">
            <a href="{{ url('position_sizing') }}"><i class="fa fa-asterisk" aria-hidden="true"></i> Position Sizing</a>
            <a target="_blank" rel="noopener noreferrer" href="https://github.com/wardnep"><i class="fa fa-rocket" aria-hidden="true"></i> Github</a>
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
