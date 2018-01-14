<!DOCTYPE html>
<html>
<head>
    <title>Camagru</title>
    <link rel="stylesheet" type="text/css" href="template/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
<?php session_start(); ?>

<header class="header-menu">
    <a class="header-item" href="myCamagru">myCamagru</a>
    <a class="header-item" href="gallery">Gallery</a>
    <?php if (isset($_SESSION) && !empty($_SESSION['logged'])) {?>
        <a class="header-item-login-logout" href="logout.php">Logout</a><?php }
    else { ?>
        <a class="header-item header-item-login-logout" href="login.php">Login</a>
        <a class="header-item header-item-login-logout" href="signup.php">SignUp</a><?php }
    ?>
</header>