<div class="main-gallery">
    <div class="image-overview">
        <img src="<?php echo $image->image_path ?>">
        <div class="likes-number-btn">
            <span id="number-of-likes" style="font-size: 30px;"><?php echo $number_of_likes; ?></span>
            <a href="#" id="like" <?php if ($is_liked) { echo 'style="display: none"'; } ?>><img src="/files/sources/like.png" width="50"></a>
            <a href="#" id="unlike" <?php if (!$is_liked) { echo 'style="display: none"'; } ?>><img style="background: lightblue; border-radius: 30px;" src="/files/sources/like.png" width="50"></a>
        </div>

        <script type="text/javascript">
            //For scrolling to the bottom comment.
            window.addEventListener('load', documentReady, false);
            function documentReady()
            {
                var objDiv = document.getElementById("comments");
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        </script>

    </div>

    <div style="display: inline-block;" class="comments-block">
        <div class="comments" id="comments">
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <span class="comment-user-name"><?php echo htmlentities($comment->username) . ": " ?></span>
                    <span><?php echo htmlentities($comment->comment); ?></span>
                    <br />
                    <span class="comment-date"><?php echo $comment->date ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        <div>
        <?php if (!isset($_SESSION['logged_id_user'])): ?>
            <span class='errmsg'>To leave comments and be able to like you must be logged in!</span>
        <?php else: ?>
            <form style="text-align: left" method="post" action="/image/<?php echo $image->id_image; ?>/comment" id="comment-form">
                <input type="text" name="comment-text" placeholder="Write a new comment" required="" style="width: 95%;" autofocus>
                <input type="submit" value="Comment">
            </form>
        <?php endif; ?>
        </div>
    </div>
    <div style="clear: both;"></div>
</div>

<div id="share"></div>

<!-- Sharingbutton Facebook -->
<a class="resp-sharing-button__link" href="https://facebook.com/sharer/sharer.php?u=" target="_blank" aria-label="">
    <div class="resp-sharing-button resp-sharing-button--facebook resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--normal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18.77 7.5H14.5V5.6c0-.9.6-1.1 1-1.1h3V.54L14.17.53C10.24.54 9.5 3.48 9.5 5.37V7.5h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
        </div>
    </div>
</a>

<!-- Sharingbutton Google+ -->
<a class="resp-sharing-button__link" href="https://plus.google.com/share?url=<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REDIRECT_URL']; ?>" target="_blank" aria-label="">
    <div class="resp-sharing-button resp-sharing-button--google resp-sharing-button--small"><div aria-hidden="true" class="resp-sharing-button__icon resp-sharing-button__icon--normal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.37 12.93c-.73-.52-1.4-1.27-1.4-1.5 0-.43.03-.63.98-1.37 1.23-.97 1.9-2.23 1.9-3.57 0-1.22-.36-2.3-1-3.05h.5c.1 0 .2-.04.28-.1l1.36-.98c.16-.12.23-.34.17-.54-.07-.2-.25-.33-.46-.33H7.6c-.66 0-1.34.12-2 .35-2.23.76-3.78 2.66-3.78 4.6 0 2.76 2.13 4.85 5 4.9-.07.23-.1.45-.1.66 0 .43.1.83.33 1.22h-.08c-2.72 0-5.17 1.34-6.1 3.32-.25.52-.37 1.04-.37 1.56 0 .5.13.98.38 1.44.6 1.04 1.85 1.86 3.55 2.28.87.23 1.82.34 2.8.34.88 0 1.7-.1 2.5-.34 2.4-.7 3.97-2.48 3.97-4.54 0-1.97-.63-3.15-2.33-4.35zm-7.7 4.5c0-1.42 1.8-2.68 3.9-2.68h.05c.45 0 .9.07 1.3.2l.42.28c.96.66 1.6 1.1 1.77 1.8.05.16.07.33.07.5 0 1.8-1.33 2.7-3.96 2.7-1.98 0-3.54-1.23-3.54-2.8zM5.54 3.9c.32-.38.75-.58 1.23-.58h.05c1.35.05 2.64 1.55 2.88 3.35.14 1.02-.08 1.97-.6 2.55-.32.37-.74.56-1.23.56h-.03c-1.32-.04-2.63-1.6-2.87-3.4-.13-1 .08-1.92.58-2.5zM23.5 9.5h-3v-3h-2v3h-3v2h3v3h2v-3h3z"/></svg>
        </div>
    </div>
</a>
