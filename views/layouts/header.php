<!DOCTYPE html>
<html>
<head>
    <title>Camagru</title>
    <link href="/template/css/style.css" rel="stylesheet" type="text/css" media="screen" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
<?php session_start(); ?>

<header class="header-menu">
    <a class="header-item" href="my-camagru">myCamagru</a>
    <a class="header-item" href="gallery">Gallery</a>
    <?php if (isset($_SESSION) && !empty($_SESSION['logged'])) {?>
        <a class="header-item-login-logout" href="logout">Logout</a><?php }
    else { ?>
        <a class="header-item header-item-login-logout" href="login">Login</a>
        <a class="header-item header-item-login-logout" href="signup">SignUp</a><?php }
    ?>
</header>