<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="/src/style/style.css"/>

    <base href="/">
    <script
            src="https://code.jquery.com/jquery-3.5.1.js"
            integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="/src/script/index.js"></script>

</head>
<body>
<?php if (isset($_SESSION['auth'])) : ?>
    Hello, <?php echo $_SESSION['login']; ?><br>
    <a id="logout" href="/customer/logout">logout</a>
<?php else : ?>
    <a id="loginPage" href="/customer/login">Log In</a>
    <a id="registrPage" href="/customer/registration">Registration</a>

<?php endif; ?>

<div id="error" style="color: red;"></div>
<div id="success" style="color: green;"></div>
<div id="result"></div>

<noscript>Include JS or nothing will work</noscript>



</body>
</html>
