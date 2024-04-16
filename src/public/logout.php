<?php
session_start();
$_SESSION['user_id'] ='';
session_destroy();
require_once './get_login.php';
