<!doctype html>
<html lang="en">
<head>
    <title>Testing task</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@if(count($users) > 0)
    <table>
        <thead>
        <tr>
            <td>Id</td>
            <td>Name</td>
            <td>Username</td>
            <td>Address</td>
            <td>Phone</td>
            <td>Website</td>
            <td>Company</td>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->website }}</td>
                <td>{{ $user->company }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif
</body>
</html>
