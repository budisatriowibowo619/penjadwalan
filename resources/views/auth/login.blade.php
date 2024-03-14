<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Penjadwalan App | {{ isset($page) ? $page : "Page"; }}</title>

    <link rel="icon" type="image/png" href="">

    <!-- Start CSS -->
    <link rel="stylesheet" href="{{ asset('custom/login.css') }}">
    <!-- End CSS -->
    
</head>

<body class="bg-login">
    
    <div class="container">
        <form action="#" id="formLogin" method="POST" class="form">
            <p class="title">Login Form</p>
            <input name="name" placeholder="Username" class="username input" type="text">
            <input name="password" placeholder="Password" class="password input" type="password">
            <button id="btnLogin" class="btn" type="submit">Login</button>
        </form>
    </div>

</body>

    <!-- Start JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <?= isset($js_script) ? '<script type="text/javascript" src="'.asset($js_script).'"></script>' : ""; ?>
    <!-- End JS -->
</html>