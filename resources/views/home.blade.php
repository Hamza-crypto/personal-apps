<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WordPress › Log In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f1f1f1;
            font-family: "Open Sans", sans-serif;
        }
        #login {
            width: 320px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
        }
        #login h1 a {
            background-image: url('https://s.w.org/style/images/login-logo.png');
            background-size: 84px;
            background-repeat: no-repeat;
            background-position: center;
            display: block;
            height: 84px;
            width: 84px;
            margin: 0 auto 25px;
        }
        .button {
            background: #2271b1;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
        }
        .button:hover {
            background: #1e66a0;
        }
        .message {
            margin: 15px 0;
            padding: 12px;
            border-left: 4px solid #2271b1;
            background: #fff;
        }
    </style>
</head>
<body>
    <div id="login">
        <h1><a href="https://wordpress.org/">WordPress</a></h1>
        @if(session('error'))
            <div class="message">{{ session('error') }}</div>
        @endif
        <form action="/wp-login.php" method="POST">
            @csrf
            <p>
                <label for="user_login">Username or Email Address</label>
                <input type="text" name="log" id="user_login" class="form-control" size="20" required>
            </p>
            <p>
                <label for="user_pass">Password</label>
                <input type="password" name="pwd" id="user_pass" class="form-control" size="20" required>
            </p>
            <p class="forgetmenot">
                <input name="rememberme" type="checkbox" id="rememberme" value="forever">
                <label for="rememberme">Remember Me</label>
            </p>
            <p class="submit">
                <button type="submit" class="button">Log In</button>
            </p>
        </form>
        <p id="nav">
            <a href="#">Lost your password?</a>
        </p>
        <p id="backtoblog">
            <a href="/">← Back to My Laravel Site</a>
        </p>
    </div>
</body>
</html>
