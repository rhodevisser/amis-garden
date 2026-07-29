<!doctype html>
<html lang="en" data-theme="cupcake" class="h-full bg-base-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ami's Garden</title>
    @vite(['resources/css/app.css'])
</head>
<body class="h-full bg-base-100 text-base-content">
<x-layout.nav />
<main class="max-w-7xl mx-auto px-4">
    {{ $slot }}
</main>
</body>
</html>
