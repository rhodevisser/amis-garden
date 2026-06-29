<!doctype html>
<html lang="en" data-theme="cupcake">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ami's Garden</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-base-100 text-base-content">
<x-layout.nav />
<main class="max-w-7xl mx-auto px-4">
    {{ $slot }}
</main>
</body>
</html>
