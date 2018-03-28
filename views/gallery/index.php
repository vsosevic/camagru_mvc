<?php foreach ($images as $image): ?>
    <div class="div-gallery-image">
        <a href='/gallery/image/<?php echo $image->id_image; ?>' target="_blank">
            <img class='user-images-gallery' src='<?php echo $image->image_path; ?>'>
        </a>
    </div>
<?php endforeach; ?>

<script>

    var scrolled_page = 1;

    var infiniteScroll = debounce(function() {
        var bodyHeight = document.body.getBoundingClientRect().height;
        var windowHeight = window.innerHeight;
        var windowScrollTop = window.pageYOffset;

        // if only 20px of content is not shown yet, load more content.
        if( bodyHeight - 20 <= windowScrollTop + windowHeight) {
            var xmlhttp1 = new XMLHttpRequest();
            xmlhttp1.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);

                    response.forEach(function(image) {
                        var newImg = document.createElement('div');
                        newImg.className = 'div-gallery-image';
                        newImg.innerHTML = '<a href="/gallery/image/' + image.id_image + '" target="_blank"><img class="user-images-gallery" src="' + image.image_path + '"></a>';
                        document.body.appendChild(newImg);
                    });
                    scrolled_page++;
                };
            };
            xmlhttp1.open("GET", "/load-more-images/" + scrolled_page, true);
            xmlhttp1.send();
        }
    }, 250);

    window.addEventListener('scroll', infiniteScroll);
    window.addEventListener('mousewheel', infiniteScroll);

    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

</script>
