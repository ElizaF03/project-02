<?php
$requestUri=$_SERVER['REQUEST_URI'];
$requestMethod=$_SERVER['REQUEST_METHOD'];
if($requestUri=== '/login'){
    if($requestMethod === 'GET'){
        require_once  './get_login.php';
    }elseif($requestMethod === 'POST'){
        require_once  './post_login.php';
    }else{
        echo "Для адреса $requestUri метод $requestMethod не поддерживается";
    }
}elseif ($requestUri=== '/registration'){
    if($requestMethod === 'GET'){
        require_once  './get_registration.php';
    }elseif($requestMethod === 'POST'){
        require_once  './post_registration.php';
    }else{
        echo "Для адреса $requestUri метод $requestMethod не поддерживается";
    }
}elseif ($requestUri=== '/catalog'){
    require_once  './catalog.php';
}elseif ($requestUri=== '/logout'){
    require_once  './get_login.php';
}else{
    require_once  './404.html';
}