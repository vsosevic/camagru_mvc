<?php if(empty($_SESSION['logged_id_user'])): ?>
    <script type="text/javascript">
        window.location.href = '/login';
    </script>
<?php endif; ?>


<script type="text/javascript" src="js/script.js"></script>
<main class="main-camera">

    <div class="left">
        <div class="video-container">
            <video id="video" width="640" height="480" autoplay></video>
            <img id="frame" src="" />
            <canvas id="canvas-for-upload" width="640" height="480"></canvas>
            <button id="take-photo" disabled></button>
        </div>
        <span>You can choose a file from your device: </span>
        <input id="upload" type="file" accept="image/*">
        <div class="frame-images">
            <img class="frame-img" id="beard" src="images/beard.png" width="100px" height="auto" >
            <img class="frame-img" id="dog" src="images/dog.png" width="100px" height="auto" >
            <img class="frame-img" id="hair" src="images/hair.png" width="100px" height="auto" >
            <img class="frame-img" id="hat1" src="images/hat1.png" width="100px" height="auto" >
            <img class="frame-img" id="hat2" src="images/hat2.png" width="100px" height="auto" >
            <img class="frame-img" id="moustache-man" src="images/moustache-man.png" width="100px" height="auto" >
        </div>

        <canvas id="canvas" width="640" height="480"></canvas>
    </div>


<!--    <side class="side-camera" id='side-camera'>-->
<!--        --><?php
//        require('connect.php');
//        $images = $connection->query("SELECT * FROM images WHERE userID='" . $_SESSION['UserID'] . "' ORDER BY ImageDate DESC");
//        foreach ($images as $image) {
//            echo "<div class='div-image-and-del'><a href='image-page.php?imageID=". $image['Id'] ."'><img class='user-images' src='" . $image['ImagePath'] . "'></a><a href='delete.php?imageID=" . $image['Id'] . "'><img class='delete-image' src='images/del.png'></div></a>";
//        }
//        ?>
<!--    </side>-->
    <div style="clear: both;"></div>

</main>