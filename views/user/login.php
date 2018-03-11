<form method="post" style="align-content: center;" action="/login">
    <h2>Login</h2>
    <input name="username" placeholder="User name" value="" autofocus />
    <br />
    <input type="Password" name="password" placeholder="Enter Password" value="" />
    <br />
    <input class="login" type="submit" name="submit" value="Login" />
    <br />
    <a href="/forgot" style="font-size: 12px;">Forgot password?</a>
    <br />
    <?php if (isset($err_msg)): ?>
        <div class="errmsg">
            <?php echo $err_msg; ?>
        </div>
    <?php elseif(isset($_SESSION['logged_id_user'])): ?>
        <script type="text/javascript">
            window.location.href = '/my-camagru';
        </script>
    <?php endif; ?>
</form>
