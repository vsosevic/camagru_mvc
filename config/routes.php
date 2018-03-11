<?php
return array(
    // 'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2', //actionView in NewsController
    'save-image' => 'gallery/saveImage', //actionSaveImage in GalleryController
    'gallery' => 'gallery/index', //actionIndex in GalleryController
    'my-camagru' => 'user/index', //actionIndex in UserController
    'signup' => 'user/signup', //actionSignup in UserController
    'validate/(\w+)' => 'user/validate/$1', //actionValidate in UserController
    'validate' => 'user/validate', //actionValidate in UserController
    'login' => 'user/login', //actionLogin in UserController
    'forgot-reset/(\w+)' => 'user/forgotReset/$1', //actionForgotReset in UserController
    'forgot-reset' => 'user/forgotReset', //actionForgotReset in UserController
    'forgot' => 'user/forgot', //actionForgot in UserController
    'logout' => 'user/logout', //actionLogin in UserController
    'settings' => 'user/settings', //actionSettings in UserController
    'news/([0-9]+)' => 'news/view/$1', //actionView in NewsController
    'news' => 'news/index', //actionIndex in NewsController
    'products' => 'product/list', //actionList in ProductController
//    '' => 'gallery/index',

);