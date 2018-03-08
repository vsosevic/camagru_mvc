<?php if(empty($_SESSION['logged'])): ?>
    <script type="text/javascript">
        window.location.href = '/login';
    </script>
<?php endif; ?>
<span>My camagru page</span>