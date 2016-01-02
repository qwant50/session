<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 12/25/15
 * Time: 5:43 PM
 */

function sess_start()
{

    $cookieName = ini_get('session.name');
    $path = ini_get('session.save_path');

    if (isset($_COOKIE[$cookieName])) {
        $file = $path . DIRECTORY_SEPARATOR . 'sess_' . $_COOKIE[$cookieName];
        if (!file_exists($file)) return false;
        $buf = file_get_contents($file);
        sess_decode($buf);
    } else {
        $id = md5(uniqid(rand(),1));
        $_COOKIE[$cookieName] = $id;
        $GLOBALS['_SESS'] = [];
        $file_name = 'sess_' . $_COOKIE[$cookieName];
        file_put_contents($path . DIRECTORY_SEPARATOR . $file_name, '');
    };
    register_shutdown_function('sess_write_close');
}

function sess_write_close()
{
    $path = ini_get('session.save_path');
    $cookieName = ini_get('session.name');
    $file_name = 'sess_' . $_COOKIE[$cookieName];
    file_put_contents($path . DIRECTORY_SEPARATOR . $file_name, sess_encode());
    setcookie($cookieName, $_COOKIE[$cookieName]);

}

function sess_encode(){

    $buf = serialize($GLOBALS['_SESS']);
    if ($buf) {
        preg_match('/^a:\\d+:{/', $buf, $matches);
        $buf = substr($buf,  strlen($matches[0]), -2);
        preg_match('/\\d+/', $matches[0], $matches);
        $count = (int)$matches[0];
        $matches = explode(";", $buf);
        $encoded_string = '';
        for ( $i = 0; $i < $count*2; $i+=2):
            // get name
            $format = explode(":", $matches[$i]);
            // remove ??????? ???????
            $format[2] = substr($format[2], 1, -1);
            // get value
            //$value = explode(":", $matches[$i+1]);
            // set
            $encoded_string .= $format[2].'|'.$matches[$i+1].';';
        endfor;
        return $encoded_string;
    }
};

function sess_decode($buf){

    $decoded_string = '';
    $buf = substr($buf, 0, -1);
    $matches = explode(";", $buf);
    foreach ($matches as $argument):
        $seed = explode('|', $argument);
        $decoded_string .= 's:'.strlen($seed[0]).':"'.$seed[0].'";'.$seed[1].';';
    endforeach;
    $decoded_string = 'a:'.count($matches).':{'.$decoded_string.'}';

    $GLOBALS['_SESS'] = unserialize($decoded_string);
    return true;

};