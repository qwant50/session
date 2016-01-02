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
//sleep (60);

require_once 'include/sess.php';

sess_start();

echo $_COOKIE['PHPSESSID'];
//var_dump($_SESS);

echo $_SESS["id"];
$_SESS["id"] = 43;
$_SESS["self"] = "two";
$_SESS["test"] = 0;
echo '<br>';
//echo sess_encode();

// my - id|i:42;self|s:3:"two";test|i:0;
// ph - id|i:42;self|s:3:"two";test|i:0;