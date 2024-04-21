<?php
session_start();
$_SESSION['user_id'] ='';
session_destroy();
require_once '../View/get_login.php';
