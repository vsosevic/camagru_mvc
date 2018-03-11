<?php if(empty($_SESSION['logged_id_user'])): ?>
    <script type="text/javascript">
        window.location.href = '/login';
    </script>
<?php endif; ?>
<span>My camagru page</span>