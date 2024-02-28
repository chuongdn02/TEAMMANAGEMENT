<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome to Home Page</h1>
    <p>hi! i'm NGUYEN VAN CHUONG</p>
    <ul>
        <li><a href="{{ route('departments.index') }}">Department management</a></li>
        <li><a href="{{ route('teams.index') }}">Team management</a></li>
    </ul>
</body>
</html>
