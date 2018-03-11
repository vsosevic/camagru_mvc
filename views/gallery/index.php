<?php foreach ($images as $image): ?>
<a href='gallery/image/<?php echo $image->id_image; ?>'>
    <img class='user-images' src='<?php echo $image->image_path; ?>'>
</a>
<?php endforeach; ?>