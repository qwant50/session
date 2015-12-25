<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 12/25/15
 * Time: 5:43 PM
 */
$_SESS = array();

function sess_start(){

    global $_SESS;
    $path = ini_get('session.save_path');

    if (isset($_COOKIE["PHPSESSID"])) {
        $file_name = 'sess_'.$_COOKIE["PHPSESSID"];
        $buf = file_get_contents($path.DIRECTORY_SEPARATOR.$file_name);
        $_SESS = unserialize($buf);
    }
    else {
        $id = uniqid();
        setcookie("PHPSESSID", $id);
        $_COOKIE["PHPSESSID"] = $id;

    };
    register_shutdown_function('myShutdown');
}

function myShutdown()
{
    global $_SESS;
    if (isset($_COOKIE["PHPSESSID"])) {
        $path = ini_get('session.save_path');
        $file_name = 'sess_'.$_COOKIE["PHPSESSID"];
        $buf = serialize($_SESS);
        file_put_contents($path.DIRECTORY_SEPARATOR.$file_name, $buf);

    }
};