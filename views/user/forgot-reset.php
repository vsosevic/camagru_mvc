<form class="form-forgot" method="POST" action="/forgot-reset">
    <h2 class="form-forgot-heading">Password reset</h2>
    <?php if (!empty($message)) : ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <p class="form-forgot-text">Enter your new password and reset key from email.</p>
    <div class="input-group-forgot">
        <input type="Password" name="new-password" placeholder="Enter new password" value="" required />
        <!--        <span class="errmsg">--><?php //echo $errmsg; ?><!--</span>-->
        <br />
        <input type="Text" name="reset-key" placeholder="Reset key from email" value="" required />
        <br />
    </div>
    <br />
    <button class="btn-submit-reset-password" type="submit">Reset password</button>
    <?php if (!empty($errmsg)): ?>
        <div class="errmsg">
            <?php echo $errmsg; ?>
        </div>
    <?php endif; ?>
</form>

<!--<span class="errmsg">--><?php //echo $errmsg; ?><!--</span>-->
<!--<span class="message">--><?php //echo $message; ?><!--</span>-->