<?php foreach ($images as $image): ?>
<a href='gallery/image/<?php echo $image->id_image; ?>'>
    <img class='user-images-gallery' src='<?php echo $image->image_path; ?>'>
</a>
<?php endforeach; ?>