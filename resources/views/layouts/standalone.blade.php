<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | SkillSphere Developer Docs</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">
    @yield('content')

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        
        code, pre {
            font-family: 'Fira Code', monospace;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        
        pre {
            padding: 1rem;
            overflow-x: auto;
        }
    </style>
</body>
</html>
