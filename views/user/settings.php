<?php if(empty($_SESSION['logged'])): ?>
    <script type="text/javascript">
        window.location.href = '/login';
    </script>
<?php endif; ?>

<form method="post" action="settings">
    <h2>Settings</h2>

    <span>Username:</span> <br>
    <input type="text" name="username" placeholder="User Name" value="<?PHP if (isset($user->username)) { echo $user->username; } ?>" required />
    <br />
    <span>Email:</span> <br>
    <input type="email" name="email" placeholder="Email" value="<?PHP if (isset($user->email)) { echo $user->email; } ?>" required />
    <br />
    <input type="checkbox" name="receive-notifications" checked> Receive notifications <br>
    <br />
    <p>To change password go <a href="forgot-reset/<?php echo $user->email ?>">here</a> </p>
    <br />
    <input class="login" type="submit" name="submit" value="Save" />
    <br />
    <?php if (!empty($errmsg)): ?>
        <div class="errmsg"><?php echo $errmsg; ?></div>
    <?php endif; if (!empty($message)): ?>
        <div class="message"><?php  echo $message; ?></div>
    <?php endif; ?>
</form>
