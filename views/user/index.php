<?php if(empty($_SESSION['logged_id_user'])): ?>
    <script type="text/javascript">
        window.location.href = '/login';
    </script>
<?php endif; ?>


<script type="text/javascript" src="js/script.js"></script>
<main class="main-camera">

    <div class="left">
        <div class="video-container">
            <img id="frame" src="files/sources/blank.png" />

            <video id="video" width="640" height="480" autoplay></video>
            <canvas id="canvas-for-upload" width="640" height="480"></canvas>
            <button id="take-photo" disabled></button>
        </div>
        <span>You can choose a file from your device: </span>
        <input id="upload" type="file" accept="image/*">
        <div class="frame-images">
            <img class="frame-img" id="beard" src="files/sources/beard.png" width="100px" height="auto" >
            <img class="frame-img" id="dog" src="files/sources/dog.png" width="100px" height="auto" >
            <img class="frame-img" id="hair" src="files/sources/hair.png" width="100px" height="auto" >
            <img class="frame-img" id="hat1" src="files/sources/hat1.png" width="100px" height="auto" >
            <img class="frame-img" id="hat2" src="files/sources/hat2.png" width="100px" height="auto" >
            <img class="frame-img" id="moustache-man" src="files/sources/moustache-man.png" width="100px" height="auto" >
        </div>

        <canvas id="canvas" width="640" height="480"></canvas>
    </div>


<!--    <side class="side-camera" id='side-camera'>-->
<!--        --><?php
//        require('connect.php');
//        $images = $connection->query("SELECT * FROM images WHERE userID='" . $_SESSION['UserID'] . "' ORDER BY ImageDate DESC");
//        foreach ($images as $image) {
//            echo "<div class='div-image-and-del'><a href='image-page.php?imageID=". $image['Id'] ."'><img class='user-images' src='" . $image['ImagePath'] . "'></a><a href='delete.php?imageID=" . $image['Id'] . "'><img class='delete-image' src='files/sources/del.png'></div></a>";
//        }
//        ?>
<!--    </side>-->
    <div style="clear: both;"></div>

</main>