<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 12/25/15
 * Time: 3:20 PM
 */
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

//session_start();

require_once 'include/sess.php';

sess_start();

echo $_SESS["id"];
$_SESS["id"] = 42;

