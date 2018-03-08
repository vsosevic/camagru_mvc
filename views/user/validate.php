<?php if (empty($errmsg)): ?>
<span class='message'>
    Congrats! The user account has been validated and now active.
    Now you can <a href='/login'>Login</a>
</span>
<?php else: ?>
<div class="errmsg">
            <?php echo $errmsg; ?>
</div>
<?php endif; ?>
