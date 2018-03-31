<div class="main-gallery">
    <div class="image-overview">
        <img src="<?php echo $image->image_path ?>">
        <div class="likes-number-btn">
            <span id="number-of-likes" style="font-size: 30px;"><?php echo $number_of_likes; ?></span>
            <a href="#" id="like" <?php if ($is_liked) { echo 'style="display: none"'; } ?>><img src="/files/sources/like.png" width="50"></a>
            <a href="#" id="unlike" <?php if (!$is_liked) { echo 'style="display: none"'; } ?>><img style="background: lightblue; border-radius: 30px;" src="/files/sources/like.png" width="50"></a>
        </div>

        <script type="text/javascript">
            <!-- Pluso BEGIN -->
            (function() {
                if (window.pluso)if (typeof window.pluso.start == "function") return;
                if (window.ifpluso==undefined) { window.ifpluso = 1;
                    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
                    var h=d[g]('body')[0];
                    h.appendChild(s);
                }})();
            <!-- Pluso END -->

            //For scrolling to the bottom comment.
            window.addEventListener('load', documentReady, false);
            function documentReady()
            {
                var objDiv = document.getElementById("comments");
                objDiv.scrollTop = objDiv.scrollHeight;
            }
        </script>
        <div class="pluso" data-background="transparent" data-options="small,square,line,horizontal,counter,theme=04" data-services="facebook,google,email,print"></div>

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
        <?php if (!isset($_SESSION['logged_id_user'])): ?>
            <span class='errmsg' style='width: 100%; text-align: center;'>To leave comments and be able to like you must be logged in!</span>
        <?php else: ?>
            <form style="text-align: left" method="post" action="/image/<?php echo $image->id_image; ?>/comment" id="comment-form">
                <input type="text" name="comment-text" placeholder="Write a new comment" required="" style="width: 95%;" autofocus>
                <input type="submit" value="Comment">
            </form>
        <?php endif; ?>
    </div>
    <div style="clear: both;"></div>
</div>

<script type="text/javascript" src="/js/like.js"></script>
