<?php
/**
 * Created by PhpStorm.
 * User: xkq
 * Date: 2017/11/1 0001
 * Time: 22:37
 */
set_include_path(dirname(dirname(__FILE__)));
include_once("inc/init.php");
if (!session_id()) session_start();

$action = crequest("action");
$action = $action == '' ? 'province' : $action;

switch ($action)
{
    case "region";
        region();
        break;
}

function region(){
    global $db;
    $regionid = irequest('regionid');
    $sql 		= "SELECT * FROM areas WHERE parentid = '{$regionid}'";
    $arr 		= $db->get_all($sql);
    echo json_encode($arr);
    exit;
}

