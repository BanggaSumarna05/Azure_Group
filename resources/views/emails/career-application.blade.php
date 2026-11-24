<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Career Application</title>
</head>
<body>
    <h1>New Career Application</h1>
    <p><strong>Position:</strong> {{ $career->title }}</p>
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
    @if(!empty($data['message']))
        <p><strong>Message:</strong></p>
        <p>{{ $data['message'] }}</p>
    @endif
</body>
</html>
