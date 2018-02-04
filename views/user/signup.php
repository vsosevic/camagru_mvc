<form method="post" style="align-content: center;" action="signup">
    <h2>SignUp</h2>
    <input type="text" name="username" placeholder="User Name" value="<?PHP if (isset($_POST['name'])) { echo $_POST['name']; } ?>" required />
    <br />
    <input type="email" name="email" placeholder="Email" value="<?PHP if (isset($_POST['email'])) { echo $_POST['email']; } ?>" required />
    <br />
    <input type="password" name="password" placeholder="Enter Password" value="" required />
    <br />
    <input type="password" name="password-repeat" placeholder="Repeat Password" value="" required />
    <br />
    <input class="login" type="submit" name="submit" value="Subscribe" />
    <br />
    <?php if (!empty($errmsg)): ?>
        <div class="errmsg"><?php echo $errmsg; ?></div>
    <?php endif; if (!empty($message)): ?>
        <div class="message"><?php  echo $message; ?></div>
    <?php endif; ?>
</form>