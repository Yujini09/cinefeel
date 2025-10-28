<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineFeel - Home</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h1>Welcome to CineFeel!</h1>
        <p>Discover movies based on your mood.</p>
        <a href="{{ route('mood.selection') }}" class="button">Start Mood Selection</a>
    </div>
</body>
</html>
