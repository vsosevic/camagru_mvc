<?php
return array(
    // 'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2', //actionView in NewsController
    'gallery' => 'gallery/index', //actionIndex in GalleryController
    'my-camagru' => 'user/index', //actionIndex in UserController
    'signup' => 'user/signUp', //actionSignUp in UserController
    'login' => 'user/login', //actionLogin in UserController
    'news/([0-9]+)' => 'news/view/$1', //actionView in NewsController
    'news' => 'news/index', //actionIndex in NewsController
    'products' => 'product/list', //actionList in ProductController
    '' => 'gallery/index',

);