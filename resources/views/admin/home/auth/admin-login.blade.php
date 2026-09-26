<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin login</title>
    <style>
        body{
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background: #1B2631;
          }

          .box{
            width: 300px;
            padding: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background: #191919;
            text-align: center;
            border-radius: 20px 20px;
          }
          .box h1{
            color: white;
            text-transform: uppercase;
            font-weight: 500*;
            background: linear-gradient(
              to right,
              hsl(1 100% 50%),
              hsl(100 100% 50%)
            );
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
          }
          .box input[type = "text"],.box input[type = "password"]{
            border:0;
            background: none;
            display: block;
            margin: 5px auto;
            text-align: center;
            border: 2px solid #D4AC0D;
            padding: 14px 10px;
            width: 200px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.5s;
          }
          .box input[type = "text"]:focus,.box input[type = "password"]:focus{
            border-color: #A04000;
            width: 250px;
          }
          .box input[type = "text"]:hover,.box input[type = "password"]:hover{
            border-color: #A04000;
          }
          .box input[type = "submit"]{
            border:0;
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #D4AC0D;
            padding: 14px 40px;
            outline: none;
            color: white;
            transition: 0.25s;
            cursor: pointer;
          }
          .box input[type = "submit"]:focus{
            border-color: #D4AC0D;
          }
          .box input[type = "submit"]:hover{
            background: #A04000;
            border-radius: 24px;
            border: transparent;
          }

          a {
            font-family: "Dank Mono", ui-monospace, monospace;
            background: linear-gradient(
              to right,
              hsl(98 100% 62%),
              hsl(204 100% 59%)
            );
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
          }
    </style>
</head>
<body>
    <form class="box" action="{{ route('admin.login') }}" method="post">
        @csrf
        <h1>Admin Login</h1>
        <input type="text" name="email" placeholder="Enter Email">
        <input type="password" name="password" placeholder="Enter password">
        <input type="submit" value="Login">
        <a href="{{ url('/') }}" target="_blank">Home</a>
        @if(Session::has('error'))
            <p style="color: red;">{{ Session::get('error') }}</p>
        @endif
        @if(Session::has('success'))
            <p style="color: green;">{{ Session::get('success') }}</p>
        @endif

    </form>
</body>
</html>
